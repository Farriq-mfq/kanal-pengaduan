<x-front-layout title="Selamat Datang">
    <section class="section">
        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-out">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>
                        Halaman Ubah Password
                    </h1>
                </div>
            </div>
            <div class="row mt-4">
                @session('success')
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endsession
                <form action="{{ route('front.auth.forgot_password.store') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="" class="form-label">
                            Email
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') ?? '' }}" name="email">
                        @error('email')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-pr">
                        Kirim Link Reset Password
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-front-layout>
