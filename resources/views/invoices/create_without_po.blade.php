{{-- resources/views/invoices/create_without_po.blade.php --}}
@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
    <h1 class="text-2xl font-light mb-4">Create Invoice Without PO</h1>

    @if ($errors->any())
    <div class="mb-4">
        <ul class="list-disc list-inside text-red-600">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('invoices.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
        @csrf

        {{-- 
             Since this is "without PO," you might skip or hide any 
             purchase-order-related fields. Otherwise, the logic
             is very similar to create.blade.php.
        --}}

        <div>
            <label class="block text-gray-700">Invoice Number</label>
            <input type="text" name="invoice_number" value="{{ old('invoice_number') }}" 
                   class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600" required>
        </div>

        <div>
            <label class="block text-gray-700">Status</label>
            <input type="text" name="status" value="{{ old('status', 'Draft') }}" 
                   class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Invoice Date</label>
                <input type="date" name="invoice_date" value="{{ old('invoice_date') }}"
                       class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-gray-700">Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date') }}"
                       class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700">Subtotal</label>
                <input type="number" step="0.01" name="subtotal" value="{{ old('subtotal', 0) }}"
                       class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-gray-700">Tax Amount</label>
                <input type="number" step="0.01" name="tax_amount" value="{{ old('tax_amount', 0) }}"
                       class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
            </div>
            <div>
                <label class="block text-gray-700">Total</label>
                <input type="number" step="0.01" name="total" value="{{ old('total', 0) }}"
                       class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
            </div>
        </div>

        <div>
            <label class="block text-gray-700">Currency</label>
            <input type="text" name="currency" value="{{ old('currency', 'USD') }}"
                   class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
        </div>

        {{-- Notice we omit or disable any field referencing a PO --}}
        <div>
            <label class="block text-gray-700">Reference</label>
            <input type="text" name="reference" value="{{ old('reference', 'No PO') }}"
                   class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600"
                   readonly>
        </div>

        <div>
            <label class="block text-gray-700">Notes</label>
            <textarea name="notes" rows="3"
                      class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">{{ old('notes') }}</textarea>
        </div>

        {{-- 
             Example for attachments:
             <div>
                 <label class="block text-gray-700">Attachment</label>
                 <input type="file" name="attachment" class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-blue-600">
             </div>
        --}}

        <div class="flex space-x-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Invoice</button>
            <a href="{{ route('invoices.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
        </div>
    </form>
</div>
@endsection
