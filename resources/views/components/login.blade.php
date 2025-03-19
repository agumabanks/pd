@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Company Form</h1>
        <form method="POST" action="/company-form">
            @csrf
            <div>
                <label for="name">Company Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
@endsection