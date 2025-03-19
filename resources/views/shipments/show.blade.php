@extends('layouts.dash')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow p-6 rounded">
    <h1 class="text-2xl font-light mb-4">Shipment Details</h1>

    @if (session('success'))
    <div class="mb-4 text-green-600">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-4 space-y-2">
        <p><strong>Shipment #:</strong> {{ $shipment->shipment_number }}</p>
        <p><strong>Status:</strong> {{ $shipment->status }}</p>
        <p><strong>Shipped Date:</strong> {{ $shipment->shipped_date ?? 'N/A' }}</p>
        <p><strong>Expected Receipt Date:</strong> {{ $shipment->expected_receipt_date ?? 'N/A' }}</p>
        <p><strong>Incoterm:</strong> {{ $shipment->incoterm ?? 'N/A' }}</p>
        <p><strong>Shipping Method:</strong> {{ $shipment->shipping_method ?? 'N/A' }}</p>
        <p><strong>BOL/AWB #:</strong> {{ $shipment->bol_awb_number ?? 'N/A' }}</p>
        <p><strong>Comments:</strong> {{ $shipment->comments ?? 'None' }}</p>
    </div>

    <!-- Attachments (ASNs) -->
    <div class="mb-4">
        <h2 class="text-xl font-light mb-2">Attachments / ASN Docs</h2>
        @php
            $attachments = $shipment->attachments ? json_decode($shipment->attachments, true) : [];
        @endphp
        @if(count($attachments) > 0)
            <ul class="list-disc ml-6">
                @foreach($attachments as $file)
                <li>
                    <!-- Example link if you stored them in 'public/storage/asn_docs' -->
                    <a href="{{ asset('storage/asn_docs/' . $file) }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ $file }}
                    </a>
                </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">No attachments found.</p>
        @endif

        <form action="{{ route('shipments.upload_asn', $shipment->id) }}" method="POST" enctype="multipart/form-data" class="mt-2 inline-block">
            @csrf
            <label class="block text-gray-700 mb-2">Upload New ASN Document</label>
            <div class="flex space-x-2 items-center">
                <input type="file" name="asn_file" required 
                       class="border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Upload</button>
            </div>
        </form>
    </div>

    <!-- Shipment Lines -->
    <div class="mb-6">
        <h2 class="text-xl font-light mb-2">Shipment Lines</h2>
        <a href="{{ route('shipments.create_line', $shipment->id) }}" class="inline-block mb-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
            Add Shipment Line
        </a>

        @if($shipment->lines->count() > 0)
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b">Item Code</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Quantity</th>
                    <th class="py-2 px-4 border-b">Unit Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shipment->lines as $line)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $line->item_code }}</td>
                    <td class="py-2 px-4 border-b">{{ $line->description }}</td>
                    <td class="py-2 px-4 border-b">{{ $line->quantity }}</td>
                    <td class="py-2 px-4 border-b">
                        @if($line->unit_price) ${{ number_format($line->unit_price,2) }} @else N/A @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-gray-600">No shipment lines yet.</p>
        @endif
    </div>

    <!-- Shipment Receipts -->
    <div class="mb-6">
        <h2 class="text-xl font-light mb-2">Receipts</h2>
        <a href="{{ route('shipments.create_receipt', $shipment->id) }}" class="inline-block mb-2 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
            Record Receipt
        </a>

        @if($shipment->receipts->count() > 0)
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b">Line ID</th>
                    <th class="py-2 px-4 border-b">Received Qty</th>
                    <th class="py-2 px-4 border-b">Receipt Date</th>
                    <th class="py-2 px-4 border-b">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shipment->receipts as $receipt)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">
                        @if($receipt->line)
                          {{ $receipt->line->item_code }} (Line #{{ $receipt->line->id }})
                        @else
                          N/A
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b">{{ $receipt->received_quantity }}</td>
                    <td class="py-2 px-4 border-b">{{ $receipt->receipt_date }}</td>
                    <td class="py-2 px-4 border-b">{{ $receipt->remarks ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-gray-600">No receipts recorded.</p>
        @endif
    </div>

    <!-- Shipment Returns -->
    <div class="mb-6">
        <h2 class="text-xl font-light mb-2">Returns</h2>
        <a href="{{ route('shipments.create_return', $shipment->id) }}" class="inline-block mb-2 px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
            Record Return
        </a>

        @if($shipment->returns->count() > 0)
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b">Line ID</th>
                    <th class="py-2 px-4 border-b">Returned Qty</th>
                    <th class="py-2 px-4 border-b">Return Date</th>
                    <th class="py-2 px-4 border-b">Reason</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shipment->returns as $return)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">
                        @if($return->line)
                          {{ $return->line->item_code }} (Line #{{ $return->line->id }})
                        @else
                          N/A
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b">{{ $return->returned_quantity }}</td>
                    <td class="py-2 px-4 border-b">{{ $return->return_date }}</td>
                    <td class="py-2 px-4 border-b">{{ $return->return_reason ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-gray-600">No returns recorded.</p>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('shipments.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back to List</a>
    </div>
</div>
@endsection
