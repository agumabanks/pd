@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
    <h1 class="text-2xl font-light mb-4">Record Return for Shipment: {{ $shipment->shipment_number }}</h1>

    @if ($errors->any())
    <div class="mb-4">
        <ul class="list-disc list-inside text-red-600">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('shipments.store_return', $shipment->id) }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700">Shipment Line</label>
            <select name="shipment_line_id" class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
                <option value="">-- None --</option>
                @foreach($shipment->lines as $line)
                <option value="{{ $line->id }}" {{ old('shipment_line_id') == $line->id ? 'selected' : '' }}>
                    {{ $line->item_code }} (Line #{{ $line->id }}) - Qty: {{ $line->quantity }}
                </option>
                @endforeach
            </select>
            <small class="text-gray-500">Select a line if partial returns. Leave blank for entire shipment return.</small>
        </div>

        <div>
            <label class="block text-gray-700">Returned Quantity</label>
            <input type="number" name="returned_quantity" value="{{ old('returned_quantity') }}"
                   class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600" required>
        </div>

        <div>
            <label class="block text-gray-700">Return Date</label>
            <input type="date" name="return_date" value="{{ old('return_date') }}"
                   class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600" required>
        </div>

        <div>
            <label class="block text-gray-700">Return Reason</label>
            <textarea name="return_reason" rows="3"
                      class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">{{ old('return_reason') }}</textarea>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Record Return</button>
            <a href="{{ route('shipments.show', $shipment->id) }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
        </div>
    </form>
</div>
@endsection
