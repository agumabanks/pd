@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Payment Details</h1>

  @if(session('success'))
  <div class="mb-4 text-green-600">
    {{ session('success') }}
  </div>
  @endif

  <div class="mb-4 space-y-2">
    <p><strong>Payment #:</strong> {{ $payment->payment_number }}</p>
    <p><strong>Invoice ID:</strong> 
      @if($payment->invoice)
        <a href="{{ route('invoices.show', $payment->invoice->id) }}" class="text-blue-600 hover:underline">
          {{ $payment->invoice->invoice_number }} (ID: {{ $payment->invoice_id }})
        </a>
      @else
        N/A
      @endif
    </p>
    <p><strong>Date:</strong> {{ $payment->payment_date ?? 'N/A' }}</p>
    <p><strong>Amount Paid:</strong> {{ number_format($payment->amount_paid, 2) }} @if($payment->currency) {{ $payment->currency }} @endif</p>
    <p><strong>Method:</strong> {{ $payment->payment_method ?? 'N/A' }}</p>
    <p><strong>Notes:</strong> {{ $payment->notes ?? 'None' }}</p>
  </div>

  <div class="flex space-x-4">
    <a href="{{ route('payments.edit', $payment->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Edit</a>
    <a href="{{ route('payments.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back to List</a>
  </div>
</div>
@endsection
