@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
  <h1 class="text-2xl font-light mb-4">Acknowledge Schedules via Spreadsheet</h1>
  <p class="text-gray-700 mb-4">Upload a spreadsheet to acknowledge schedules.</p>
  <form action="#" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
      <label for="spreadsheet" class="block text-gray-700">Upload Spreadsheet</label>
      <input type="file" name="spreadsheet" id="spreadsheet" class="mt-1 block w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Upload</button>
  </form>
</div>
@endsection
