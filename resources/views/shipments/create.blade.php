@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
    <h1 class="text-2xl font-light mb-4">Create New Shipment</h1>

    @if ($errors->any())
    <div class="mb-4">
        <ul class="list-disc list-inside text-red-600">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('shipments.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
        @csrf
        
        <div>
            <label class="block text-gray-700">Shipment Number</label>
            <input type="text" name="shipment_number" value="{{ old('shipment_number') }}" 
                   class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600" required>
        </div>

        <div>
            <label class="block text-gray-700">Status</label>
            <input type="text" name="status" value="{{ old('status', 'Pending') }}"
                   class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Shipped Date</label>
                <input type="date" name="shipped_date" value="{{ old('shipped_date') }}"
                       class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-gray-700">Expected Receipt Date</label>
                <input type="date" name="expected_receipt_date" value="{{ old('expected_receipt_date') }}"
                       class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <div>
            <label class="block text-gray-700">Incoterm</label>
            <input type="text" name="incoterm" value="{{ old('incoterm') }}"
                   class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
        </div>

        <div>
            <label class="block text-gray-700">Shipping Method</label>
            <input type="text" name="shipping_method" value="{{ old('shipping_method') }}"
                   class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
        </div>

        <div>
            <label class="block text-gray-700">BOL/AWB Number</label>
            <input type="text" name="bol_awb_number" value="{{ old('bol_awb_number') }}"
                   class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
        </div>

        <div>
            <label class="block text-gray-700">Comments</label>
            <textarea name="comments" rows="3" 
                      class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">{{ old('comments') }}</textarea>
        </div>

        {{-- Example: If you want to handle ASN file in creation --}}
        {{-- 
        <div>
            <label class="block text-gray-700">ASN Document</label>
            <input type="file" name="asn_file" class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
        </div>
        --}}

        <div class="flex space-x-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Shipment</button>
            <a href="{{ route('shipments.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
        </div>
    </form>
</div>
@endsection
