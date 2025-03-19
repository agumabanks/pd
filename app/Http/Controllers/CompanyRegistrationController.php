<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationEmail;
use App\Models\Company;
use App\Models\User;
use App\Services\UnsdgValidationService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

// Make sure this is present at the top of your file
use Illuminate\Routing\Controller as BaseController;

class CompanyRegistrationController extends Controller
{
    /**
     * The UNSDG validation service instance.
     *
     * @var UnsdgValidationService
     */
    protected $unsdgValidationService;
    
    /**
     * Create a new controller instance.
     *
     * @param UnsdgValidationService $unsdgValidationService
     * @return void
     */
    public function __construct(UnsdgValidationService $unsdgValidationService)
    {
        // Make sure Controller is extended and middleware method is available
        $this->unsdgValidationService = $unsdgValidationService;
        
        // Use middleware method from the parent Controller class
        // $this->middleware('throttle:5,10')->only('validateField', 'store');
    }

    /**
     * Display the registration form.
     *
     * @return View
     */
    public function create(): View
    {
        // Load any reference data needed for the form
        $countries = config('countries', []);
        
        return view('supplier.registration', [
            'countries' => $countries
        ]);
    }

    /**
     * Validate a single field via AJAX for real-time feedback.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function validateField(Request $request): JsonResponse
    {
        $field = $request->input('field');
        $value = $request->input('value');
        
        if (!$field) {
            return response()->json(['valid' => false, 'message' => 'No field specified'], 400);
        }

        // Get validation rules for the field
        $rules = $this->getFieldValidationRules($field);
        
        if (!$rules) {
            return response()->json(['valid' => false, 'message' => 'Invalid field'], 400);
        }

        try {
            $validator = Validator::make([$field => $value], [$field => $rules]);
            
            if ($validator->fails()) {
                return response()->json([
                    'valid' => false,
                    'message' => $validator->errors()->first($field)
                ]);
            }
            
            // Special case validations
            if ($field === 'dunsNumber' && $value) {
                // Use the service for D-U-N-S validation
                $isValid = $this->unsdgValidationService->validateDunsNumber($value);
                if (!$isValid) {
                    return response()->json([
                        'valid' => false,
                        'message' => 'Invalid D-U-N-S number format'
                    ]);
                }
            }
            
            if ($field === 'userEmail') {
                // Check if email already exists in the database
                if (User::where('email', $value)->exists()) {
                    return response()->json([
                        'valid' => false,
                        'message' => 'This email is already registered in our system'
                    ]);
                }
            }

            return response()->json(['valid' => true]);
        } catch (\Exception $e) {
            Log::error('Field validation error', [
                'field' => $field,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'valid' => false,
                'message' => 'An error occurred during validation'
            ], 500);
        }
    }

    /**
     * Handle the registration form submission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Start database transaction
        DB::beginTransaction();
        
        try {
            // Validate form data
            $validator = Validator::make($request->all(), [
                'dunsNumber' => 'nullable|string|max:9',
                'taxpayerId' => 'required|string|max:255',
                'companyName' => 'required|string|max:255',
                'contactDetails' => 'required|string|max:255',
                'legalAddress' => 'required|string|max:255',
                'womenOwnershipDocument' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:10240',
                'bankingProof' => 'required|file|mimes:pdf,jpg,png|max:10240',
                'registrationDocuments' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:10240',
                'directorFirstName' => 'required|string|max:255',
                'directorLastName' => 'required|string|max:255',
                'directorPosition' => 'nullable|string|max:255',
                'directorEmail' => 'nullable|email|max:255',
                'userFirstName' => 'required|string|max:255',
                'userLastName' => 'required|string|max:255',
                'userEmail' => 'required|email|unique:users,email|max:255',
                'userEmailConfirm' => 'required|same:userEmail',
                'password' => [
                    'required',
                    'min:8',
                    'max:255',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
                ],
                'passwordConfirm' => 'required|same:password',
                'source' => 'nullable|string|max:255',
                'referralComments' => 'nullable|string|max:1000',
                'emailPreference' => 'required|in:yes,no',
                'terms' => 'accepted',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            // Process document uploads
            $documentPaths = [];
            
            // Handle file uploads
            if ($request->hasFile('womenOwnershipDocument')) {
                $documentPaths['womenOwnershipDocument'] = $this->storeDocument(
                    $request->file('womenOwnershipDocument'), 
                    'women_ownership'
                );
            }
            
            if ($request->hasFile('bankingProof')) {
                $documentPaths['bankingProof'] = $this->storeDocument(
                    $request->file('bankingProof'), 
                    'banking_proof'
                );
            }
            
            if ($request->hasFile('registrationDocuments')) {
                $documentPaths['registrationDocuments'] = $this->storeDocument(
                    $request->file('registrationDocuments'), 
                    'registration'
                );
            }
            
            // Optionally check sanction compliance
            if ($request->input('companyName') && $request->input('country')) {
                $sanctionCheck = $this->unsdgValidationService->validateSanctionsCompliance(
                    $request->input('companyName'),
                    $request->input('country')
                );
                
                if (!$sanctionCheck['pass'] && !isset($sanctionCheck['manual_review'])) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unable to proceed with registration due to compliance requirements'
                    ], 403);
                }
            }
            
            // Generate verification token
            $verificationToken = Str::random(64);
            
            // Create company record
            $company = Company::create([
                'duns_number' => $request->input('dunsNumber'),
                'taxpayer_id' => $request->input('taxpayerId'),
                'company_name' => $request->input('companyName'),
                'contact_details' => $request->input('contactDetails'),
                'legal_address' => $request->input('legalAddress'),
                'women_ownership_document' => $documentPaths['womenOwnershipDocument'] ?? null,
                'banking_proof' => $documentPaths['bankingProof'] ?? null,
                'registration_documents' => $documentPaths['registrationDocuments'] ?? null,
                'director_first_name' => $request->input('directorFirstName'),
                'director_last_name' => $request->input('directorLastName'),
                'director_position' => $request->input('directorPosition'),
                'director_email' => $request->input('directorEmail'),
                'verification_token' => $verificationToken,
                'verification_expires_at' => Carbon::now()->addDays(7),
                'is_authorized_signatory' => $request->has('declarations.authorizedSignatory'),
                'ethical_declaration' => $request->has('declarations.unEthics'),
                'source' => $request->input('source'),
                'referral_comments' => $request->input('referralComments'),
                'email_preference' => $request->input('emailPreference') === 'yes',
                'terms_accepted' => true,
                'terms_accepted_at' => Carbon::now(),
                'status' => 'pending_verification',
                'registration_ip' => $request->ip(),
            ]);
            
            // Create user record
            $user = User::create([
                'company_id' => $company->id,
                'first_name' => $request->input('userFirstName'),
                'last_name' => $request->input('userLastName'),
                'email' => $request->input('userEmail'),
                'password' => Hash::make($request->input('password')),
                'is_admin' => true, // First user is company admin
                'is_active' => false,
                'email_verified_at' => null,
                'verification_token' => $verificationToken,
                'email_preference' => $request->input('emailPreference') === 'yes',
                'registration_ip' => $request->ip(),
            ]);
            
            // Send verification email
            $this->sendVerificationEmail($user, $verificationToken);
            
            // Commit database transaction
            DB::commit();
            
            // Log successful registration
            Log::info('Supplier registration successful', [
                'company_id' => $company->id,
                'user_id' => $user->id,
                'email' => $user->email
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Registration successful. Please check your email to verify your account.',
                'email' => $user->email,
            ]);
            
        } catch (ValidationException $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Supplier registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }
    
    /**
     * Store a document securely.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $type Document type identifier
     * @return string The path to the stored document
     */
    protected function storeDocument($file, $type): string
    {
        // Create a unique filename with original extension
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        // Store in a structured folder
        $path = "documents/{$type}/" . date('Y/m/d');
        
        // Store the file and return the path
        return $file->storeAs($path, $filename, 'public');
    }
    
