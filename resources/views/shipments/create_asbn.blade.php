@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
    <h1 class="text-2xl font-light mb-4">Create ASBN</h1>
    <p class="text-gray-700">Here you can create an Advanced Shipping & Billing Notice. Adapt as needed.</p>
    <!-- Example form (not fully implemented) -->
    <form action="#" method="POST" class="mt-4">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Shipment Number</label>
            <input type="text" name="shipment_number" class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600 w-full">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create ASBN</button>
    </form>
</div>
@endsection
