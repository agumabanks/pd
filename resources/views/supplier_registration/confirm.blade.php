@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 800px;">
    <h1 class="text-center mb-4">Review & Confirm</h1>
    
    <div class="bg-white p-4 rounded shadow">
        <h4>1. Company Details</h4>
        <p>Company Name: <strong>{{ $step1['company_name'] ?? '' }}</strong></p>
        <p>Country of Taxation: <strong>{{ $step1['country_of_taxation'] ?? '' }}</strong></p>
        <p>Country of Origin: <strong>{{ $step1['country_of_origin'] ?? '' }}</strong></p>
        <p>Taxpayer ID: <strong>{{ $step1['taxpayer_id'] ?? '' }}</strong></p>
        <p>Supplier Type: <strong>{{ $step1['supplier_type'] ?? '' }}</strong></p>
        <hr>

        <h4>2. Contact Details</h4>
        <p>Name: <strong>{{ $step2['first_name'] ?? '' }} {{ $step2['last_name'] ?? '' }}</strong></p>
        <p>Email: <strong>{{ $step2['email'] ?? '' }}</strong></p>
        <p>Is Admin Contact: <strong>{{ !empty($step2['is_administrative_contact']) ? 'Yes' : 'No' }}</strong></p>
        <hr>

        <h4>3. Address(es)</h4>
        @if(!empty($step3['addresses']))
            @foreach($step3['addresses'] as $address)
                <p><strong>{{ $address['address_name'] }}</strong></p>
                <p>Country: {{ $address['country'] }}, City: {{ $address['city'] }}</p>
                <p>{{ $address['line1'] }}</p>
                <hr>
            @endforeach
        @endif
        <!-- etc. for Steps 4,5,6,7... -->

        <form action="{{ route('supplier.complete') }}" method="POST">
            @csrf
            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg mt-3">Complete Registration</button>
            </div>
        </form>
    </div>
</div>
@endsection
