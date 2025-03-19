@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Channel Program Details</h1>
  <div class="mb-4 space-y-2">
    <p class="text-gray-700"><strong>Program Name:</strong> {{ $channelProgram->program_name }}</p>
    <p class="text-gray-700"><strong>Description:</strong> {{ $channelProgram->description }}</p>
    <p class="text-gray-700"><strong>Status:</strong> {{ $channelProgram->status }}</p>
    <p class="text-gray-700"><strong>Start Date:</strong> {{ $channelProgram->start_date }}</p>
    <p class="text-gray-700"><strong>End Date:</strong> {{ $channelProgram->end_date }}</p>
  </div>
  <div class="flex space-x-4">
    <a href="{{ route('channel_programs.edit', $channelProgram->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Edit</a>
    <a href="{{ route('channel_programs.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Back to List</a>
  </div>
</div>
@endsection
