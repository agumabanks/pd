<?php

namespace App\Livewire;
 
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ConfirmationEmail;

class CompanyForm2 extends Component
{
    use WithFileUploads;

    // Company fields
    public $dunsNumber;
    public $taxpayerId;
    public $companyName;
    public $contactDetails;
    public $legalAddress;
    public $womenOwnershipDocument;
    public $bankingProof;
    public $registrationDocuments;
    public $directorFirstName;
    public $directorLastName;

    // User fields (also stored in companies table)
    public $userFirstName;
    public $userLastName;
    public $userEmail;
    public $userEmailConfirm;
    public $password;
    public $passwordConfirm;
    public $source;
    public $referralComments;
    public $emailPreference;
    public $terms;

    // Additional properties
    public $activationCode;
    public $showModal = false;
    public $isSubmitting = false; // Track submission state
    public $registrationStep = 'form'; // 'form', 'processing', 'success'

    protected $rules = [
        'dunsNumber' => 'nullable|string|max:255',
        'taxpayerId' => 'nullable|string|max:255',
        'companyName' => 'required|string|max:255',
        'contactDetails' => 'required|string|max:255',
        'legalAddress' => 'required|string|max:255',
        'womenOwnershipDocument' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:10240',
        'bankingProof' => 'required|file|mimes:pdf,jpg,png|max:10240',
        'registrationDocuments' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:10240',
        'directorFirstName' => 'required|string|max:255',
        'directorLastName' => 'required|string|max:255',
        'userFirstName' => 'required|string|max:255',
        'userLastName' => 'required|string|max:255',
        'userEmail' => 'required|email|unique:users,email', // Still validated for uniqueness in users table.
        'userEmailConfirm' => 'required|same:userEmail',
        'password' => 'required|min:8',
        'passwordConfirm' => 'required|same:password',
        'source' => 'nullable|string|max:255',
        'referralComments' => 'nullable|string',
        'emailPreference' => 'required|in:yes,no',
        'terms' => 'accepted',
    ];

    public function submit()
    {
        \Log::info("Starting registration process for email: " . $this->userEmail);
        
        // Show processing state
        $this->isSubmitting = true;
        $this->registrationStep = 'processing';
        
        // Validate all fields
        $this->validate();

        try {
            \Log::info("Uploading files...");
            $womenOwnershipPath = $this->womenOwnershipDocument 
                ? $this->womenOwnershipDocument->store('documents', 'public') 
                : null;
            $bankingProofPath = $this->bankingProof->store('documents', 'public');
            $registrationDocumentsPath = $this->registrationDocuments->store('documents', 'public');
            \Log::info("Files uploaded successfully.");

            // Generate confirmation token (used for both company and user)
            $confirmationToken = Str::random(60);

            // Create company record with all required fields
            $company = Company::create([
                'duns_number'              => $this->dunsNumber,
                'taxpayer_id'              => $this->taxpayerId,
                'company_name'             => $this->companyName,
                'contact_details'          => $this->contactDetails,
                'legal_address'            => $this->legalAddress,
                'women_ownership_document' => $womenOwnershipPath,
                'banking_proof'            => $bankingProofPath,
                'registration_documents'   => $registrationDocumentsPath,
                'director_first_name'      => $this->directorFirstName,
                'director_last_name'       => $this->directorLastName,
                'email'                    => $this->userEmail,       // Company email from user input.
                'activation_code'          => $confirmationToken,     // Activation code.
                'user_first_name'          => $this->userFirstName,
                'user_last_name'           => $this->userLastName,
                'user_email'               => $this->userEmail,
                'password'                 => Hash::make($this->password),
                'source'                   => $this->source,
                'referral_comments'        => $this->referralComments,
                'email_preference'         => $this->emailPreference,
                'terms_accepted'           => $this->terms ? 1 : 0,
            ]);
            \Log::info("Company created with ID: " . $company->id);

            // Create user record (if needed separately; note the companies table now holds all user data)
            $user = User::create([
                'company_id'         => $company->id,
                'first_name'         => $this->userFirstName,
                'last_name'          => $this->userLastName,
                'email'              => $this->userEmail,
                'password'           => Hash::make($this->password),
                'is_confirmed'       => false,
                'confirmation_token' => $confirmationToken,
                'source'             => $this->source,
                'referral_comments'  => $this->referralComments,
                'email_preference'   => $this->emailPreference,
            ]);
            \Log::info("User created with email: " . $this->userEmail);

            // Send confirmation email
            $confirmationLink = url('/confirm?token=' . $confirmationToken);
            Mail::to($user->email)->send(new ConfirmationEmail($user, $confirmationLink));
            \Log::info("Confirmation email sent to: " . $this->userEmail);

            // Set activation code and show success view
            $this->activationCode = $confirmationToken;
            $this->registrationStep = 'success';
            $this->isSubmitting = false;
            
            \Log::info("Registration complete. Proceed to verification.");
        } catch (\Exception $e) {
            \Log::error('Registration failed: ' . $e->getMessage());
            session()->flash('error', 'An error occurred during registration.');
            
            // Reset to form view if there's an error
            $this->registrationStep = 'form';
            $this->isSubmitting = false;
        }
    }
    
    public function closeSuccessModal()
    {
        $this->registrationStep = 'form';
        $this->reset();
    }
     
    public function render()
    {
        return view('livewire.company-form2');
    }
}