<x-front-layout title="Selamat Datang">
    <section class="hero section">
        <img src="{{ asset('front/assets/img/hero-bg-abstract.jpg') }}" alt="" data-aos="fade-in" class="">

        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-out">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>
                        {{ config('app.name') }}
                    </h1>
                    <p>Portal Laporan Pengaduan Online Masyarakat Dinas Kependudukan dan Pencatatan Sipil Kota
                        Pekalongan</p>
                </div>
            </div>
            <div class="row mt-4 justify-content-center" data-aos="zoom-out">
                <x-tracking-input></x-tracking-input>
            </div>
            <div class="row mt-4 justify-content-center" data-aos="zoom-out">
                <x-create-aduan></x-create-aduan>
            </div>
        </div>
    </section>
</x-front-layout>
