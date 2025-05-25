<x-default-layout title="Tracking Aduan" :breadcrumbs="$breadcrumbs">
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tracking Aduan</h3>
            </div>
            <div class="card-body">
                <form method="POST" id="trackingAduan" action="{{ route('tracking.json_tracking_result') }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomorAduan">Nomor Aduan</label>
                                <input type="text" class="form-control" id="nomorAduan" name="nomor_aduan">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="btnTracking">Tracking</button>
                            </div>
                        </div>
                    </div>
                </form>


                <div id="result_tracking"></div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                const formTracking = $("#trackingAduan");

                formTracking.on("submit", function(e) {
                    e.preventDefault();

                    const button = $("#btnTracking");
                    const result = $("#result_tracking");
                    result.html('Loading...');


                    button.attr("disabled", true);
                    button.html(
                        "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Loading..."
                    );

                    $.ajax({
                        method: "POST",
                        url: formTracking.attr("action"),
                        data: {
                            _token: "{{ csrf_token() }}",
                            nomor_aduan: $("input[name=nomor_aduan]").val(),
                        },
                        success: function(res) {
                            result.html(res.html);
                        },
                        error: function(err) {
                            result.html('');
                            if (err.responseJSON.message) {
                                swal("Gagal", err.responseJSON.message, "error");
                                return;
                            }
                            swal("Gagal", "Terjadi kesalahan", "error");
                        },
                        complete: function() {
                            button.attr("disabled", false);
                            button.html("Tracking");
                        },
                    });
                })
            })
        </script>
    @endpush
</x-default-layout>
