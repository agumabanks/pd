@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Add Line to Contract: {{ $contract->contract_number }}</h1>

  @if ($errors->any())
  <div class="mb-4">
    <ul class="list-disc list-inside text-red-600">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('contracts.store_line', $contract->id) }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label class="block text-gray-700">Item Code</label>
      <input type="text" name="line_item" value="{{ old('line_item') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
    </div>

    <div>
      <label class="block text-gray-700">Description</label>
      <textarea name="description" rows="2"
                class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">{{ old('description') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-gray-700">Quantity</label>
        <input type="number" name="quantity" value="{{ old('quantity', 1) }}"
               class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600" required>
      </div>
      <div>
        <label class="block text-gray-700">Unit Price</label>
        <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price') }}"
               class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
      </div>
    </div>

    <div class="flex space-x-4">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Add Line</button>
      <a href="{{ route('contracts.show', $contract->id) }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
    </div>
  </form>
</div>
@endsection
