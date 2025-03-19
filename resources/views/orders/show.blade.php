@extends('layouts.dash')

@section('content')
<div class="container max-w-3xl py-8">
    <!-- Back & Lifecycle Navigation -->
    <div class="flex justify-between items-center mb-6">
        <a href="{{ url()->previous() }}" class="flex items-center text-gray-600 hover:text-gray-900 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
            Back
        </a>
        <a href="{{ route('orders.lifecycle', $order) }}" class="text-blue-500 hover:text-blue-700 transition">
            View Lifecycle
        </a>
    </div>

    <!-- Order Header -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-5 border-b border-gray-100">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-light">Order #{{ $order->order_number }}</h1>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    @if(in_array($order->status, ['Delivered', 'Completed'])) bg-green-100 text-green-800
                    @elseif(in_array($order->status, ['Processing', 'Shipped'])) bg-blue-100 text-blue-800
                    @elseif($order->status === 'Cancelled') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ $order->status }}
                </span>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4 mx-6 mt-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Order Details -->
        <div class="px-6 py-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-sm uppercase tracking-wide text-gray-500 mb-2">Order Information</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Date Placed</p>
                            <p class="font-medium">{{ $order->created_at->format('F j, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Requested Delivery Date</p>
                            <p class="font-medium">{{ $order->requested_delivery_date ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Acknowledge Due Date</p>
                            <p class="font-medium">{{ $order->acknowledge_due_date ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-sm uppercase tracking-wide text-gray-500 mb-2">Status Timeline</h2>
                    <div class="space-y-3">
                        @php 
                            $allStatuses = App\Models\Order::allStatuses();
                            $current = array_search($order->status, $allStatuses);
                        @endphp
                        
                        @foreach($allStatuses as $index => $status)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-5 w-5 relative mt-1">
                                <div class="absolute h-full w-0.5 bg-gray-200 left-1/2 transform -translate-x-1/2"></div>
                                <div class="{{ $index <= $current ? 'bg-blue-500' : 'bg-gray-200' }} h-5 w-5 rounded-full flex items-center justify-center">
                                    @if($index < $current)
                                    <svg class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="{{ $index <= $current ? 'font-medium' : 'text-gray-500' }}">{{ $status }}</p>
                                @if($index == $current)
                                <p class="text-xs text-gray-500">Current status</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between">
        <div></div>
        <form action="" method="POST">
            @csrf
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md shadow-sm transition">
                Move to Next Status
            </button>
        </form>
    </div>
</div>
@endsection