@extends('layouts.dash')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow p-6 rounded">
    <h1 class="text-2xl font-light mb-6 text-gray-800">Create New Contract</h1>

    @if ($errors->any())
    <div class="mb-4 border border-red-200 bg-red-50 p-4 rounded">
        <ul class="list-disc list-inside text-red-600 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form 
        action="{{ route('contracts.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
        class="space-y-6"
    >
        @csrf
        
        <!-- Contract Number -->
        <div>
            <label class="block text-gray-700 font-medium">Contract Number <span class="text-red-600">*</span></label>
            <input 
                type="text" 
                name="contract_number" 
                value="{{ old('contract_number') }}"
                class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
                placeholder="e.g. CNT-2025-001" 
                required
            >
            <p class="text-xs text-gray-400 mt-1">Unique identifier for this contract.</p>
        </div>

        <!-- Title -->
        <div>
            <label class="block text-gray-700 font-medium">Title</label>
            <input 
                type="text" 
                name="title" 
                value="{{ old('title') }}"
                class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
                placeholder="Short descriptive title"
            >
        </div>

        <!-- Description -->
        <div>
            <label class="block text-gray-700 font-medium">Description</label>
            <textarea 
                name="description" 
                rows="3"
                class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
                placeholder="Details, scope, or special conditions..."
            >{{ old('description') }}</textarea>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-gray-700 font-medium">Status <span class="text-red-600">*</span></label>
            <input 
                type="text" 
                name="status" 
                value="{{ old('status', 'Draft') }}"
                class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
                placeholder="Draft, Pending, Active..."
                required
            >
        </div>

        <!-- Lifecycle Stage -->
        <div>
            <label class="block text-gray-700 font-medium">Lifecycle Stage</label>
            <select 
                name="lifecycle_stage"
                class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
            >
                <option value="">-- Choose Stage --</option>
                @foreach(\App\Models\Contract::lifecycleStages() as $stage)
                    <option 
                        value="{{ $stage }}" 
                        {{ old('lifecycle_stage') == $stage ? 'selected' : '' }}
                    >
                        {{ $stage }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-400 mt-1">E.g. Draft, Pending Approval, Active, Renewed, Expired, etc.</p>
        </div>

        <!-- Supplier (Optional) -->
        @if(isset($suppliers) && $suppliers->count() > 0)
            <div>
                <label class="block text-gray-700 font-medium">Supplier</label>
                <select 
                    name="supplier_id"
                    class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
                >
                    <option value="">-- Select Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option 
                            value="{{ $supplier->id }}" 
                            {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}
                        >
                            {{ $supplier->name ?? 'Unknown Supplier' }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <!-- Effective & Expiration Dates -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium">Effective Date</label>
                <input 
                    type="date" 
                    name="effective_date"
                    value="{{ old('effective_date') }}"
                    class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
                >
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Expiration Date</label>
                <input 
                    type="date" 
                    name="expiration_date"
                    value="{{ old('expiration_date') }}"
                    class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
                >
            </div>
        </div>

        <!-- Total Value & Currency -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium">Total Value</label>
                <input 
                    type="number" 
                    step="0.01" 
                    name="total_value" 
                    value="{{ old('total_value') }}"
                    class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
                    placeholder="e.g. 100000.00"
                >
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Currency</label>
                <input 
                    type="text" 
                    name="currency"
                    value="{{ old('currency', 'USD') }}"
                    class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
                >
            </div>
        </div>

        <!-- Auto Renew & Max Renewals -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center mt-2">
                <input 
                    type="checkbox" 
                    name="auto_renew" 
                    id="auto_renew"
                    value="1"
                    {{ old('auto_renew') ? 'checked' : '' }}
                    class="w-5 h-5 text-blue-600 border-gray-300 focus:ring focus:ring-blue-500"
                >
                <label for="auto_renew" class="ml-2 text-gray-700 font-medium">
                    Auto Renew?
                </label>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Max Renewals</label>
                <input 
                    type="number" 
                    name="max_renewals"
                    value="{{ old('max_renewals') }}"
                    class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
                >
            </div>
        </div>

        <!-- Risk Level (Example) -->
        <div>
            <label class="block text-gray-700 font-medium">Risk Level</label>
            <select 
                name="risk_level"
                class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
            >
                <option value="">-- Select Risk --</option>
                <option value="Low" {{ old('risk_level') == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ old('risk_level') == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ old('risk_level') == 'High' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        <!-- Multiple Attachments -->
        <div>
            <label class="block text-gray-700 font-medium">Attachments</label>
            <input 
                type="file" 
                name="attachments[]" 
                multiple
                class="mt-1 block w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-500 focus:outline-none"
            >
            <p class="text-xs text-gray-400 mt-1">You can upload multiple files at once.</p>
        </div>

        <!-- Submit & Cancel Buttons -->
        <div class="flex space-x-4 pt-4">
            <button 
                type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none"
            >
                Create Contract
            </button>
            <a 
                href="{{ route('contracts.index') }}" 
                class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700"
            >
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
