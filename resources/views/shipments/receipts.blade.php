@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Receipts for Shipment: {{ $shipment->shipment_number }}</h1>
  <p class="text-gray-700">This section will display all receipts related to this shipment.</p>
  <!-- You can integrate a table or timeline for receipts here -->
  <div class="mt-4">
    <p class="text-gray-700">Feature under development. Coming soon...</p>
  </div>
</div>
@endsection
