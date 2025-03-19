@extends('layouts.dash')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow p-6 rounded">
    <h1 class="text-2xl font-light mb-4">Upload ASN or ASBN</h1>
    <p class="text-gray-700">Upload your ASN/ASBN document here. Implement as needed.</p>
    <!-- Example file upload form (not fully implemented) -->
    <form action="#" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Select File</label>
            <input type="file" name="asn_asbn_file" class="border border-gray-300 rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-600 w-full">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Upload</button>
    </form>
</div>
@endsection
