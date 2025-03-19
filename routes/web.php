<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;
use App\Livewire\Involved;
use App\Livewire\CompanyForm2;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyRegistrationController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\VerificationController; // Ensure you have this controller available


use App\Http\Controllers\AgreementController;
  
use App\Http\Controllers\ShipmentController;

use App\Http\Controllers\ContractController;


use App\Http\Controllers\ChannelProgramController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SupplierRegistrationController;

use App\Http\Controllers\NotificationController;


use App\Http\Controllers\ScheduleController;

   

// Supplier Registration Routes
Route::get('/supplier/register', [CompanyRegistrationController::class, 'create'])->name('supplier.register');
Route::post('/supplier/register', [CompanyRegistrationController::class, 'store'])->name('supplier.store');
Route::post('/supplier/validate-field', [CompanyRegistrationController::class, 'validateField'])->name('supplier.validate-field');
Route::get('/verify-email', [CompanyRegistrationController::class, 'verifyEmail'])->name('supplier.verify');

Route::prefix('schedules')->group(function () {
    Route::get('/', [ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/create', [ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/', [ScheduleController::class, 'store'])->name('schedules.store');

    Route::get('/bulk-upload', [ScheduleController::class, 'bulkUploadForm'])->name('schedules.bulkUploadForm');
    Route::post('/bulk-upload', [ScheduleController::class, 'bulkUpload'])->name('schedules.bulkUpload');

    Route::get('/{id}', [ScheduleController::class, 'show'])->name('schedules.show');
    Route::get('/{id}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('/{id}', [ScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');

    // Acknowledge endpoint
    Route::post('/{id}/acknowledge', [ScheduleController::class, 'acknowledge'])->name('schedules.acknowledge');
});

Route::get('/orders/lifecycle', [OrderController::class, 'lifecycle'])->name('orders.lifecycle');

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');
    
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])
        ->name('notifications.show');

    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.markAllAsRead');

    Route::patch('/notifications/{id}/dismiss', [NotificationController::class, 'dismiss'])
    ->name('notifications.dismiss');


});

Route::prefix('supplier-registration')->group(function () {
    Route::get('/', [SupplierRegistrationController::class, 'showStep1'])->name('supplier.step1');
    Route::post('/step1', [SupplierRegistrationController::class, 'postStep1'])->name('supplier.postStep1');

    Route::get('/step2', [SupplierRegistrationController::class, 'showStep2'])->name('supplier.step2');
    Route::post('/step2', [SupplierRegistrationController::class, 'postStep2'])->name('supplier.postStep2');

    Route::get('/step3', [SupplierRegistrationController::class, 'showStep3'])->name('supplier.step3');
    Route::post('/step3', [SupplierRegistrationController::class, 'postStep3'])->name('supplier.postStep3');

    Route::get('/step4', [SupplierRegistrationController::class, 'showStep4'])->name('supplier.step4');
    Route::post('/step4', [SupplierRegistrationController::class, 'postStep4'])->name('supplier.postStep4');

    Route::get('/step5', [SupplierRegistrationController::class, 'showStep5'])->name('supplier.step5');
    Route::post('/step5', [SupplierRegistrationController::class, 'postStep5'])->name('supplier.postStep5');

    Route::get('/step6', [SupplierRegistrationController::class, 'showStep6'])->name('supplier.step6');
    Route::post('/step6', [SupplierRegistrationController::class, 'postStep6'])->name('supplier.postStep6');

    Route::get('/step7', [SupplierRegistrationController::class, 'showStep7'])->name('supplier.step7');
    Route::post('/step7', [SupplierRegistrationController::class, 'postStep7'])->name('supplier.postStep7');

    Route::get('/confirm', [SupplierRegistrationController::class, 'confirm'])->name('supplier.confirm');
    Route::post('/complete', [SupplierRegistrationController::class, 'completeRegistration'])->name('supplier.complete');
});

