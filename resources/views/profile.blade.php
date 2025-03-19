@extends('layouts.dash')
@section('content')


    <h1>{{ ucfirst(request()->segment(1)) }} Page</h1>
@endsection