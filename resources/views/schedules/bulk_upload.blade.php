@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <h1 class="mb-4 text-center" style="font-weight: 300; font-size:2rem;">
        Bulk Upload Schedules
    </h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Errors:</strong>
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-4 rounded shadow-sm">
        <form action="{{ route('schedules.bulkUpload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">CSV File</label>
                <input type="file" name="csv_file" class="form-control" required>
            </div>

            <p class="text-muted" style="font-size: 0.9rem;">
                CSV format: <br>
                <code>order_number,requested_date,promised_date,status,remarks,quantity</code>
            </p>

            <div class="text-end">
                <button class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>
@endsection
