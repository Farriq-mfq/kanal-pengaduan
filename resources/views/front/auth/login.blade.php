<x-front-layout title="Masuk">
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

                            @session('error')
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endsession
                            <form action="{{ route('front.login.store') }}" method="POST">
                                @csrf
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
                                <div class="mb-3 d-grid">
                                    <button type="submit" class="btn btn-pr py-3">
                                        Masuk
                                    </button>
                                </div>
                                <p class="text-center">
                                    Belum punya akun ?
                                    <a href="{{ route('front.register') }}">Daftar disini</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-front-layout>
