@extends('layouts.dash')

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <h1 class="mb-4 text-center" style="font-weight: 300; font-size:2rem;">
        Edit Schedule
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

    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Order</label>
            <select name="order_id" class="form-select" required>
                @foreach($orders as $order)
                    <option 
                        value="{{ $order->id }}" 
                        {{ $order->id === $schedule->order_id ? 'selected' : '' }}
                    >
                        {{ $order->order_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Requested Date</label>
            <input 
                type="date" 
                name="requested_date" 
                class="form-control" 
                value="{{ $schedule->requested_date }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Promised Date</label>
            <input 
                type="date" 
                name="promised_date" 
                class="form-control" 
                value="{{ $schedule->promised_date }}"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                @foreach(\App\Models\Schedule::allStatuses() as $st)
                    <option 
                        value="{{ $st }}" 
                        {{ $schedule->status === $st ? 'selected' : '' }}
                    >
                        {{ $st }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Remarks</label>
            <input 
                type="text" 
                name="remarks" 
                class="form-control" 
                value="{{ $schedule->remarks }}"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input 
                type="number" 
                name="quantity" 
                class="form-control"
                value="{{ $schedule->quantity }}"
            >
        </div>

        <div class="text-end">
            <button class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection
