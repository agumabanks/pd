<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        if ($user) {
            // Extract initials from the user's name
            $initials = $this->getInitials($user->name);
        } else {
            // Default value if no user is authenticated
            $initials = 'NA'; // Not Authenticated
        }

        // Pass the initials to the view
        return view('dashboard', ['initials' => $initials]);
    }

    private function getInitials($name)
    {
        // Split the name into words
        $words = explode(' ', trim($name));
        
        // Get the first character of the first and last words (if available)
        $initials = '';
        if (count($words) >= 1) {
            $initials .= strtoupper(substr($words[0], 0, 1));
        }
        if (count($words) > 1) {
            $initials .= strtoupper(substr(end($words), 0, 1));
        }

        return $initials;
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out

        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate CSRF token for security

        return redirect('/login')->with('message', 'You have been logged out successfully.');
    }
}