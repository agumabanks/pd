<div class="p-16 m-16">
<div class="company-form-container">
    <h1 class="company-form-title">Company Registration</h1>
    <div>
    <form wire:submit.prevent="submit">
        <!-- Company Details -->
        <h2>Company Details</h2>
        <div>
            <label>DUNS Number</label>
            <input type="text" wire:model="dunsNumber">
            @error('dunsNumber') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Taxpayer ID</label>
            <input type="text" wire:model="taxpayerId">
            @error('taxpayerId') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Company Name</label>
            <input type="text" wire:model="companyName">
            @error('companyName') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Contact Details</label>
            <input type="text" wire:model="contactDetails">
            @error('contactDetails') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Legal Address</label>
            <input type="text" wire:model="legalAddress">
            @error('legalAddress') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Women Ownership Document</label>
            <input type="file" wire:model="womenOwnershipDocument">
            @error('womenOwnershipDocument') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Banking Proof</label>
            <input type="file" wire:model="bankingProof">
            @error('bankingProof') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Registration Documents</label>
            <input type="file" wire:model="registrationDocuments">
            @error('registrationDocuments') <span>{{ $message }}</span> @enderror
        </div>

        <!-- Director Details -->
        <h2>Director Details</h2>
        <div>
            <label>First Name</label>
            <input type="text" wire:model="directorFirstName">
            @error('directorFirstName') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Last Name</label>
            <input type="text" wire:model="directorLastName">
            @error('directorLastName') <span>{{ $message }}</span> @enderror
        </div>

        <!-- User Details -->
        <h2>User Details</h2>
        <div>
            <label>First Name</label>
            <input type="text" wire:model="userFirstName">
            @error('userFirstName') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Last Name</label>
            <input type="text" wire:model="userLastName">
            @error('userLastName') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Email</label>
            <input type="email" wire:model="userEmail">
            @error('userEmail') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Password</label>
            <input type="password" wire:model="password">
            @error('password') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Confirm Password</label>
            <input type="password" wire:model="passwordConfirm">
            @error('passwordConfirm') <span>{{ $message }}</span> @enderror
        </div>

        <button type="submit">Register</button>
    </form>

    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif
    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    @if ($showModal)
        <div>
            <p>Registration successful! Please check your email.</p>
        </div>
    @endif
</div>
</div>

<style>
    .company-form-container {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 16px;
        background-color: #f9f9f9;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
        margin: auto;
    }

    @media (min-width: 768px) {
        .company-form-container {
            max-width: 800px;
        }
    }
    .company-form {
            max-width: 800px;
            margin: 0 auto;
        }

    .company-form-title {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        text-align: center;
        color: #333;
    }

    .card {
        background-color: #fff;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 1.25rem;
        margin-bottom: 1rem;
        color: #333;
        border-bottom: 1px solid #ddd;
        padding-bottom: 0.5rem;
    }

    .card-content {
        margin-top: 1rem;
    }

    .company-form-group {
        margin-bottom: 1.5rem;
    }

    .company-form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #333;
    }

    .company-form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .company-form-input:focus {
        border-color: #007aff;
        box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.3);
        outline: none;
    }

    .company-error-message {
        color: #ff0000;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .company-submit-button {
        width: 100%;
        padding: 0.75rem;
        background-color: #007aff;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .company-submit-button:hover {
        background-color: #005bb5;
    }

    .company-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease;
    }

    .company-modal {
        background-color: #fff;
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
        animation: fadeInScale 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .company-modal-message {
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }

    .modal-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    .company-modal-button {
        padding: 0.5rem 1rem;
        background-color: #007aff;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .company-modal-button:hover {
        background-color: #005bb5;
    }

    .terms-link {
        color: #007aff;
        text-decoration: underline;
    }

    .company-terms-text {
        font-size: 0.875rem;
        color: #666;
        margin-top: 1rem;
        padding: 1rem;
        background-color: #f0f0f0;
        border-radius: 4px;
    }
</style>
</div>
