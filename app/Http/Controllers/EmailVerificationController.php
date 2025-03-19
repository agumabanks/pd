<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    public function verify(Request $request)
    {
        // Get the token from the URL query parameter
        $token = $request->query('token');

        // Find the user with the matching confirmation token
        $user = User::where('confirmation_token', $token)->first();

        if ($user) {
            // Mark the email as verified
            $user->email_verified_at = now();
            $user->confirmation_token = null; // Clear the token to prevent reuse
            $user->save();

            // Log the user in
            Auth::login($user);

            // Redirect to the dashboard with a success message
            return redirect()->route('dashboard')->with('success', 'Email verified successfully.');
        } else {
            // If token is invalid, redirect to login with an error message
            return redirect()->route('login')->with('error', 'Invalid verification token.');
        }
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->email_verified_at) {
            return redirect()->route('dashboard')->with('message', 'Your email is already verified.');
        }

        $confirmationToken = \Illuminate\Support\Str::random(60);
        $user->confirmation_token = $confirmationToken;
        $user->save();

        $confirmationLink = url('/verify-email?token=' . $confirmationToken);
        Mail::to($user->email)->send(new ConfirmationEmail($user, $confirmationLink));

        return redirect()->route('dashboard')->with('message', 'A new verification email has been sent.');
    }
}