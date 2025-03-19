@extends('layouts.dash')

@section('content')
<div class="mb-8">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-light">Channel Programs</h1>
    <div>
      <a href="{{ route('channel_programs.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create New Program</a>
    </div>
  </div>

  <!-- Search Form -->
  <form method="GET" action="{{ route('channel_programs.index') }}" class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <input type="text" name="search" placeholder="Search by program name or status" value="{{ request('search') }}"
             class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Search</button>
    </div>
  </form>

  <!-- Programs Table -->
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white">
      <thead class="bg-gray-100">
        <tr>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">ID</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Program Name</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Status</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Start Date</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">End Date</th>
          <th class="py-2 px-4 border-b text-left text-sm font-medium text-gray-700">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($channelPrograms as $program)
        <tr class="hover:bg-gray-50">
          <td class="py-2 px-4 border-b text-sm">{{ $program->id }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $program->program_name }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $program->status }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $program->start_date }}</td>
          <td class="py-2 px-4 border-b text-sm">{{ $program->end_date }}</td>
          <td class="py-2 px-4 border-b text-sm">
            <a href="{{ route('channel_programs.show', $program->id) }}" class="text-blue-600 hover:underline">View</a>
            <a href="{{ route('channel_programs.edit', $program->id) }}" class="ml-2 text-yellow-600 hover:underline">Edit</a>
            <form action="{{ route('channel_programs.destroy', $program->id) }}" method="POST" class="inline-block ml-2">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this program?')">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $channelPrograms->links() }}
  </div>
</div>
@endsection
