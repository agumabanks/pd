<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserInitials extends Component
{
    public $initials;

    public function mount()
    {
        // Get the authenticated user
        $user = Auth::user();

        if ($user) {
            // Extract initials from the user's name
            $this->initials = $this->getInitials($user->name);
        } else {
            // Default value if no user is authenticated
            $this->initials = 'NA'; // Not Authenticated
        }
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

    public function render()
    {
        return view('livewire.user-initials');
    }
}