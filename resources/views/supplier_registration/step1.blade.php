@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <h1 class="text-center mb-4">Step 1: Company Details</h1>
    <form action="{{ route('supplier.postStep1') }}" method="POST" class="bg-white p-4 rounded shadow">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Company Name <span class="text-danger">*</span></label>
            <input type="text" name="company_name" value="{{ old('company_name') }}" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Country of Taxation <span class="text-danger">*</span></label>
            <input type="text" name="country_of_taxation" value="{{ old('country_of_taxation') }}" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Country of Origin <span class="text-danger">*</span></label>
            <input type="text" name="country_of_origin" value="{{ old('country_of_origin') }}" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Taxpayer ID</label>
            <input type="text" name="taxpayer_id" value="{{ old('taxpayer_id') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Supplier Type <span class="text-danger">*</span></label>
            <select name="supplier_type" class="form-select" required>
                <option value="" disabled selected>Select Type</option>
                <option value="Company">Company</option>
                <option value="Individual">Individual</option>
            </select>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Next &raquo;</button>
        </div>
    </form>
</div>
@endsection
