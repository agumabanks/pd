@extends('layouts.dash')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Notifications</h1>

    <!-- Button to mark all notifications as read -->
    <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="mb-4">
        @csrf
        <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded">
            Mark All As Read
        </button>
    </form>

    @if($notifications->count() === 0)
        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-700">You have no notifications.</p>
        </div>
    @else
        <div class="bg-white rounded shadow">
            @foreach($notifications as $notification)
                <div class="p-4 border-b last:border-b-0 border-gray-200">
                    <!-- Highlight unread notifications -->
                    <a 
                      href="{{ route('notifications.show', $notification->id) }}" 
                      class="{{ is_null($notification->read_at) ? 'font-semibold text-gray-800' : 'text-gray-500' }}"
                    >
                        <!-- Assuming you store a 'message' in the notification's data -->
                        {{ $notification->data['message'] ?? 'New Notification' }}
                    </a>
                    <div class="text-xs text-gray-400">
                        {{ $notification->created_at->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination (optional if you used paginate() in the controller) -->
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
