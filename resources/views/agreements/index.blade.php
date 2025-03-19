@extends('layouts.dash')

@section('content')
<div class="mb-8">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-light">Agreements</h1>
    <div>
      <a href="{{ route('agreements.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create New Agreement</a>
      <a href="{{ route('agreements.export') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Export CSV</a>
    </div>
  </div>

  <!-- Advanced Search Form -->
  <form method="GET" action="{{ route('agreements.index') }}" class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <input type="text" name="search" placeholder="Search by number, unit, type, status" value="{{ request('search') }}"
             class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
      <input type="date" name="from_date" placeholder="From Date" value="{{ request('from_date') }}"
             class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
      <input type="date" name="to_date" placeholder="To Date" value="{{ request('to_date') }}"
             class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Search</button>
    </div>
  </form>

  <!-- Agreements Table -->
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white">
      <thead class="bg-gray-100">
        <tr>
          <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-medium text-gray-700">ID</th>
          <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Agreement Number</th>
          <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Business Unit</th>
          <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Type</th>
          <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Status</th>
          <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Amount</th>
          <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Effective Date</th>
          <th class="py-2 px-4 border-b border-gray-200 text-left text-sm font-medium text-gray-700">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($agreements as $agreement)
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $agreement->id }}</td>
          <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $agreement->agreement_number }}</td>
          <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $agreement->business_unit }}</td>
          <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $agreement->agreement_type }}</td>
          <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $agreement->agreement_status }}</td>
          <td class="py-2 px-4 border-b border-gray-200 text-sm">${{ number_format($agreement->agreement_amount, 2) }}</td>
          <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $agreement->effective_date }}</td>
          <td class="py-2 px-4 border-b border-gray-200 text-sm">
            <a href="{{ route('agreements.show', $agreement->id) }}" class="text-blue-600 hover:underline">View</a>
            <a href="{{ route('agreements.edit', $agreement->id) }}" class="ml-2 text-yellow-600 hover:underline">Edit</a>
            <form action="{{ route('agreements.destroy', $agreement->id) }}" method="POST" class="inline-block ml-2">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this agreement?')">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Pagination Links -->
  <div class="mt-6">
    {{ $agreements->links() }}
  </div>
</div>
@endsection
