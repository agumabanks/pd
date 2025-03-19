<div class="login-wrapper">
    <div class="login-container">
        <h2 class="login-title">Welcome Back</h2>

        <!-- Session Messages -->
        @if (session('message'))
            <div class="message-box message-success">
                {{ session('message') }}
            </div>
        @endif
        @if (session('error'))
            <div class="message-box message-error">
                {{ session('error') }}
            </div>
        @endif
        @if ($errorMessage)
            <div class="message-box message-error">
                {{ $errorMessage }}
            </div>
        @endif

        <!-- Login Form -->
        <form wire:submit.prevent="login" class="login-form">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" wire:model="email" id="email" class="form-input" placeholder="Enter your email" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" wire:model="password" id="password" class="form-input" placeholder="Enter your password" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="submit-button">Login</button>
        </form>
    </div>
    
<style>
    /* Ensure the body takes full viewport height */
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
        font-family: 'Arial', sans-serif;
    }

    /* Wrapper to center the login container */
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        width: 100%;
    }

    /* Scoped styles for .login-container and its children */
    .login-container {
        background: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    .login-container .login-title {
        font-size: 1.75rem;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .login-container .login-form {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .login-container .form-group {
        margin-bottom: 1.25rem;
    }

    .login-container .form-label {
        display: block;
        font-size: 0.95rem;
        font-weight: 600;
        color: #555;
        margin-bottom: 0.5rem;
    }

    .login-container .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1rem;
        color: #333;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .login-container .form-input:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
        outline: none;
    }

    .login-container .error-message {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.25rem;
        display: block;
    }

    .login-container .submit-button {
        width: 100%;
        padding: 0.75rem;
        background: #0056b3;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .login-container .submit-button:hover {
        background: #007bff;
    }

    .login-container .message-box {
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
        text-align: center;
        font-size: 0.9rem;
    }

    .login-container .message-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .login-container .message-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
</div>
