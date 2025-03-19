@extends('layouts.dash')

@section('content')
<div class="mb-8">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-light">Contracts</h1>
    <a href="{{ route('contracts.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
      Create New Contract
    </a>
  </div>

  <!-- Search Form -->
  <!-- <form method="GET" action="{{ route('contracts.index') }}" class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <input type="text" name="search" placeholder="Search by number, title, status" value="{{ request('search') }}"
             class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Search</button>
    </div>
  </form> -->

  <!-- Contracts Table -->
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white">
      <thead class="bg-gray-100">
        <tr>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">ID</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Contract #</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Title</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Status</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Effective Date</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($contracts as $contract)
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b text-sm">{{ $contract->id }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $contract->contract_number }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $contract->title ?? 'N/A' }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $contract->status }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $contract->effective_date ?? 'N/A' }}</td>
          <td class="py-2 px-4 border-b text-sm">
            <a href="{{ route('contracts.show', $contract->id) }}" class="text-blue-600 hover:underline">View</a>
            <a href="{{ route('contracts.edit', $contract->id) }}" class="ml-2 text-yellow-600 hover:underline">Edit</a>
            <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" class="inline-block ml-2">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this contract?')">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $contracts->links() }}
  </div>
</div>
@endsection
