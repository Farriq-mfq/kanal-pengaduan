@extends('layouts.master')
@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-12 col-lg-5 px-3">
            {{ $slot }}
        </div>
    </div>
@endsection

@section('title', $title)
