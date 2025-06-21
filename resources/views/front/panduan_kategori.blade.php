<x-front-layout title="Selamat Datang">
    <section class="section">
        <div class="container">
            <div class="row justify-content-center" data-aos="zoom-out">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h1>
                        Panduan Kategori Pengaduan
                    </h1>
                    <p>Informasi Mengenai Kategori Pengaduan</p>
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
            <h2>Kategori Pengaduan</h2>
            <p style="padding:0 100px;">Dinas Kependudukan dan Pencatatan Sipil Kota Pekalongan menyediakan berbagai
                layanan yang dikelompokkan ke dalam beberapa bidang utama. Setiap bidang memiliki jenis layanan yang
                bertujuan untuk mempermudah masyarakat dalam pengurusan dokumen administrasi kependudukan. Adapun
                bidang-bidang tersebut dijelaskan sebagai berikut</p>
        </div>

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

                    <div class="faq-container">

                        @foreach ($kategori as $kt)
                            <div class="faq-item faq-active">
                                <h3>
                                    {{ $loop->iteration }}. {{ $kt->name }}
                                </h3>
                                {!! $kt->panduan !!}
                            </div><!-- End Faq item-->
                        @endforeach
                    </div>

                </div><!-- End Faq Column-->

            </div>

        </div>

    </section><!-- /Faq Section -->
</x-front-layout>
