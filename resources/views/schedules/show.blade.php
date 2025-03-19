@extends('layouts.dash')

@section('content')
<div class="container max-w-2xl mx-auto py-10">
    <!-- Schedule Header -->
    <div class="flex items-center justify-center mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mr-3">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
        </svg>
        <h1 class="text-2xl font-light text-gray-800">Schedule Details</h1>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded">
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

    <!-- Schedule Details Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Status Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <span class="text-lg font-medium text-gray-800">Order #{{ optional($schedule->order)->order_number ?? 'N/A' }}</span>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                @if($schedule->status === 'Completed') bg-green-100 text-green-800
                @elseif($schedule->status === 'Acknowledged') bg-blue-100 text-blue-800
                @elseif($schedule->status === 'Pending') bg-yellow-100 text-yellow-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ $schedule->status }}
            </span>
        </div>

        <!-- Schedule Details -->
        <div class="px-6 py-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Schedule ID</p>
                        <p class="font-medium text-gray-800">{{ $schedule->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Requested Date</p>
                        <p class="font-medium text-gray-800">{{ $schedule->requested_date }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Promised Date</p>
                        <p class="font-medium text-gray-800">{{ $schedule->promised_date ?? 'Not specified' }}</p>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Quantity</p>
                        <p class="font-medium text-gray-800">{{ $schedule->quantity ?? 'Not specified' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Remarks</p>
                        <p class="font-medium text-gray-800">{{ $schedule->remarks ?? 'None' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
            <a href="{{ route('schedules.index') }}" class="flex items-center text-gray-600 hover:text-gray-900 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                Back to Schedules
            </a>
            
            @if($schedule->status === 'Pending')
            <form action="{{ route('schedules.acknowledge', $schedule->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-md shadow-sm transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Acknowledge Schedule
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection