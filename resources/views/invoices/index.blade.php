@extends('layouts.dash')

@section('content')
<div class="mb-8">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-light">Invoices</h1>
    <a href="{{ route('invoices.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
      Create New Invoice
    </a>
  </div>

  <!-- Search Form -->
  <form method="GET" action="{{ route('invoices.index') }}" class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <input type="text" name="search" placeholder="Search by invoice #, status, or reference" value="{{ request('search') }}"
             class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Search</button>
    </div>
  </form>

  <!-- Invoices Table -->
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white">
      <thead class="bg-gray-100">
        <tr>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">ID</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Invoice #</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Status</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Total</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Balance Due</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($invoices as $invoice)
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b text-sm">{{ $invoice->id }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $invoice->invoice_number }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $invoice->status }}</td>
          <td class="py-2 px-4 border-b text-sm">
            {{ number_format($invoice->total, 2) }}
            @if($invoice->currency) {{ $invoice->currency }} @endif
          </td>
          <td class="py-2 px-4 border-b text-sm">
            {{ number_format($invoice->balance_due, 2) }}
            @if($invoice->currency) {{ $invoice->currency }} @endif
          </td>
          <td class="py-2 px-4 border-b text-sm">
            <a href="{{ route('invoices.show', $invoice->id) }}" class="text-blue-600 hover:underline">View</a>
            <a href="{{ route('invoices.edit', $invoice->id) }}" class="ml-2 text-yellow-600 hover:underline">Edit</a>
            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="inline-block ml-2">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this invoice?')">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Pagination Links -->
  <div class="mt-6">
    {{ $invoices->links() }}
  </div>
</div>
@endsection
