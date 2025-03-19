<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail; // for sending email if needed
use Illuminate\Support\Str;         // for generating random strings

class SupplierRegistrationController extends Controller
{
    /**
     * Step 1: Company Details
     */
    public function showStep1()
    {
        return view('supplier_registration.step1');
    }

    public function postStep1(Request $request)
    {
        $data = $request->validate([
            'company_name'        => 'required|string|max:255',
            'country_of_taxation' => 'required|string|max:255',
            'country_of_origin'   => 'required|string|max:255',
            'taxpayer_id'         => 'nullable|string|max:255',
            'supplier_type'       => 'required|string|max:50', // "Company" or "Individual"
        ]);

        // Store step data in session
        Session::put('supplier_registration.step1', $data);

        return redirect()->route('supplier.step2');
    }

    /**
     * Step 2: Contact Details
     */
    public function showStep2()
    {
        return view('supplier_registration.step2');
    }

    public function postStep2(Request $request)
    {
        $data = $request->validate([
            'first_name'                => 'required|string|max:255',
            'last_name'                 => 'required|string|max:255',
            'email'                     => 'required|email|max:255',
            'is_administrative_contact' => 'nullable|boolean',
        ]);

        // Convert the checkbox or toggles if necessary
        $data['is_administrative_contact'] = $request->has('is_administrative_contact');

        Session::put('supplier_registration.step2', $data);

        return redirect()->route('supplier.step3');
    }

    /**
     * Step 3: Address
     * We store addresses as JSON in an array so you can
     * capture multiple addresses if required.
     */
    public function showStep3()
    {
        return view('supplier_registration.step3');
    }

    public function postStep3(Request $request)
    {
        // Example for a single address input
        // If multiple addresses, you'd pass them as an array with something like addresses[0][country], etc.
        $data = $request->validate([
            'addresses'                  => 'required|array',
            'addresses.*.address_name'   => 'required|string|max:255',
            'addresses.*.country'        => 'required|string|max:255',
            'addresses.*.city'           => 'required|string|max:255',
            'addresses.*.line1'          => 'required|string|max:255',
        ]);
        
        Session::put('supplier_registration.step3', $data);

        return redirect()->route('supplier.step4');
    }

    /**
     * Step 4: Business Classification
     */
    public function showStep4()
    {
        return view('supplier_registration.step4');
    }

    public function postStep4(Request $request)
    {
        // The user may select multiple classifications
        $data = $request->validate([
            'business_classifications' => 'array',
            'business_classifications.*' => 'string|max:255',
        ]);

        Session::put('supplier_registration.step4', $data);

        return redirect()->route('supplier.step5');
    }

    /**
     * Step 5: Banking Details
     */
    public function showStep5()
    {
        return view('supplier_registration.step5');
    }

    public function postStep5(Request $request)
    {
        $data = $request->validate([
            'bank_accounts' => 'required|array',
            'bank_accounts.*.country'        => 'required|string|max:255',
            'bank_accounts.*.bank_name'      => 'required|string|max:255',
            'bank_accounts.*.branch_name'    => 'nullable|string|max:255',
            'bank_accounts.*.account_number' => 'required|string|max:255',
            'bank_accounts.*.iban'           => 'nullable|string|max:255',
            'bank_accounts.*.currency'       => 'nullable|string|max:255',
            'bank_accounts.*.account_type'   => 'nullable|string|max:50',
            'bank_accounts.*.account_holder' => 'nullable|string|max:255',
        ]);

        Session::put('supplier_registration.step5', $data);

        return redirect()->route('supplier.step6');
    }

    /**
     * Step 6: Product Classification
     */
    public function showStep6()
    {
        return view('supplier_registration.step6');
    }

    public function postStep6(Request $request)
    {
        $data = $request->validate([
            'product_categories' => 'array',
            'product_categories.*' => 'string|max:255',
        ]);

        Session::put('supplier_registration.step6', $data);

        return redirect()->route('supplier.step7');
    }

    /**
     * Step 7: Questionnaire
     */
    public function showStep7()
    {
        return view('supplier_registration.step7');
    }

    public function postStep7(Request $request)
    {
        // Validate as needed. 
        // For example: 'questionnaire' => 'array' plus internal fields for each question
        $data = $request->validate([
            'questionnaire' => 'array',
            // 'questionnaire.corporate_profile' => 'required|string|min:10', etc.
        ]);

        Session::put('supplier_registration.step7', $data);

        return redirect()->route('supplier.confirm');
    }

    /**
     * Confirm & show summary before final creation
     */
    public function confirm()
    {
        $step1 = Session::get('supplier_registration.step1', []);
        $step2 = Session::get('supplier_registration.step2', []);
        $step3 = Session::get('supplier_registration.step3', []);
        $step4 = Session::get('supplier_registration.step4', []);
        $step5 = Session::get('supplier_registration.step5', []);
        $step6 = Session::get('supplier_registration.step6', []);
        $step7 = Session::get('supplier_registration.step7', []);

        return view('supplier_registration.confirm', compact('step1','step2','step3','step4','step5','step6','step7'));
    }

    /**
     * Finalize registration & persist data
     * Optionally trigger password setup or MFA steps
     */
    public function completeRegistration(Request $request)
    {
        // Merge all session data
        $supplierData = array_merge(
            Session::get('supplier_registration.step1', []),
            Session::get('supplier_registration.step2', []),
            [
                'addresses' => Session::get('supplier_registration.step3.addresses', []),
                'business_classifications' => Session::get('supplier_registration.step4.business_classifications', []),
                'bank_accounts' => Session::get('supplier_registration.step5.bank_accounts', []),
                'product_categories' => Session::get('supplier_registration.step6.product_categories', []),
                'questionnaire' => Session::get('supplier_registration.step7.questionnaire', []),
            ]
        );

        // Option 1: Generate random password, store hashed
        $tempPassword = Str::random(12);
        $supplierData['password'] = Hash::make($tempPassword);

        // Create the new supplier record
        $supplier = Supplier::create($supplierData);

        // Clear session data
        Session::forget('supplier_registration');

        // [Optional] Email the user with a password reset link or the temp password
        // Typically you would prefer a secure password reset link:
        //   - Using Laravel's Password Broker to send an official reset link
        //   - Or sending a custom Mailable with instructions

        // Example: (pseudocode)
        // Mail::to($supplier->email)->send(new SupplierRegistrationMail($supplier, $tempPassword));

        // Option 2: If using Laravel's built-in password reset approach,
        // you can trigger a reset token. 
        // \Illuminate\Support\Facades\Password::sendResetLink(['email' => $supplier->email]);

        // [Optional] MFA or "secure verification" can be integrated with
        // Laravel Fortify or your own custom TOTP solution.

        return redirect()->route('supplier-registration.success')
            ->with('success', 'Registration Complete! Check your email for next steps.');
    }
}
