@extends('layouts.dash')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Invoice Details</h1>

  @if(session('success'))
  <div class="mb-4 text-green-600">
    {{ session('success') }}
  </div>
  @endif

  <div class="mb-4 space-y-2">
    <p><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
    <p><strong>Status:</strong> {{ $invoice->status }}</p>
    <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date ?? 'N/A' }}</p>
    <p><strong>Due Date:</strong> {{ $invoice->due_date ?? 'N/A' }}</p>
    <p><strong>Reference:</strong> {{ $invoice->reference ?? 'N/A' }}</p>
    <p><strong>Subtotal:</strong> {{ number_format($invoice->subtotal, 2) }} @if($invoice->currency) {{ $invoice->currency }} @endif</p>
    <p><strong>Tax:</strong> {{ number_format($invoice->tax_amount, 2) }} @if($invoice->currency) {{ $invoice->currency }} @endif</p>
    <p><strong>Total:</strong> {{ number_format($invoice->total, 2) }} @if($invoice->currency) {{ $invoice->currency }} @endif</p>
    <p><strong>Paid So Far:</strong> {{ number_format($invoice->paid_amount, 2) }} @if($invoice->currency) {{ $invoice->currency }} @endif</p>
    <p><strong>Balance Due:</strong> {{ number_format($invoice->balance_due, 2) }} @if($invoice->currency) {{ $invoice->currency }} @endif</p>
    <p><strong>Notes:</strong> {{ $invoice->notes ?? 'None' }}</p>
  </div>

  <!-- Invoice Lines -->
  <div class="mb-6">
    <h2 class="text-xl font-light mb-2">Invoice Lines</h2>
    <a href="{{ route('invoices.create_line', $invoice->id) }}" class="inline-block mb-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
      Add Line
    </a>
    
    @if($invoice->lines->count() > 0)
    <table class="min-w-full bg-white">
      <thead class="bg-gray-100">
        <tr>
          <th class="py-2 px-4 border-b">Item Code</th>
          <th class="py-2 px-4 border-b">Description</th>
          <th class="py-2 px-4 border-b">Quantity</th>
          <th class="py-2 px-4 border-b">Unit Price</th>
          <th class="py-2 px-4 border-b">Line Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($invoice->lines as $line)
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b">{{ $line->item_code }}</td>
          <td class="py-2 px-4 border-b">{{ $line->description }}</td>
          <td class="py-2 px-4 border-b">{{ $line->quantity }}</td>
          <td class="py-2 px-4 border-b">{{ number_format($line->unit_price, 2) }}</td>
          <td class="py-2 px-4 border-b">{{ number_format($line->line_total, 2) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <p class="text-gray-600">No lines added yet.</p>
    @endif
  </div>

  <!-- Payments Linked to This Invoice -->
  <div class="mb-6">
    <h2 class="text-xl font-light mb-2">Payments</h2>
    @if($invoice->payments->count() > 0)
    <table class="min-w-full bg-white">
      <thead class="bg-gray-100">
        <tr>
          <th class="py-2 px-4 border-b">Payment #</th>
          <th class="py-2 px-4 border-b">Date</th>
          <th class="py-2 px-4 border-b">Amount Paid</th>
          <th class="py-2 px-4 border-b">Method</th>
        </tr>
      </thead>
      <tbody>
        @foreach($invoice->payments as $payment)
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b">
            <a href="{{ route('payments.show', $payment->id) }}" class="text-blue-600 hover:underline">
              {{ $payment->payment_number }}
            </a>
          </td>
          <td class="py-2 px-4 border-b">{{ $payment->payment_date ?? 'N/A' }}</td>
          <td class="py-2 px-4 border-b">{{ number_format($payment->amount_paid, 2) }} @if($payment->currency) {{ $payment->currency }} @endif</td>
          <td class="py-2 px-4 border-b">{{ $payment->payment_method ?? 'N/A' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <p class="text-gray-600">No payments recorded for this invoice.</p>
    @endif
  </div>

  <div class="mt-4">
    <a href="{{ route('invoices.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back to List</a>
  </div>
</div>
@endsection
