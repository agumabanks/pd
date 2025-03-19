@extends('layouts.dash')

@section('content')
<div class="mb-8">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-light">Payments</h1>
    <a href="{{ route('payments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
      Create New Payment
    </a>
  </div>

  <!-- Search Form -->
  <form method="GET" action="{{ route('payments.index') }}" class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <input type="text" name="search" placeholder="Search by payment #, method" value="{{ request('search') }}"
             class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Search</button>
    </div>
  </form>

  <!-- Payments Table -->
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white">
      <thead class="bg-gray-100">
        <tr>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">ID</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Payment #</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Invoice ID</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Payment Date</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Amount</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($payments as $payment)
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b text-sm">{{ $payment->id }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $payment->payment_number }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $payment->invoice_id ?? 'None' }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $payment->payment_date ?? 'N/A' }}</td>
          <td class="py-2 px-4 border-b text-sm">
            {{ number_format($payment->amount_paid, 2) }}
            @if($payment->currency) {{ $payment->currency }} @endif
          </td>
          <td class="py-2 px-4 border-b text-sm">
            <a href="{{ route('payments.show', $payment->id) }}" class="text-blue-600 hover:underline">View</a>
            <a href="{{ route('payments.edit', $payment->id) }}" class="ml-2 text-yellow-600 hover:underline">Edit</a>
            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="inline-block ml-2">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete payment?')">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Pagination Links -->
  <div class="mt-6">
    {{ $payments->links() }}
  </div>
</div>
@endsection
