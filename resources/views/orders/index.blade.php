@extends('layouts.dash')

@section('content')
<div class="mb-8">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-light">Orders</h1>
    <div>
      <a href="{{ route('orders.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create New Order</a>
      <a href="{{ route('orders.export') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Export CSV</a>
    </div>
  </div>

  <!-- Advanced Search Form -->
  <form method="GET" action="{{ route('orders.index') }}" class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <input type="text" name="search" placeholder="Search by order number or status" value="{{ request('search') }}"
             class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
      <input type="date" name="from_date" placeholder="From Date" value="{{ request('from_date') }}"
             class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
      <input type="date" name="to_date" placeholder="To Date" value="{{ request('to_date') }}"
             class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Search</button>
    </div>
  </form>

  <!-- Orders Table -->
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white">
      <thead class="bg-gray-100">
        <tr>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">ID</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Order Number</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Status</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Requested Delivery Date</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Acknowledge Due Date</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b text-sm">{{ $order->id }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $order->order_number }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $order->status }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $order->requested_delivery_date }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $order->acknowledge_due_date }}</td>
          <td class="py-2 px-4 border-b text-sm">
            <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:underline">View</a>
            <a href="{{ route('orders.edit', $order->id) }}" class="ml-2 text-yellow-600 hover:underline">Edit</a>
            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline-block ml-2">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
            </form>
            @if($order->status == 'Pending Supplier Acknowledgment')
            <form action="{{ route('orders.acknowledge', $order->id) }}" method="POST" class="inline-block ml-2">
              @csrf
              <button type="submit" class="text-green-600 hover:underline">Acknowledge</button>
            </form>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Pagination Links -->
  <div class="mt-6">
    {{ $orders->links() }}
  </div>
</div>
@endsection
