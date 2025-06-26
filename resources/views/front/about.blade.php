<x-front-layout title="Selamat Datang">
    <section class="section">
        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-out">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>
                        {{ config('app.name') }}
                    </h1>
                    <p>{{ config('app.name') }} Adalah Portal Laporan Pengaduan Online Masyarakat Dinas Kependudukan dan
                        Pencatatan Sipil Kota
                        Pekalongan</p>
                </div>
            </div>
            {{-- <div class="row gy-4 mt-5">
                <div class="col-md-6 col-lg-3" data-aos="zoom-out" data-aos-delay="100">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-easel"></i></div>
                        <h4 class="title"><a href="">Buat Pengaduan</a></h4>
                        <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias
                            excepturi</p>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
    <section id="faq" class="faq section light-background">

        <div class="container section-title" data-aos="fade-up">
            <h2>Pertanyaan Yang Sering Ditanyakan</h2>
        </div>

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

                    <div class="faq-container">

                        <div class="faq-item faq-active">
                            <h3>Bagaimana cara saya melaporkan aduan ?</h3>
                            <div class="faq-content">
                                <p>Anda hanya mengisi form laporan aduan yang tersedia dihalaman beranda depan.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Apakah Identitas Saya Aman Jika Mengadukan Hal Yang Sensitif ?</h3>
                            <div class="faq-content">
                                <p>Identias anda aman karena kami menggunakan login ketika melakukan pengaduan.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3>Bagaimana Saya Melihat Progress Perkembangan Aduan Saya ?</h3>
                            <div class="faq-content">
                                <p>
                                    Anda dapat melihat progress perkembangan aduan anda di halaman laporan aduan dan
                                    melakukan tracking aduan berdasarkan dari nomer aduan
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                    </div>

                </div><!-- End Faq Column-->

            </div>

        </div>

    </section><!-- /Faq Section -->
</x-front-layout>
