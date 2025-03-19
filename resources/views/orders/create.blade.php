@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Create New Order</h1>

  @if ($errors->any())
  <div class="mb-4">
    <ul class="list-disc list-inside text-red-600">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label for="order_number" class="block text-gray-700">Order Number</label>
      <input type="text" name="order_number" id="order_number" value="{{ old('order_number') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <div>
      <label for="status" class="block text-gray-700">Order Status</label>
      <input type="text" name="status" id="status" value="{{ old('status') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <div>
      <label for="change_order_status" class="block text-gray-700">Change Order Status</label>
      <input type="text" name="change_order_status" id="change_order_status" value="{{ old('change_order_status') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div>
      <label for="requested_delivery_date" class="block text-gray-700">Requested Delivery Date</label>
      <input type="date" name="requested_delivery_date" id="requested_delivery_date" value="{{ old('requested_delivery_date') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div>
      <label for="promised_delivery_date" class="block text-gray-700">Promised Delivery Date</label>
      <input type="date" name="promised_delivery_date" id="promised_delivery_date" value="{{ old('promised_delivery_date') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div>
      <label for="acknowledge_due_date" class="block text-gray-700">Acknowledge Due Date</label>
      <input type="date" name="acknowledge_due_date" id="acknowledge_due_date" value="{{ old('acknowledge_due_date') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div>
      <label for="pdf_url" class="block text-gray-700">PO PDF URL</label>
      <input type="url" name="pdf_url" id="pdf_url" value="{{ old('pdf_url') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div class="flex space-x-4">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Order</button>
      <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
    </div>
  </form>
</div>
@endsection
