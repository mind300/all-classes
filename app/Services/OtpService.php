<?php

namespace App\Services;

use Ichtrojan\Otp\Otp;

class OtpService
{
    protected $otp;

    public function __construct()
    {
        $this->otp = new Otp;
    }

    /**
     * Generate an OTP
     */
    public function generateOtp($identifier)
    {
        return $this->otp->generate($identifier, 3); // 3 minutes expiry
    }

    /**
     * Validate OTP and regenerate if expired
     */
    public function validateOtp($identifier, $otpCode)
    {
        $otpData = $this->otp->validate($identifier, $otpCode);

        if (!$otpData->status) {
            if ($otpData->message === "OTP has expired") {
                return $this->generateOtp($identifier);
            }
            return response()->json(['error' => 'Invalid OTP'], 422);
        }
        return response()->json(['success' => 'OTP is valid'], 200);
    }
}
