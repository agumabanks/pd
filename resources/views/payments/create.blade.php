@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Create New Payment</h1>

  @if ($errors->any())
  <div class="mb-4">
    <ul class="list-disc list-inside text-red-600">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('payments.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
      <label class="block text-gray-700">Payment Number</label>
      <input type="text" name="payment_number" value="{{ old('payment_number') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600" required>
    </div>

    <div>
      <label class="block text-gray-700">Invoice</label>
      <select name="invoice_id" class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
        <option value="">-- None --</option>
        @foreach($invoices as $inv)
        <option value="{{ $inv->id }}" {{ old('invoice_id') == $inv->id ? 'selected' : '' }}>
          {{ $inv->invoice_number }} (ID: {{ $inv->id }})
        </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-gray-700">Payment Date</label>
      <input type="date" name="payment_date" value="{{ old('payment_date') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
    </div>

    <div>
      <label class="block text-gray-700">Amount Paid</label>
      <input type="number" step="0.01" name="amount_paid" value="{{ old('amount_paid', 0) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600" required>
    </div>

    <div>
      <label class="block text-gray-700">Currency</label>
      <input type="text" name="currency" value="{{ old('currency', 'USD') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
    </div>

    <div>
      <label class="block text-gray-700">Payment Method</label>
      <input type="text" name="payment_method" value="{{ old('payment_method') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
    </div>

    <div>
      <label class="block text-gray-700">Notes</label>
      <textarea name="notes" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">{{ old('notes') }}</textarea>
    </div>

    <div class="flex space-x-4">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Payment</button>
      <a href="{{ route('payments.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
    </div>
  </form>
</div>
@endsection
