@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Edit Shipment</h1>

  @if ($errors->any())
  <div class="mb-4">
    <ul class="list-disc list-inside text-red-600">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('shipments.update', $shipment->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <!-- Similar fields as the create view, pre-filled with $shipment data -->
    <div>
      <label for="shipment_number" class="block text-gray-700">Shipment Number</label>
      <input type="text" name="shipment_number" id="shipment_number" value="{{ old('shipment_number', $shipment->shipment_number) }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <!-- Other fields... -->
    <div class="flex space-x-4">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Shipment</button>
      <a href="{{ route('shipments.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
    </div>
  </form>
</div>
@endsection
