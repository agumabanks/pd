<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        $credentials = ['email' => $this->email, 'password' => $this->password];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->is_confirmed) {
                return redirect()->route('dashboard');
            } else {
                Auth::logout();
                session()->flash('error', 'Please confirm your email first.');
            }
        } else {
            session()->flash('error', 'Invalid credentials.');
        }
    }

   
    public function render()
    {
        return view('livewire.login');
    }
}