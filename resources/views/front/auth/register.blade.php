<x-front-layout title="Selamat Datang">
    <section>
        <div class="container">
            {{-- login card --}}
            <div class="row mt-4 justify-content-center" data-aos="zoom-out">
                <div class="col-md-5">
                    <div class="card shadow-lg p-4 rounded">
                        <div class="card-body">
                            <h3 class="card-title text-center mb-4">
                                {{ config('app.name') }}
                            </h3>

                            @session('success')
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endsession
                            @session('error')
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endsession

                            <form action="{{ route('front.register.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nik">NIK <span class="text-danger"
                                            style="font-size: 12px">Wajib</span></label>
                                    <input type="text" name="nik" id="nik"
                                        class="form-control @error('nik') is-invalid @enderror"
                                        value="{{ old('nik') ?? '' }}">
                                    @error('nik')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="name">Nama <span class="text-danger"
                                            style="font-size: 12px">Wajib</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') ?? '' }}">
                                    @error('name')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email">Email <span class="text-danger"
                                            style="font-size: 12px">Wajib</span></label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') ?? '' }}">
                                    @error('email')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password">Password <span class="text-danger"
                                            style="font-size: 12px">Wajib</span></label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        value="{{ old('password') ?? '' }}">
                                    @error('password')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation">Konfirmasi Password <span class="text-danger"
                                            style="font-size: 12px">Wajib</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        value="{{ old('password_confirmation') ?? '' }}">
                                    @error('password_confirmation')
                                        <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3 d-grid">
                                    <button type="submit" class="btn btn-pr py-3">
                                        Daftar
                                    </button>
                                </div>
                                <p class="text-center">
                                    Sudah punya akun ?
                                    <a href="{{ route('front.login') }}">Masuk disini</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-front-layout>
