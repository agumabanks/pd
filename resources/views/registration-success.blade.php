@extends('layouts.app')

@section('content')
<div class="company-success-overlay">
    <div class="company-success-modal">
        <div class="company-success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="success-check">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
            </svg>
        </div>
        <h2 class="company-success-title">Registration Successful!</h2>
        <div class="company-success-content">
            <p class="company-success-message">
                Thank you for registering your company. Your account has been created successfully.
            </p>
            
            <div class="company-next-steps">
                <h3 class="company-next-steps-title">Next Steps:</h3>
                <ol class="company-next-steps-list">
                    <li>Check your email at <strong>{{ session('userEmail') }}</strong></li>
                    <li>Click the verification link in the email</li>
                    <li>Once verified, you can log in to your account</li>
                </ol>
            </div>
            
            <p class="company-email-note">
                If you don't see the email in your inbox, please check your spam or junk folder.
            </p>
        </div>
        <a href="{{ route('login') }}" class="company-success-button">Got it</a>
    </div>
</div>

<!-- Include the relevant CSS from your Livewire component -->
<style>
    /* Include only the success modal styles from your Livewire component */
    .company-success-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    /* ... Include all other success modal styles ... */
</style>
@endsection