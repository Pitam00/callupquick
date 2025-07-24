<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtp;
use App\Models\Otp;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OtpAuthController extends Controller
{

     public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'mobile' => 'nullable|digits:10',
        ]);

        if (!$request->email && !$request->mobile) {
            return response()->json([
                'error' => 'Either email or mobile is required'
            ], 422);
        }

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        $otpExpiresAt = Carbon::now()->addMinutes(10);

        if ($request->email) {
            // Handle email login/signup
            $user = User::updateOrCreate(
                ['email' => $request->email],
                ['email' => $request->email] // Just update email if exists
            );
            // dd($user);
            // $user = User::

            // Store OTP in otp_table
            Otp::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'otp' => $otp,
                    'otp_expire' => $otpExpiresAt,
                    'status' => 'pending'
                ]
            );

            return response()->json([
                'message' => 'OTP generated successfully',
                'email' => $request->email,
                'otp' => $otp, // Return OTP for testing
                'user_id' => $user->user_id
            ]);
        } else {
            // Handle mobile login/signup
            $user = User::updateOrCreate(
                ['phone' => $request->mobile],
                ['phone' => $request->mobile]
            );


            // Store OTP in otp_table
            Otp::updateOrCreate(
                ['user_id' => $user->user_id],
                [
                    'otp' => $otp,
                    'otp_expire' => $otpExpiresAt,
                    'status' => 'pending'
                ]
            );

            return response()->json([
                'message' => 'OTP generated successfully',
                'mobile' => $request->mobile,
                'otp' => $otp, // Return OTP for testing
                'user_id' => $user->user_id
            ]);
        }
    }

    public function verifyOtp(Request $request)
    {

        // dd($request->user_id);
        $u_id = $request->user_id;
        $request->validate([
            'user_id' => 'required|integer',
            'otp' => 'required|digits:6',
        ]);

        // Find valid OTP
        $otpRecord = Otp::where('user_id', $request->user_id)
                       ->where('otp', $request->otp)
                       ->where('otp_expire', '>', Carbon::now())
                       ->where('status', 'pending')
                       ->first();


        if (!$otpRecord) {
            return response()->json([
                'error' => 'Invalid OTP or OTP expired'
            ], 401);
        }

        // Mark OTP as used
        $otpRecord->update(['status' => 'verified']);


        $user = User::find($u_id); // Correct way
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user->only(['user_id', 'email', 'phone']),
            'message' => 'OTP verified successfully'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
