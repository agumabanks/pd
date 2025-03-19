@extends('layouts.dash')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-light">Shipments</h1>
        <a href="{{ route('shipments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Create New Shipment
        </a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('shipments.index') }}" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="search" placeholder="Search by shipment number, status, incoterm" value="{{ request('search') }}"
                   class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Search</button>
        </div>
    </form>

    <!-- Shipments Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">ID</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Shipment #</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Status</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Shipped</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Expected Receipt</th>
                    <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shipments as $shipment)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b text-sm">{{ $shipment->id }}</td>
                    <td class="py-2 px-4 border-b text-sm">{{ $shipment->shipment_number }}</td>
                    <td class="py-2 px-4 border-b text-sm">{{ $shipment->status }}</td>
                    <td class="py-2 px-4 border-b text-sm">{{ $shipment->shipped_date ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b text-sm">{{ $shipment->expected_receipt_date ?? 'N/A' }}</td>
                    <td class="py-2 px-4 border-b text-sm">
                        <a href="{{ route('shipments.show', $shipment->id) }}" class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('shipments.edit', $shipment->id) }}" class="ml-2 text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('shipments.destroy', $shipment->id) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete shipment?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $shipments->links() }}
    </div>
</div>
@endsection
