<div class="p-16 m-16">
    <div class="company-form-container">
        <h1 class="company-form-title">Company Registration</h1>

        <!-- Registration Form -->
        @if($registrationStep === 'form')
            <form wire:submit.prevent="submit" class="company-form" enctype="multipart/form-data">
                <!-- Loading Indicator for individual operations -->
                <div wire:loading wire:target="womenOwnershipDocument, bankingProof, registrationDocuments" class="loading-indicator">
                    <p>Uploading file, please wait...</p>
                </div>

                <!-- Company Details Section -->
                <div class="card">
                    <h2 class="card-title">Company Details</h2>
                    <div class="card-content">
                        <div class="company-form-group">
                            <label for="dunsNumber" class="company-form-label">D-U-N-S Number</label>
                            <input type="text" id="dunsNumber" wire:model="dunsNumber" class="company-form-input" placeholder="Enter D-U-N-S Number">
                            @error('dunsNumber') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="taxpayerId" class="company-form-label">Taxpayer ID</label>
                            <input type="text" id="taxpayerId" wire:model="taxpayerId" class="company-form-input" placeholder="Enter Taxpayer ID">
                            @error('taxpayerId') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="companyName" class="company-form-label">Company Name</label>
                            <input type="text" id="companyName" wire:model="companyName" class="company-form-input" placeholder="Enter Company Name">
                            @error('companyName') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="contactDetails" class="company-form-label">Contact Details</label>
                            <input type="text" id="contactDetails" wire:model="contactDetails" class="company-form-input" placeholder="Enter Contact Details">
                            @error('contactDetails') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="legalAddress" class="company-form-label">Legal Address</label>
                            <input type="text" id="legalAddress" wire:model="legalAddress" class="company-form-input" placeholder="Enter Legal Address">
                            @error('legalAddress') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Documentation Section -->
                <div class="card">
                    <h2 class="card-title">Documentation</h2>
                    <div class="card-content">
                        <div class="company-form-group">
                            <label for="womenOwnershipDocument" class="company-form-label">Women Ownership Document (optional)</label>
                            <input type="file" id="womenOwnershipDocument" wire:model="womenOwnershipDocument" class="company-form-input" accept=".pdf,.doc,.docx,jpg,png">
                            <div wire:loading wire:target="womenOwnershipDocument" class="file-upload-indicator">
                                <span class="file-upload-spinner"></span> Uploading...
                            </div>
                            @error('womenOwnershipDocument') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="bankingProof" class="company-form-label">Banking Proof</label>
                            <input type="file" id="bankingProof" wire:model="bankingProof" class="company-form-input" accept=".pdf,.jpg,.png">
                            <div wire:loading wire:target="bankingProof" class="file-upload-indicator">
                                <span class="file-upload-spinner"></span> Uploading...
                            </div>
                            @error('bankingProof') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="registrationDocuments" class="company-form-label">Registration Documents</label>
                            <input type="file" id="registrationDocuments" wire:model="registrationDocuments" class="company-form-input" accept=".pdf,.doc,.docx,jpg,png">
                            <div wire:loading wire:target="registrationDocuments" class="file-upload-indicator">
                                <span class="file-upload-spinner"></span> Uploading...
                            </div>
                            @error('registrationDocuments') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Director Details Section -->
                <div class="card">
                    <h2 class="card-title">Director Details</h2>
                    <div class="card-content">
                        <div class="company-form-group">
                            <label for="directorFirstName" class="company-form-label">First Name</label>
                            <input type="text" id="directorFirstName" wire:model="directorFirstName" class="company-form-input" placeholder="Enter Director First Name">
                            @error('directorFirstName') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="directorLastName" class="company-form-label">Last Name</label>
                            <input type="text" id="directorLastName" wire:model="directorLastName" class="company-form-input" placeholder="Enter Director Last Name">
                            @error('directorLastName') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- User Details Section -->
                <div class="card">
                    <h2 class="card-title">User Details</h2>
                    <div class="card-content">
                        <div class="company-form-group">
                            <label for="userFirstName" class="company-form-label">First Name</label>
                            <input type="text" id="userFirstName" wire:model="userFirstName" class="company-form-input" placeholder="Enter User First Name">
                            @error('userFirstName') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="userLastName" class="company-form-label">Last Name</label>
                            <input type="text" id="userLastName" wire:model="userLastName" class="company-form-input" placeholder="Enter User Last Name">
                            @error('userLastName') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="userEmail" class="company-form-label">Email</label>
                            <input type="email" id="userEmail" wire:model="userEmail" class="company-form-input" placeholder="Enter Email">
                            @error('userEmail') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="userEmailConfirm" class="company-form-label">Confirm Email</label>
                            <input type="email" id="userEmailConfirm" wire:model="userEmailConfirm" class="company-form-input" placeholder="Confirm Email">
                            @error('userEmailConfirm') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="password" class="company-form-label">Password</label>
                            <input type="password" id="password" wire:model="password" class="company-form-input" placeholder="Enter Password">
                            @error('password') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="passwordConfirm" class="company-form-label">Confirm Password</label>
                            <input type="password" id="passwordConfirm" wire:model="passwordConfirm" class="company-form-input" placeholder="Confirm Password">
                            @error('passwordConfirm') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="source" class="company-form-label">How did you hear about us?</label>
                            <input type="text" id="source" wire:model="source" class="company-form-input" placeholder="Enter Source">
                            @error('source') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label for="referralComments" class="company-form-label">Referral Comments</label>
                            <textarea id="referralComments" wire:model="referralComments" class="company-form-input" placeholder="Enter Comments"></textarea>
                            @error('referralComments') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label class="company-form-label">Email Communication</label>
                            <div>
                                <label>
                                    <input type="radio" wire:model="emailPreference" value="yes">
                                    Yes
                                </label>
                                <label>
                                    <input type="radio" wire:model="emailPreference" value="no">
                                    No
                                </label>
                            </div>
                            @error('emailPreference') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>

                        <div class="company-form-group">
                            <label>
                                <input type="checkbox" wire:model="terms">
                                I agree to the terms and conditions
                            </label>
                            @error('terms') <span class="company-error-message">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="company-submit-button" wire:loading.attr="disabled" wire:loading.class="company-submit-button-loading">
                    <span wire:loading.remove wire:target="submit">Submit</span>
                    <span wire:loading wire:target="submit" class="submit-button-loading-text">
                        <span class="submit-spinner"></span> Processing...
                    </span>
                </button>
            </form>
        @endif

        <!-- Processing Overlay -->
        @if($registrationStep === 'processing')
            <div class="company-processing-overlay">
                <div class="company-processing-modal">
                    <div class="company-spinner"></div>
                    <h3 class="company-processing-title">Processing Your Registration</h3>
                    <p class="company-processing-message">Please wait while we create your account and upload your documents...</p>
                </div>
            </div>
        @endif

        <!-- Success Modal -->
        @if($registrationStep === 'success')
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
                                <li>Check your email at <strong>{{ $userEmail }}</strong></li>
                                <li>Click the verification link in the email</li>
                                <li>Once verified, you can log in to your account</li>
                            </ol>
                        </div>
                        
                        <p class="company-email-note">
                            If you don't see the email in your inbox, please check your spam or junk folder.
                        </p>
                    </div>
                    <button wire:click="closeSuccessModal" class="company-success-button">Got it</button>
                </div>
            </div>
        @endif
    </div>

    <style>
        .company-form-container {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 16px;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 800px;
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
            background-color: rgb(3, 106, 156);
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: relative;
        }
        .company-submit-button:hover {
            background-color: rgb(2, 100, 198);
        }
        .company-submit-button-loading {
            background-color: rgb(2, 83, 123);
            cursor: wait;
        }
        .submit-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #ffffff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
            vertical-align: middle;
        }
        .submit-button-loading-text {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .loading-indicator {
            text-align: center;
            font-size: 1rem;
            color: #007aff;
            margin-bottom: 1rem;
            padding: 0.5rem;
            background-color: rgba(0, 122, 255, 0.1);
            border-radius: 4px;
        }
        
        .file-upload-indicator {
            font-size: 0.875rem;
            color: #007aff;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .file-upload-spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(0, 122, 255, 0.3);
            border-radius: 50%;
            border-top-color: #007aff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Processing Overlay Styles */
        .company-processing-overlay {
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
        
        .company-processing-modal {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: fadeInScale 0.3s ease;
        }
        
        .company-spinner {
            display: inline-block;
            width: 60px;
            height: 60px;
            border: 4px solid rgba(3, 106, 156, 0.2);
            border-radius: 50%;
            border-top-color: rgb(3, 106, 156);
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 1.5rem;
        }
        
        .company-processing-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.75rem;
        }
        
        .company-processing-message {
            color: #666;
            margin-bottom: 0;
        }
        
        /* Success Modal Styles */
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
        
        .company-success-modal {
            background-color: #fff;
            padding: 2.5rem;
            border-radius: 8px;
            text-align: center;
            max-width: 500px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: fadeInScale 0.3s ease;
        }
        
        .company-success-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(39, 174, 96, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        
        .success-check {
            width: 50px;
            height: 50px;
            color: #27ae60;
        }
        
        .company-success-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 1.5rem;
        }
        
        .company-success-content {
            text-align: left;
            margin-bottom: 1.5rem;
        }
        
        .company-success-message {
            color: #444;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }
        
        .company-next-steps {
            background-color: #f0f7ff;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        
        .company-next-steps-title {
            color: #036a9c;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 0.75rem;
        }
        
        .company-next-steps-list {
            padding-left: 1.5rem;
            margin-bottom: 0;
        }
        
        .company-next-steps-list li {
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .company-email-note {
            color: #666;
            font-size: 0.9rem;
            font-style: italic;
        }
        
        .company-success-button {
            padding: 0.75rem 2rem;
            background-color: rgb(3, 106, 156);
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .company-success-button:hover {
            background-color: rgb(2, 86, 127);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</div>