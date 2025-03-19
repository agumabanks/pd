@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Edit Contract</h1>

  @if ($errors->any())
  <div class="mb-4">
    <ul class="list-disc list-inside text-red-600">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('contracts.update', $contract->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-gray-700">Contract Number</label>
      <input type="text" name="contract_number" value="{{ old('contract_number', $contract->contract_number) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600" required>
    </div>
    
    <div>
      <label class="block text-gray-700">Title</label>
      <input type="text" name="title" value="{{ old('title', $contract->title) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
    </div>

    <div>
      <label class="block text-gray-700">Description</label>
      <textarea name="description" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">{{ old('description', $contract->description) }}</textarea>
    </div>

    <div>
      <label class="block text-gray-700">Status</label>
      <input type="text" name="status" value="{{ old('status', $contract->status) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600" required>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700">Effective Date</label>
        <input type="date" name="effective_date" value="{{ old('effective_date', $contract->effective_date) }}"
               class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
      </div>
      <div>
        <label class="block text-gray-700">Expiration Date</label>
        <input type="date" name="expiration_date" value="{{ old('expiration_date', $contract->expiration_date) }}"
               class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700">Total Value</label>
        <input type="number" step="0.01" name="total_value" value="{{ old('total_value', $contract->total_value) }}"
               class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
      </div>
      <div>
        <label class="block text-gray-700">Currency</label>
        <input type="text" name="currency" value="{{ old('currency', $contract->currency) }}"
               class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
      </div>
    </div>

    <div class="flex space-x-4">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Contract</button>
      <a href="{{ route('contracts.show', $contract->id) }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
    </div>
  </form>
</div>
@endsection
