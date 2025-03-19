@extends('layouts.dash')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow p-6 rounded">
    <h1 class="text-2xl font-light mb-4">View Returns</h1>
    <p class="text-gray-700">Display all or filtered returns for your shipments here.</p>
    
    <!-- Example table (not fully implemented) -->
    <table class="min-w-full bg-white mt-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border-b">Shipment #</th>
                <th class="py-2 px-4 border-b">Return Date</th>
                <th class="py-2 px-4 border-b">Quantity Returned</th>
                <th class="py-2 px-4 border-b">Reason</th>
            </tr>
        </thead>
        <tbody>
            <!-- Implement your logic to list returns -->
            <tr class="hover:bg-gray-50">
                <td class="py-2 px-4 border-b">SHIP12345</td>
                <td class="py-2 px-4 border-b">2025-03-20</td>
                <td class="py-2 px-4 border-b">10</td>
                <td class="py-2 px-4 border-b">Damaged items</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
