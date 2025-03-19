<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ConfirmationEmail;

class CompanyForm extends Component
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

    // User fields
    public $userFirstName;
    public $userLastName;
    public $userEmail;
    public $password;
    public $passwordConfirm;

    public $showModal = false;

    protected $rules = [
        'dunsNumber' => 'nullable|string|max:255',
        'taxpayerId' => 'nullable|string|max:255',
        'companyName' => 'required|string|max:255',
        'contactDetails' => 'required|string|max:255',
        'legalAddress' => 'required|string|max:255',
        'womenOwnershipDocument' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        'bankingProof' => 'required|file|mimes:pdf,jpg,png|max:10240',
        'registrationDocuments' => 'required|file|mimes:pdf,jpg,png|max:10240',
        'directorFirstName' => 'required|string|max:255',
        'directorLastName' => 'required|string|max:255',
        'userFirstName' => 'required|string|max:255',
        'userLastName' => 'required|string|max:255',
        'userEmail' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'passwordConfirm' => 'required|same:password',
    ];

    public function submit()
    {
        $this->validate();

        try {
            // Upload files
            $womenOwnershipPath = $this->womenOwnershipDocument
                ? $this->womenOwnershipDocument->store('documents', 'public')
                : null;
            $bankingProofPath = $this->bankingProof->store('documents', 'public');
            $registrationDocumentsPath = $this->registrationDocuments->store('documents', 'public');

            // Create company
            $company = Company::create([
                'duns_number' => $this->dunsNumber,
                'taxpayer_id' => $this->taxpayerId,
                'company_name' => $this->companyName,
                'contact_details' => $this->contactDetails,
                'legal_address' => $this->legalAddress,
                'women_ownership_document' => $womenOwnershipPath,
                'banking_proof' => $bankingProofPath,
                'registration_documents' => $registrationDocumentsPath,
                'director_first_name' => $this->directorFirstName,
                'director_last_name' => $this->directorLastName,
            ]);

            // Generate confirmation token
            $confirmationToken = Str::random(60);

            // Create user
            $user = User::create([
                'company_id' => $company->id,
                'first_name' => $this->userFirstName,
                'last_name' => $this->userLastName,
                'email' => $this->userEmail,
                'password' => Hash::make($this->password),
                'is_confirmed' => false,
                'confirmation_token' => $confirmationToken,
            ]);

            // Send confirmation email
            $confirmationLink = url('/confirm?token=' . $confirmationToken);
            Mail::to($user->email)->send(new ConfirmationEmail($user, $confirmationLink));

            $this->showModal = true;
            session()->flash('message', 'Registration successful. Please check your email to confirm.');
        } catch (\Exception $e) {
            \Log::error('Registration failed: ' . $e->getMessage());
            session()->flash('error', 'An error occurred during registration.');
        }
    }

    public function render()
    {
        return view('livewire.company-form');
    }
}