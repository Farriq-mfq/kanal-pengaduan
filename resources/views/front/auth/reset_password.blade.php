<x-front-layout title="Selamat Datang">
    <section class="section">
        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-out">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>
                        Silahkan reset password anda
                    </h1>
                </div>
            </div>
            <div class="row mt-4">
                <form action="{{ route('front.auth.reset_password.store', base64_encode($token)) }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="" class="form-label">
                            Password Baru
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            value="{{ old('password') ?? '' }}" name="password">
                        @error('password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">
                            Konfirmasi Password
                        </label>
                        <input type="password"
                            class="form-control @error('konfirmation_password') is-invalid @enderror"
                            value="{{ old('konfirmation_password') ?? '' }}" name="konfirmation_password">
                        @error('konfirmation_password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-pr">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-front-layout>
