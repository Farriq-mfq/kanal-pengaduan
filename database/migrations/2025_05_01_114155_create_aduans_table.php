<?php

use App\Models\Kategori;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aduans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("kategori_id");
            $table->foreign("kategori_id")->references("id")->on("kategoris")->cascadeOnDelete();
            $table->text("uraian_pengaduan"); // ringkasan atau uraian pengaduan
            $table->string("nomer_aduan")->unique();
            $table->text("text_direct_pengaduan")->nullable(); // jika jawab langsung maka true dan langsung di kerim ke email
            // document pendukuung menggunakan laravel media library
            $table->date("tanggal_pengaduan");
            $table->enum("status_aduan", ["proses", "selesai", "ditolak", "menunggu"])->default("menunggu");
            $table->string("alasan_penolakan")->nullable();
            $table->text("tindak_lanjut")->nullable();
            // kecepatan tindak lanjut
            $table->enum('kecepatan_tindak_lanjut', ['Biasa', 'Segera', 'Amat Segera'])->nullable();
            // klasifikasi aduan
            $table->string("klasifikasi")->nullable();
            // kepala bidang
            $table->unsignedBigInteger("kepala_bidang_id")->nullable();
            $table->foreign("kepala_bidang_id")->references("id")->on("users");
            $table->date('tanggal_tindak_lanjut_kepala_bidang')->nullable(); // hapus
            $table->boolean("verifikasi_kepala_bidang")->default(0);
            $table->string('uraian_tindak_lanjut_kepala_bidang')->nullable(); // hapus
            $table->enum("status_tindak_lanjut_kepala_bidang", ["menunggu", "revisi", "acc"])->default("menunggu");
            // hasil telaah
            $table->text("telaah_aduan")->nullable();
            // kepala dinas
            $table->unsignedBigInteger("kepala_dinas_id")->nullable();
            $table->foreign("kepala_dinas_id")->references("id")->on("users");
            $table->date('tanggal_tindak_lanjut_kepala_dinas')->nullable();
            $table->boolean("verifikasi_kepala_dinas")->default(0);

            // masyarakat
            $table->unsignedBigInteger("masyarakat_id")->nullable();
            $table->foreign("masyarakat_id")->references("id")->on("masyarakats");


            // status mediasi
            /**
             * Jika mediasi dilakukan maka status menjadi true
             */
            $table->boolean("status_mediasi")->default(0);
            $table->date("tanggal_mediasi")->nullable();
            $table->text("uraian_mediasi")->nullable();

            // disampaikan
            $table->boolean("status_disampaikan")->default(0);
            $table->date("tanggal_disampaikan")->nullable();
            $table->text("tanggapan")->nullable();

            // status penyelesaian
            // $table->string("status_penyelesaian")->nullable(); // selesai,tidak dapat di selesaikan
            // jika sudah dilihat oleh masyarakat maka true
            // $table->boolean('is_view')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduans');
    }
};
