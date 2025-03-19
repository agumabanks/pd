<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function confirm(Request $request)
    {
        $token = $request->query('token');
        $user = User::where('confirmation_token', $token)->first();

        if ($user) {
            $user->is_confirmed = true;
            $user->confirmation_token = null;
            $user->save();

            return redirect()->route('login')->with('message', 'Your account has been confirmed. You can now log in.');
        }

        return redirect()->route('login')->with('error', 'Invalid confirmation token.');
    }
}