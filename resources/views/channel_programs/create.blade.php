@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Create New Channel Program</h1>

  @if ($errors->any())
  <div class="mb-4">
    <ul class="list-disc list-inside text-red-600">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('channel_programs.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
      <label for="program_name" class="block text-gray-700">Program Name</label>
      <input type="text" name="program_name" id="program_name" value="{{ old('program_name') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <div>
      <label for="description" class="block text-gray-700">Description</label>
      <textarea name="description" id="description" rows="4"
                class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">{{ old('description') }}</textarea>
    </div>
    <div>
      <label for="status" class="block text-gray-700">Status</label>
      <input type="text" name="status" id="status" value="{{ old('status') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600" required>
    </div>
    <div>
      <label for="start_date" class="block text-gray-700">Start Date</label>
      <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div>
      <label for="end_date" class="block text-gray-700">End Date</label>
      <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
             class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <div class="flex space-x-4">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create Program</button>
      <a href="{{ route('channel_programs.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</a>
    </div>
  </form>
</div>
@endsection
