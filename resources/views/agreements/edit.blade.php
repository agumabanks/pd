@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Edit Agreement</h1>

  @if ($errors->any())
  <div class="mb-4">
    <ul class="list-disc list-inside text-red-600">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('agreements.update', $agreement->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <div>
      <label for="agreement_number" class="block text-gray-700">Agreement Number</label>
      <input type="text" name="agreement_number" id="agreement_number" value="{{ old('agreement_number', $agreement->agreement_number) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <div>
      <label for="legal_entity" class="block text-gray-700">Legal Entity</label>
      <input type="text" name="legal_entity" id="legal_entity" value="{{ old('legal_entity', $agreement->legal_entity) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <div>
      <label for="business_unit" class="block text-gray-700">Business Unit</label>
      <input type="text" name="business_unit" id="business_unit" value="{{ old('business_unit', $agreement->business_unit) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <div>
      <label for="agreement_type" class="block text-gray-700">Agreement Type</label>
      <input type="text" name="agreement_type" id="agreement_type" value="{{ old('agreement_type', $agreement->agreement_type) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <div>
      <label for="agreement_status" class="block text-gray-700">Agreement Status</label>
      <input type="text" name="agreement_status" id="agreement_status" value="{{ old('agreement_status', $agreement->agreement_status) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <div>
      <label for="agreement_amount" class="block text-gray-700">Agreement Amount</label>
      <input type="number" step="0.01" name="agreement_amount" id="agreement_amount" value="{{ old('agreement_amount', $agreement->agreement_amount) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div>
      <label for="minimum_release_amount" class="block text-gray-700">Minimum Release Amount</label>
      <input type="number" step="0.01" name="minimum_release_amount" id="minimum_release_amount" value="{{ old('minimum_release_amount', $agreement->minimum_release_amount) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div>
      <label for="released_amount" class="block text-gray-700">Released Amount</label>
      <input type="number" step="0.01" name="released_amount" id="released_amount" value="{{ old('released_amount', $agreement->released_amount) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div>
      <label for="effective_date" class="block text-gray-700">Effective Date</label>
      <input type="date" name="effective_date" id="effective_date" value="{{ old('effective_date', $agreement->effective_date) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div>
      <label for="expiration_date" class="block text-gray-700">Expiration Date</label>
      <input type="date" name="expiration_date" id="expiration_date" value="{{ old('expiration_date', $agreement->expiration_date) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div class="flex space-x-4">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Agreement</button>
      <a href="{{ route('agreements.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
    </div>
  </form>
</div>
@endsection
