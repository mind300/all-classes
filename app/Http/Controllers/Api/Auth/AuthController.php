<?php

namespace App\Http\Controllers\Api\Auth;
// Controller
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgetPassword;
// Requests
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\OtpRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPassword;
use App\Http\Requests\Auth\TokenRequest;
// Illuminate
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
// Models
use App\Models\User;
use App\Notifications\OtpNotification;
use Carbon\Carbon;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $otp;

    public function __construct()
    {
        $this->otp = new Otp();
    }

    // Get a JWT via given credentials.
    public function login(LoginRequest $request)
    {
        $database = $request->header('Database-App');
        $token = auth()->claims(['database' => $database])->attempt(array_merge($request->safe()->only(['email', 'password']), ['is_active' => 1]));
        if (!$token) {
            return messageResponse('Email or Password incorrect.', false, 401);
        }
        $deviceToken = auth_user()->update(['device_token' => $request->validated('device_token')]);
        return authResponse($token, 'Login Successfully');
    }

    // Get a JWT via given registred.
    public function register(RegisterRequest $request)
    {
        $database = $request->header('Database-App');
        $user = User::create($request->validated());
        $token = auth()->claims(['database' => $database])->login($user);
        return authResponse($token, 'Login Successfully');
    }

    // Get the authenticated User.
    public function me()
    {
        if (Config::get('database.default') == 'suppliers') {
            return contentResponse(auth_user()->load('profile'));
        }
        if (Config::get('database.default') == 'community_1') {
            return contentResponse(auth()->user()->load('member.media', 'buy_sells', 'jobs'));
        }
        return contentResponse(auth()->user());
    }

    // Log the user out (Invalidate the token).
    public function logout()
    {
        auth()->logout();
        return messageResponse('Logged Out Successfully');
    }

    // Forget Password
    public function passwordForget(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();
        $otp = $this->otp->generate($user->email, 'numeric', 4, 15);
        $user->notify(new OtpNotification($otp->token));
        return messageResponse('OTP generated successfully');
    }

    /**
     * Validate OTP and Generate JWT Token with 1-Minute Expiry
     */
    public function otpCheck(OtpRequest $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|min:4'
        ]);

        // Validate OTP
        $otpValidation = $this->otp->validate($request->email, $request->otp);
        if (!$otpValidation->status) {
            return messageResponse('OTP not valid', false, 422);
        }

        // Get user
        $user = User::where('email', $request->email)->first();

        // Generate JWT token with 1-minute expiry
        $token = JWTAuth::claims([
            'email' => $request->email,
            'exp' => Carbon::now()->addWeek(1)->timestamp
        ])->fromUser($user);
        return messageResponse('OTP verified successfully', token: $token);
    }

    // Reset Password
    public function passwordReset(ResetPassword $request)
    {
        try {
            // Verify token and extract email
            $payload = JWTAuth::setToken($request->token)->getPayload();
            $email = $payload->get('email');
            $exp = $payload->get('exp');

            // Check if the token has expired
            if (Carbon::now()->timestamp > $exp) {
                return messageResponse('Token has expired', false, 401);
            }

            // Get user from email
            $user = User::where('email', $email)->first();
            if (!$user) {
                return messageResponse('Error occured user not found', false, 404);
            }
            // Update password securely
            $user->password = $request->password;
            $user->save();
            JWTAuth::invalidate($request->token);
            return messageResponse();
        } catch (JWTException $e) {
            return messageResponse('Invalid or expired token', false, 401);
        }
    }

    // Change Password
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        $user->forceFill(['password' => $request->validated('new_password')])->save();
        $user->setRememberToken(Str::random(60));
        $user->save();
        return messageResponse('Password changed successfully');
    }


    // Check Token Reset
    public function checkToken(TokenRequest $request)
    {
        $user = User::firstWhere('email', $request->validated('email'));
        $status = Password::tokenExists($user, $request->validated('token'));
        return $status ? messageResponse() : messageResponse($status, false, 403);
    }

    // Check Token Reset
    public function permissions()
    {
        $permssions = auth_user()->permissions->pluck('name');
        return contentResponse($permssions);
    }

    // Refresh a token.
    public function refresh()
    {
        $token = auth()->refresh();
        return authResponse($token, 'Refresh token successfully');
    }
}
