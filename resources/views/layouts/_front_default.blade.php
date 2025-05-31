@extends('layouts.front')

@section('header')
    @include('layouts.front_partials._header')
@endsection

@section('content')
    {{ $slot }}
@endsection

@section('footer')
    @include('layouts.front_partials._footer')
@endsection
