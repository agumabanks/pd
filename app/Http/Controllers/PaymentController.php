<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Invoice;

class PaymentController extends Controller
{
    /**
     * INDEX: List all payments with search & pagination.
     */
    public function index(Request $request)
    {
        $query = Payment::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('payment_number', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%");
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('payments.index', compact('payments'));
    }

    /**
     * CREATE: Show form to create a new payment.
     */
    public function create()
    {
        $invoices = Invoice::orderBy('invoice_number')->get();
        return view('payments.create', compact('invoices'));
    }

    /**
     * STORE: Save a new payment and apply it to an invoice.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_number' => 'required|string|max:50|unique:payments',
            'invoice_id'     => 'nullable|exists:invoices,id',
            'payment_date'   => 'nullable|date',
            'amount_paid'    => 'required|numeric|min:0',
            'currency'       => 'nullable|string|max:10',
            'payment_method' => 'nullable|string|max:50'
        ]);

        $payment = Payment::create($request->all());

        // Optionally update invoice status if fully paid
        if ($payment->invoice) {
            $invoice = $payment->invoice;
            // Check if invoice total <= sum of payments
            $paidSoFar = $invoice->payments()->sum('amount_paid');
            if ($paidSoFar >= $invoice->total) {
                $invoice->update(['status' => 'Paid']);
            } elseif ($paidSoFar > 0 && $paidSoFar < $invoice->total) {
                $invoice->update(['status' => 'Partially Paid']);
            }
        }

        return redirect()->route('payments.show', $payment->id)
                         ->with('success', 'Payment recorded successfully.');
    }

    /**
     * SHOW: Display a single payment details.
     */
    public function show($id)
    {
        $payment = Payment::with('invoice')->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    /**
     * EDIT: Show the form to edit a payment.
     */
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $invoices = Invoice::orderBy('invoice_number')->get();
        return view('payments.edit', compact('payment', 'invoices'));
    }

    /**
     * UPDATE: Modify an existing payment.
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'payment_number' => 'required|string|max:50|unique:payments,payment_number,' . $payment->id,
            'invoice_id'     => 'nullable|exists:invoices,id',
            'payment_date'   => 'nullable|date',
            'amount_paid'    => 'required|numeric|min:0',
            'currency'       => 'nullable|string|max:10',
            'payment_method' => 'nullable|string|max:50'
        ]);

        $payment->update($request->all());

        // Check invoice status again after update
        if ($payment->invoice) {
            $invoice = $payment->invoice;
            $paidSoFar = $invoice->payments()->sum('amount_paid');
            if ($paidSoFar >= $invoice->total) {
                $invoice->update(['status' => 'Paid']);
            } elseif ($paidSoFar > 0 && $paidSoFar < $invoice->total) {
                $invoice->update(['status' => 'Partially Paid']);
            } else {
                $invoice->update(['status' => 'Sent']); // or some other status
            }
        }

        return redirect()->route('payments.show', $payment->id)
                         ->with('success', 'Payment updated successfully.');
    }

    /**
     * DESTROY: Delete a payment record.
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $invoice = $payment->invoice; // in case we need to recalc
        $payment->delete();

        // Re-check invoice status
        if ($invoice) {
            $paidSoFar = $invoice->payments()->sum('amount_paid');
            if ($paidSoFar <= 0) {
                $invoice->update(['status' => 'Sent']);
            } elseif ($paidSoFar > 0 && $paidSoFar < $invoice->total) {
                $invoice->update(['status' => 'Partially Paid']);
            } elseif ($paidSoFar >= $invoice->total) {
                $invoice->update(['status' => 'Paid']);
            }
        }

        return redirect()->route('payments.index')
                         ->with('success', 'Payment deleted successfully.');
    }
}
