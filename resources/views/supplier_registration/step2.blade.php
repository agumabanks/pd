@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <h1 class="text-center mb-4">Step 2: Contact Details</h1>
    <form action="{{ route('supplier.postStep2') }}" method="POST" class="bg-white p-4 rounded shadow">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">First Name <span class="text-danger">*</span></label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Last Name <span class="text-danger">*</span></label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_administrative_contact" class="form-check-input" id="adminContact">
            <label for="adminContact" class="form-check-label">Is Administrative Contact?</label>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Next &raquo;</button>
        </div>
    </form>
</div>
@endsection
