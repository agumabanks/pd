@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Notification Details</h1>

    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-700">
            {{ $notification->data['message'] ?? 'No message provided' }}
        </p>
        <div class="text-sm text-gray-400 mt-2">
            Received {{ $notification->created_at->diffForHumans() }}
        </div>
    </div>
</div>
@endsection
