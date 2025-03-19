@extends('layouts.dash')

@section('content')
<div class="container py-8 max-w-6xl mx-auto">
    <h1 class="text-3xl font-light text-center mb-8">Manage Schedules</h1>
    
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
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

    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('schedules.index') }}" class="space-y-4">
            <div class="flex items-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 mr-2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <h2 class="text-lg font-medium">Search Schedules</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label for="order_number" class="block text-sm font-medium text-gray-700 mb-1">Order Number</label>
                    <input 
                        type="text" 
                        id="order_number"
                        name="order_number" 
                        value="{{ request('order_number') }}" 
                        placeholder="Enter order number" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    >
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select 
                        id="status"
                        name="status" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    >
                        <option value="">All Statuses</option>
                        @foreach(\App\Models\Schedule::allStatuses() as $st)
                            <option 
                                value="{{ $st }}" 
                                {{ request('status') == $st ? 'selected' : '' }}
                            >
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="from_date" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input 
                        type="date" 
                        id="from_date"
                        name="from_date" 
                        value="{{ request('from_date') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    >
                </div>
                <div>
                    <label for="to_date" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input 
                        type="date" 
                        id="to_date"
                        name="to_date" 
                        value="{{ request('to_date') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">&nbsp;</label>
                    <button class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md shadow-sm transition">
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Actions Bar -->
    <div class="flex justify-between items-center mb-6">
        <div class="text-sm text-gray-600">
            {{ $schedules->total() }} schedules found
        </div>
        <div class="space-x-3">
            <a href="{{ route('schedules.bulkUploadForm') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
                Bulk Upload
            </a>
            <a href="{{ route('schedules.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md shadow-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Create Schedule
            </a>
        </div>
    </div>

    @if($schedules->count() === 0)
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <img src="/api/placeholder/120/120" alt="No schedules" class="mx-auto mb-4 opacity-30">
            <p class="text-gray-500 text-lg">No schedules found</p>
            <p class="text-gray-400 text-sm mt-2">Try adjusting your search criteria or create a new schedule</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Requested Date</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Promised Date</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($schedules as $schedule)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $schedule->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @if($schedule->order)
                                    {{ $schedule->order->order_number }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $schedule->requested_date }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $schedule->promised_date ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($schedule->status == 'Completed') bg-green-100 text-green-800
                                    @elseif($schedule->status == 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($schedule->status == 'Cancelled') bg-red-100 text-red-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ $schedule->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $schedule->quantity ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 space-x-2">
                                <a href="{{ route('schedules.show', $schedule->id) }}" class="text-blue-600 hover:text-blue-900">
                                    View
                                </a>
                                <a href="{{ route('schedules.edit', $schedule->id) }}" class="text-amber-600 hover:text-amber-900">
                                    Edit
                                </a>
                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this schedule?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $schedules->links() }}
            </div>
        </div>
    @endif
</div>
@endsection