<?php

namespace App\Http\Controllers\Api\Auth;
// Controller
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgetPassword;
// Requests
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPassword;
use App\Http\Requests\Auth\TokenRequest;
// Illuminate
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
// Models
use App\Models\User;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    // Get a JWT via given credentials.
    public function login(LoginRequest $request)
    {
        $database = $request->header('Database-App');
        $token = auth()->claims(['database' => $database])->attempt(array_merge($request->safe()->only(['email', 'password']), ['is_active' => 1]));
        $deviceToken = auth_user()->update(['device_token' => $request->validated('device_token')]);
        if (!$token) {
            return messageResponse('Email or Password incorrect.', false, 401);
        }
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
            return contentResponse(auth()->user()->load('member', 'buy_sells', 'jobs'));
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
    public function forgetPassword(ForgetPassword $request)
    {
        $status = Password::sendResetLink($request->validated());
        return $status[0] === Password::RESET_LINK_SENT ? messageResponse($status[0]) : messageResponse($status[0], false, $status[1]);
    }

    // Reset Password
    public function resetPassword(ResetPassword $request)
    {
        $status = Password::reset($request->validated(), function (User $user, string $password) {
            $user->forceFill(['password' => $password])->setRememberToken(Str::random(60));
            $user->save();
            event(new PasswordReset($user));
        });
        return $status[0] === Password::PASSWORD_RESET ? messageResponse($status[0]) : messageResponse($status[0], false, $status[1]);
    }

    // Change Password
    public function changePassword(ChangePasswordRequest $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Update the user's password
        $user->forceFill(['password' => $request->validated('new_password')])->save();

        // Optionally, reset the remember token to force the user to log in again
        $user->setRememberToken(Str::random(60));
        $user->save();

        // Return a success message response
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