    /**
     * Send verification email to the user.
     *
     * @param User $user
     * @param string $verificationToken
     * @return void
     */
    protected function sendVerificationEmail(User $user, string $verificationToken): void
    {
        $verificationLink = url('/verify-email?token=' . $verificationToken . '&email=' . $user->email);
        
        Mail::to($user->email)->send(new ConfirmationEmail($user, $verificationLink));
        
        Log::info('Verification email sent', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);
    }
    
    /**
     * Get validation rules for a specific field.
     *
     * @param string $field
     * @return string|array|null
     */
    protected function getFieldValidationRules(string $field)
    {
        $rules = [
            'dunsNumber' => 'nullable|string|max:9',
            'taxpayerId' => 'required|string|max:255',
            'companyName' => 'required|string|max:255',
            'contactDetails' => 'required|string|max:255',
            'legalAddress' => 'required|string|max:255',
            'directorFirstName' => 'required|string|max:255',
            'directorLastName' => 'required|string|max:255',
            'directorPosition' => 'nullable|string|max:255',
            'directorEmail' => 'nullable|email|max:255',
            'userFirstName' => 'required|string|max:255',
            'userLastName' => 'required|string|max:255',
            'userEmail' => 'required|email|unique:users,email|max:255',
            'userEmailConfirm' => 'required|same:userEmail',
            'password' => [
                'required',
                'min:8',
                'max:255',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'passwordConfirm' => 'required|same:password',
            'source' => 'nullable|string|max:255',
            'referralComments' => 'nullable|string|max:1000',
            'emailPreference' => 'required|in:yes,no',
            'terms' => 'accepted',
        ];
        
        return $rules[$field] ?? null;
    }
    
    /**
     * Verify a supplier's email address.
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    public function verifyEmail(Request $request)
    {
        $token = $request->input('token');
        $email = $request->input('email');
        
        if (!$token || !$email) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification request'
            ], 400);
        }
        
        $user = User::where('email', $email)
            ->where('verification_token', $token)
            ->whereNull('email_verified_at')
            ->first();
            
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired verification token'
            ], 404);
        }
        
        $company = Company::find($user->company_id);
        
        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Company record not found'
            ], 404);
        }
        
        // Verify the user's email
        $user->email_verified_at = Carbon::now();
        $user->verification_token = null;
        $user->is_active = true;
        $user->save();
        
        // Update company status
        $company->status = 'pending_review';
        $company->save();
        
        Log::info('Supplier email verified', [
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully'
            ]);
        }
        
        return view('supplier.verification-success', [
            'user' => $user,
            'company' => $company
        ]);
    }
}