@extends('layouts.dash')

@section('content')
<div class="container py-8 max-w-lg mx-auto">
    <h1 class="text-3xl font-light text-center mb-8">Create Schedule</h1>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Please correct the following:</h3>
                    <ul class="mt-2 text-sm text-red-700 space-y-1 list-disc list-inside">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mr-2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <h2 class="text-lg font-medium">Schedule Details</h2>
            </div>
        </div>

        <form action="{{ route('schedules.store') }}" method="POST" class="px-6 py-5 space-y-5">
            @csrf

            <div>
                <label for="order_id" class="block text-sm font-medium text-gray-700 mb-1">Order</label>
                <select 
                    id="order_id" 
                    name="order_id" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                    required
                >
                    <option value="" disabled selected>Select an order</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}">{{ $order->order_number }}</option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">Select the order this schedule applies to</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="requested_date" class="block text-sm font-medium text-gray-700 mb-1">Requested Date</label>
                    <input 
                        type="date" 
                        id="requested_date"
                        name="requested_date" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                        required
                    >
                </div>

                <div>
                    <label for="promised_date" class="block text-sm font-medium text-gray-700 mb-1">Promised Date</label>
                    <input 
                        type="date" 
                        id="promised_date"
                        name="promised_date" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    >
                    <p class="mt-1 text-xs text-gray-500">Leave blank if not yet determined</p>
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select 
                    id="status"
                    name="status" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                >
                    @foreach(\App\Models\Schedule::allStatuses() as $st)
                        <option value="{{ $st }}">{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                <input 
                    type="number" 
                    id="quantity"
                    name="quantity" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                >
            </div>

            <div>
                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                <textarea 
                    id="remarks"
                    name="remarks" 
                    rows="3" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    placeholder="Any additional notes or comments"
                ></textarea>
            </div>
        
            <div class="pt-5 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ route('schedules.index') }}" class="text-gray-600 hover:text-gray-900">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-md shadow-sm transition">
                    Create Schedule
                </button>
            </div>
        </form>
    </div>
</div>
@endsection