// INVOICES
Route::get('invoices', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
Route::post('invoices', [InvoiceController::class, 'store'])->name('invoices.store');
Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::get('invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
Route::put('invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
Route::delete('invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

// For standard invoice creation
Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');

// For invoice creation without a PO
Route::get('/inv/createWithoutPo', [InvoiceController::class, 'createWithoutPo'])->name('invoices.create_without_po');
 

// INVOICE LINES
Route::get('invoices/{invoice}/create-line', [InvoiceController::class, 'createLine'])->name('invoices.create_line');
Route::post('invoices/{invoice}/store-line', [InvoiceController::class, 'storeLine'])->name('invoices.store_line');

// PAYMENTS
Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
Route::get('payments/create', [PaymentController::class, 'create'])->name('payments.create');
Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');
Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
Route::get('payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
Route::put('payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
Route::delete('payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');

Route::get('channel_programs', [ChannelProgramController::class, 'index'])->name('channel_programs.index');
Route::get('channel_programs/create', [ChannelProgramController::class, 'create'])->name('channel_programs.create');
Route::post('channel_programs', [ChannelProgramController::class, 'store'])->name('channel_programs.store');
Route::get('channel_programs/{channelProgram}', [ChannelProgramController::class, 'show'])->name('channel_programs.show');
Route::get('channel_programs/{channelProgram}/edit', [ChannelProgramController::class, 'edit'])->name('channel_programs.edit');
Route::put('channel_programs/{channelProgram}', [ChannelProgramController::class, 'update'])->name('channel_programs.update');
Route::delete('channel_programs/{channelProgram}', [ChannelProgramController::class, 'destroy'])->name('channel_programs.destroy');


// CONTRACTS CRUD
Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
Route::get('contracts/create', [ContractController::class, 'create'])->name('contracts.create');
Route::post('contracts', [ContractController::class, 'store'])->name('contracts.store');
Route::get('contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
Route::get('contracts/{contract}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
Route::put('contracts/{contract}', [ContractController::class, 'update'])->name('contracts.update');
Route::delete('contracts/{contract}', [ContractController::class, 'destroy'])->name('contracts.destroy');

// CONTRACT LINES
Route::get('contracts/{contract}/create-line', [ContractController::class, 'createLine'])->name('contracts.create_line');
Route::post('contracts/{contract}/store-line', [ContractController::class, 'storeLine'])->name('contracts.store_line');

// CONTRACT REVISIONS
Route::get('contracts/{contract}/create-revision', [ContractController::class, 'createRevision'])->name('contracts.create_revision');
Route::post('contracts/{contract}/store-revision', [ContractController::class, 'storeRevision'])->name('contracts.store_revision');
Route::post('contracts-revision/{revisionId}/update', [ContractController::class, 'updateRevision'])->name('contracts.update_revision');



// OPTIONAL advanced routes
Route::get('contracts/{id}/export-pdf', [ContractController::class, 'exportPdf'])->name('contracts.exportPdf');
Route::get('contracts/analytics', [ContractController::class, 'analytics'])->name('contracts.analytics');
Route::post('contracts/bulk-upload', [ContractController::class, 'bulkUpload'])->name('contracts.bulkUpload');



// MAIN SHIPMENTS CRUD
Route::get('shipments', [ShipmentController::class, 'index'])->name('shipments.index');
Route::get('shipments/create', [ShipmentController::class, 'create'])->name('shipments.create');
Route::post('shipments', [ShipmentController::class, 'store'])->name('shipments.store');
Route::get('shipments/{shipment}', [ShipmentController::class, 'show'])->name('shipments.show');
Route::get('shipments/{shipment}/edit', [ShipmentController::class, 'edit'])->name('shipments.edit');
Route::put('shipments/{shipment}', [ShipmentController::class, 'update'])->name('shipments.update');
Route::delete('shipments/{shipment}', [ShipmentController::class, 'destroy'])->name('shipments.destroy');

// ASN & ASBN
Route::get('shipments-asn/create', [ShipmentController::class, 'createASN'])->name('shipments.create_asn');
Route::get('shipments-asbn/create', [ShipmentController::class, 'createASBN'])->name('shipments.create_asbn');
Route::get('shipments-asn-asbn/upload', [ShipmentController::class, 'uploadAsnAsbn'])->name('shipments.upload_asn_asbn');

// RECEIPTS & RETURNS
Route::get('shipments-receipts', [ShipmentController::class, 'viewReceipts'])->name('shipments.view_receipts');
Route::get('shipments-returns', [ShipmentController::class, 'viewReturns'])->name('shipments.view_returns');

    
// Public Routes
Route::get('/verify-email', [EmailVerificationController::class, 'verify'])->name('verify.email');
// In routes/web.php or routes/api.php
Route::post('validate-field', [CompanyRegistrationController::class, 'validateField'])->name('supplier.validate-field');

Route::get('/register', [CompanyRegistrationController::class, 'create'])->name('company.create');
Route::post('/register', [CompanyRegistrationController::class, 'store'])->name('company.store');

Route::post('/register-company', [CompanyRegistrationController::class, 'store'])->name('company.register.store');
Route::post('/check-email', [CompanyRegistrationController::class, 'checkEmail'])->name('company.register.checkEmail');
Route::get('/register-company', [CompanyRegistrationController::class, 'index'])->name('company.register');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/confirm', [AuthController::class, 'confirm'])->name('confirm');

Route::get('/', Counter::class);
Route::get('/getinvolve', Involved::class);

Route::get('/companyform', function () {
    return view('companyform');
})->name('companyform');

Route::get('/companyform', CompanyForm2::class); 
Route::get('/supply', function () {
    return view('/suppler');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
   

// Existing resource routes for orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

// Custom routes for features not yet implemented:
Route::get('/orders/schedules', [OrderController::class, 'schedules'])->name('orders.schedules');
Route::get('/orders/acknowledge_spreadsheet', [OrderController::class, 'acknowledgeSpreadsheet'])->name('orders.acknowledge_spreadsheet');

// Route::get('orders/{id}/lifecycle', [OrderController::class, 'lifecycle'])->name('orders.lifecycle');
Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');


 
// Optional route if you want to move statuses:
Route::post('/orders/{order}/next-status', [OrderController::class, 'updateStatus'])->name('orders.nextStatus');

 
    // Route for exporting orders as CSV
    Route::get('/orders-export', [OrderController::class, 'export'])->name('orders.export');
    
    // Custom route for acknowledging an order (POST for state-changing action)
    Route::post('/orders/{id}/acknowledge', [OrderController::class, 'acknowledge'])->name('orders.acknowledge');
 
    Route::resource('agreements', AgreementController::class);



    // Route for exporting agreements (e.g., as CSV)
    Route::get('agreements-export', [AgreementController::class, 'export'])->name('agreements.export');

 
Route::get('/agreements/{id}/export-pdf', [AgreementController::class, 'exportPdf'])
    ->name('agreements.exportPdf');

    // agreements.exportSingleCsv
    Route::get('/agreements/{id}/exportSingleCsv', [AgreementController::class, 'exportPdf'])
    ->name('agreements.exportSingleCsv');

    // exportPdf

    Route::get('/agreements/{id}/exportPdf', [AgreementController::class, 'exportPdf'])
    ->name('agreements.exportPdf');


    Route::prefix('agreements')->group(function () {
        Route::get('/', [AgreementController::class, 'index'])->name('agreements.index');
        Route::get('/create', [AgreementController::class, 'create'])->name('agreements.create');
        Route::post('/', [AgreementController::class, 'store'])->name('agreements.store');
        Route::get('/{id}', [AgreementController::class, 'show'])->name('agreements.show');
        Route::get('/{id}/edit', [AgreementController::class, 'edit'])->name('agreements.edit');
        Route::put('/{id}', [AgreementController::class, 'update'])->name('agreements.update');
        Route::delete('/{id}', [AgreementController::class, 'destroy'])->name('agreements.destroy');

        Route::get('/export', [AgreementController::class, 'export'])->name('agreements.export');
        Route::get('/bulk-upload', [AgreementController::class, 'bulkUploadForm'])->name('agreements.bulkUploadForm');
        Route::post('/bulk-upload', [AgreementController::class, 'bulkUpload'])->name('agreements.bulkUpload');
    });

    // Existing routes
    Route::get('/resend-verification', [VerificationController::class, 'resend'])->name('resend.verification');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');

    // New supplier portal routes
    Route::get('/tenders', function () {
        return view('tenders');
    })->name('tenders');

    Route::get('/opportunities', function () {
        return view('opportunities');
    })->name('opportunities');

     
    Route::get('/documents', function () {
        return view('documents');
    })->name('documents');

    Route::get('/compliance', function () {
        return view('compliance');
    })->name('compliance');

    Route::get('/training', function () {
        return view('training');
    })->name('training');

    Route::get('/support', function () {
        return view('support');
    })->name('support');

    // Logout Routes
    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');
     
});
