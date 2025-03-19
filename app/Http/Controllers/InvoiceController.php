<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

use App\Models\InvoiceLine;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * INDEX: List all invoices with search and pagination.
     */
    public function index(Request $request)
    {
        $query = Invoice::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('invoice_number', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
        }

        $invoices = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('invoices.index', compact('invoices'));
    }

    /**
     * CREATE: Show form for creating a new invoice.
     */
    public function create()
    {
        return view('invoices.create');
    }

    /**
     * STORE: Save a new invoice and lines if needed.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:50|unique:invoices',
            'status'         => 'required|string|max:50',
            'invoice_date'   => 'nullable|date',
            'due_date'       => 'nullable|date',
            'subtotal'       => 'nullable|numeric',
            'tax_amount'     => 'nullable|numeric',
            'total'          => 'nullable|numeric',
            'currency'       => 'nullable|string|max:10'
        ]);

        $invoice = Invoice::create($request->all());

        // Optionally handle file attachments
        // if ($request->hasFile('attachment')) {
        //     // handle storing file
        // }

        return redirect()->route('invoices.show', $invoice->id)
                         ->with('success', 'Invoice created successfully.');
    }

    /**
     * SHOW: Display a single invoice with lines and payments.
     */
    public function show($id)
    {
        $invoice = Invoice::with(['lines', 'payments'])->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * EDIT: Show the form to edit an invoice.
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoices.edit', compact('invoice'));
    }

    /**
     * UPDATE: Modify an existing invoice.
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $request->validate([
            'invoice_number' => 'required|string|max:50|unique:invoices,invoice_number,' . $invoice->id,
            'status'         => 'required|string|max:50',
            'invoice_date'   => 'nullable|date',
            'due_date'       => 'nullable|date',
            'subtotal'       => 'nullable|numeric',
            'tax_amount'     => 'nullable|numeric',
            'total'          => 'nullable|numeric',
            'currency'       => 'nullable|string|max:10'
        ]);

        $invoice->update($request->all());

        return redirect()->route('invoices.show', $invoice->id)
                         ->with('success', 'Invoice updated successfully.');
    }

    /**
     * DESTROY: Delete an invoice and cascade lines.
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices.index')
                         ->with('success', 'Invoice deleted successfully.');
    }

    /**
     * CREATE LINE: Show form to add a line item.
     */
    public function createLine($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        return view('invoices.create_line', compact('invoice'));
    }

    /**
     * STORE LINE: Add a line to the invoice.
     */
    public function storeLine(Request $request, $invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        $request->validate([
            'item_code'   => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'quantity'    => 'required|integer|min:1',
            'unit_price'  => 'required|numeric|min:0',
        ]);

        // Calculate line total
        $lineTotal = $request->input('quantity') * $request->input('unit_price');

        $line = InvoiceLine::create([
            'invoice_id'  => $invoice->id,
            'item_code'   => $request->input('item_code'),
            'description' => $request->input('description'),
            'quantity'    => $request->input('quantity'),
            'unit_price'  => $request->input('unit_price'),
            'line_total'  => $lineTotal
        ]);

        // Recalculate invoice totals
        $this->recalculateInvoiceTotals($invoice);

        return redirect()->route('invoices.show', $invoice->id)
                         ->with('success', 'Invoice line added successfully.');
    }

    /**
     * Recalculate invoice totals based on lines.
     */
    protected function recalculateInvoiceTotals(Invoice $invoice)
    {
        $subtotal = $invoice->lines()->sum('line_total');
        // If you apply tax logic, do so here
        // e.g. $tax = $subtotal * 0.1;

        $invoice->update([
            'subtotal' => $subtotal,
            // 'tax_amount' => $tax,
            'total'    => $subtotal + $invoice->tax_amount,
        ]);
    }


 

public function createWithoutPo()
{
    return view('invoices.create_without_po');
}

}
