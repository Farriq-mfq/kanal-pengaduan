<x-front-layout title="Selamat Datang">
    <section class="section">
        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-out">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>
                        Halaman Profil
                    </h1>
                </div>
            </div>
            <div class="row mt-4">
                @session('success')
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endsession
                <form action="{{ route('front.auth.update_profile') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="" class="form-label">
                            Nama
                        </label>
                        <input type="text" name="name" class="form-control"
                            value="{{ auth('masyarakat')->user()->name ?? '-' }}">
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">
                            Email
                        </label>
                        <input type="email" name="email" class="form-control"
                            value="{{ auth('masyarakat')->user()->email ?? '-' }}">
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">
                            NIK
                        </label>
                        <input type="nik" name="nik" class="form-control"
                            value="{{ auth('masyarakat')->user()->NIK ?? '-' }}">
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">
                            Alamat
                        </label>
                        <input type="alamat" name="alamat" class="form-control"
                            value="{{ auth('masyarakat')->user()->alamat ?? '-' }}">
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">
                            Nomer HP
                        </label>
                        <input type="phone" name="phone" class="form-control"
                            value="{{ auth('masyarakat')->user()->phone ?? '-' }}">
                    </div>
                    <button type="submit" class="btn btn-pr">
                        Update
                    </button>
                    <a href="{{ route('front.auth.forgot_password') }}" class="btn btn-pr">
                        Lupa Password
                    </a>
                </form>
            </div>
        </div>
    </section>
</x-front-layout>
