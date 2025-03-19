@extends('layouts.dash')

@section('content')
<div class="container py-8">
    <h1 class="text-3xl font-light text-center mb-8">Order Lifecycle</h1>
    
    @if($orders->count() === 0)
        <div class="bg-white rounded-lg shadow-sm p-10 text-center">
            <img src="/api/placeholder/120/120" alt="No orders" class="mx-auto mb-4 opacity-30">
            <p class="text-gray-500 text-lg">No orders found</p>
            <a href="{{ route('shop') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-700">Start shopping</a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                @php 
                    $allStatuses = App\Models\Order::allStatuses();
                    $current = array_search($order->status, $allStatuses);
                @endphp
                
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <!-- Order Header -->
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-medium">Order #{{ $order->order_number }}</h2>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('F j, Y') }}</p>
                        </div>
                        <div class="text-right">
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
                    
                    <!-- Progress Tracker -->
                    <div class="px-6 py-5">
                        <div class="relative">
                            <!-- Progress Bar -->
                            <div class="h-1 bg-gray-200 rounded overflow-hidden">
                                <div class="h-full bg-blue-500 rounded" style="width: {{ ($current / (count($allStatuses) - 1)) * 100 }}%"></div>
                            </div>
                            
                            <!-- Status Points -->
                            <div class="flex justify-between mt-2">
                                @foreach($allStatuses as $index => $status)
                                    <div class="flex flex-col items-center" style="width: {{ 100/count($allStatuses) }}%">
                                        <!-- Status Dot -->
                                        <div class="
                                            w-4 h-4 rounded-full border-2 transform -translate-y-3
                                            {{ $index < $current ? 'bg-blue-500 border-blue-500' : 
                                              ($index == $current ? 'bg-blue-500 border-blue-500' : 
                                              'bg-white border-gray-300') }}">
                                        </div>
                                        
                                        <!-- Status Label -->
                                        <span class="text-xs font-medium text-center {{ $index <= $current ? 'text-blue-600' : 'text-gray-500' }}">
                                            {{ $status }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Actions -->
                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 text-right">
                        <a href="{{ route('orders.show', $order) }}" class="text-sm text-blue-500 hover:text-blue-700">
                            View details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection