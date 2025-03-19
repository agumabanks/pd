<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth; // Correct facade for authentication

class UserLogin extends Component
{

    // Public properties for form fields
    public $email;
    public $password;
    public $remember = false; // Optional: Remember me functionality
    public $showModal = false; // For success/error feedback (optional)
    public $errorMessage = ''; // To display login errors

    // Validation rules
    protected $rules = [
        'email' => 'required|email|max:255',
        'password' => 'required|min:8',
    ];

    /**
     * Mount method to initialize properties (optional)
     */
    public function mount()
    {
        $this->email = old('email'); // Pre-fill email if available from session
    }

    /**
     * Handle login submission
     */
    public function login()
    {
        // Validate the form data
        $this->validate();

        try {
            // Attempt to authenticate the user
            if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                // Authentication successful
                $user = Auth::user();

                // Redirect to dashboard or intended page
                return redirect()->intended(route('dashboard'))->with('message', 'Login successful!');
            } else {
                // Authentication failed
                $this->errorMessage = 'Invalid email or password.';
                $this->reset('password'); // Clear password field for security
            }
        } catch (\Exception $e) {
            \Log::error('Login failed: ' . $e->getMessage());
            $this->errorMessage = 'An unexpected error occurred. Please try again.';
        }
    }

    /**
     * Reset form fields
     */
    public function resetForm()
    {
        $this->reset(['email', 'password', 'errorMessage']);
        $this->showModal = false;
    }
 
    public function render()
    {
        return view('livewire.user-login');
    }
}
