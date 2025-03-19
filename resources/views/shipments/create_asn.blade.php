@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Create ASN for Shipment: {{ $shipment->shipment_number }}</h1>
  <p class="mb-4 text-gray-700">Fill in the details to generate your Advance Shipping Notice.</p>
  <form action="{{ route('shipments.upload_asn', $shipment->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <!-- You can include extra ASN fields as needed -->
    <div>
      <label for="asn_file" class="block text-gray-700">Upload ASN Document</label>
      <input type="file" name="asn_file" id="asn_file"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <div class="flex space-x-4">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Upload ASN</button>
      <a href="{{ route('shipments.show', $shipment->id) }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
    </div>
  </form>
</div>
@endsection
