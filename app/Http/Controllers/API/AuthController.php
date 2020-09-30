<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

// Models
use App\User;

// Helpers
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

// Requests 
use App\Http\Requests\API\RegistrationRequest;
use App\Http\Requests\API\PasswordResetRequest;
use App\Http\Requests\API\PasswordResetWithTokenRequest;

// Resources (Response formatting)
use App\Http\Resources\API\UserResource;

// Mail Templates
use App\Mail\ResetPassword;
use App\Mail\ResetPasswordSuccess;

class AuthController extends Controller
{
    // User Registration
    public function register(RegistrationRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
 
        $token = $user->createToken('bagajob-API')->accessToken;
            
        $DBuser = User::where('email', '=', $request->email)
        ->first();
        
        return response()->json([
            'success' => [ 'token' => $token ],
            'user' => new UserResource($DBuser)
        ], 200);
    }

    // Validating Password Reset Request
    //    Sends email to user with reset token if it's a valid request 
    public function validatePasswordRequest(PasswordResetRequest $request)
    {   
        $userEmail = $request->email;
        // Get user using email from request
        $user = User::where('email', '=', $userEmail)
        ->first();
        
        // Check if the user exists
        if (!$user) {
            return response()->json([
                'message' => 'An account does not exist with this email address',
            ], 400);
        }

        // Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $userEmail,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);

        // Get the token just created above
        $tokenData = DB::table('password_resets')
        ->where('email', $userEmail)->first();
        
        // Generate, the password reset link. The email and token generated is embedded in the link
        $link = config('app.url') . 'password-reset/?email=' . urlencode($user->email) . '&' . 'token=' . urlencode($tokenData->token);
        
        // Create Mailable Object for the Email
        $emailTemplate = (new ResetPassword($link))
            ->to($user)
            ->subject(config('app.name') . " - " . "Password Reset Request");

        // Send Email
        try {
            Mail::to($user)->send($emailTemplate);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error has occured sending the reset password email, please try again',
                'error' => $e->getMessage()
            ], 400);
        }

        // Success
        return response()->json([
            'message' => 'Reset Password email successfully sent',
        ]);
    }

    public function resetPassword(PasswordResetWithTokenRequest $request)
    {
        $password = $request->password;

        // Validate the token
        $tokenData = DB::table('password_resets')
        ->where('token', $request->only('token'))->first();

        // Send 400 response if the token is invalid
        if (!$tokenData) return response()->json([
                'message' => 'Password token invalid, please submit a new password reset request',
            ], 400);

        $user = User::where('email', $tokenData->email)->first();

        // Send 400 response if the email is invalid
        if (!$user) return response()->json([
            'message' => 'User with this Email not found, please submit a new password reset request',
        ], 400);

        // Hash and update the new password in the User
        $user->fill(["password" => Hash::make($password)])->save();

        // Delete the reset token
        DB::table('password_resets')->where('email', $user->email)
        ->delete();

        // make Mailable Object from template
        $emailTemplate = (new ResetPasswordSuccess())
            ->to($user)
            ->subject(config('app.name') . " - " . " Password Reset Success");

        // Send Reset Success Email
        try {
            Mail::to($user)->send($emailTemplate);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error has occured sending the reset password success email, password may still have been reset successfully',
                'error' => $e->getMessage()
            ], 400);
        }

        // Success
        // Returns User Object and Token so user can be logged in immediately
        return response()->json([
            'message' => 'Password Reset Successful',
            'user' => new UserResource($user),
            'token' => $user->createToken('bagajob-API')->accessToken
        ]);
    }
}
