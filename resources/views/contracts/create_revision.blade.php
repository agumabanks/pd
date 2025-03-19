@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Create Revision for Contract: {{ $contract->contract_number }}</h1>

  @if ($errors->any())
  <div class="mb-4">
    <ul class="list-disc list-inside text-red-600">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('contracts.store_revision', $contract->id) }}" method="POST" class="space-y-4">
    @csrf
    
    <div>
      <label class="block text-gray-700">Revision Number</label>
      <input type="number" name="revision_number" value="{{ old('revision_number', $nextRevisionNumber) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600" required>
    </div>

    <div>
      <label class="block text-gray-700">Revision Notes</label>
      <textarea name="revision_notes" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">{{ old('revision_notes') }}</textarea>
    </div>

    <div>
      <label class="block text-gray-700">Initiated By</label>
      <input type="text" name="initiated_by" value="{{ old('initiated_by') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
    </div>

    <div class="flex space-x-4">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Revision</button>
      <a href="{{ route('contracts.show', $contract->id) }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
    </div>
  </form>
</div>
@endsection
