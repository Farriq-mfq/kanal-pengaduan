@extends('layouts.master')
@section('content')
    <div class="wrapper">
        @include('layouts.partials._sidebar')
        <div class="main-panel">
            @include('layouts.partials._header')

            <div class="container">
                <div class="page-inner">
                    @includeWhen(isset($breadcrumbs) && count($breadcrumbs) > 0,
                        'layouts.partials._breadcrumbs',
                        [
                            'breadcrumbs' => $breadcrumbs,
                        ]
                    )
                    <div class="page-category">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title', $title)

@push('scripts')
    <!-- Kaiadmin JS -->
    <script src="{{ url('assets/js/kaiadmin.min.js') }}"></script>
@endpush
