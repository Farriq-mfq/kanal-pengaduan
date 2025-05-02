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

    <script>
        $(document).on('click', '#delete-form', function(e) {
            e.preventDefault();
            const title = $(this).data('title');
            const text = $(this).data('text');

            swal({
                title: title || "Yakin ?",
                text: text || "Anda akan menghapus data ini ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $('#delete-form').submit();
                }
            })

            return false;
        })
    </script>
@endpush
