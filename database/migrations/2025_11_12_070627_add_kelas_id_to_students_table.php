<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // 1. Hapus kolom 'kelas' yang lama (jika ada dan tipe-nya string)
            if (Schema::hasColumn('students', 'kelas')) {
                $table->dropColumn('kelas');
            }
            
            // 2. Tambahkan kolom 'kelas_id' yang baru
            // Ini akan terhubung ke tabel 'kelas'
            $table->foreignId('kelas_id')
                  ->nullable() // Boleh kosong jika siswa belum punya kelas
                  ->after('name') // Posisikan setelah kolom 'name'
                  ->constrained('kelas') // Terhubung ke tabel 'kelas'
                  ->onDelete('set null'); // Jika kelas dihapus, set 'kelas_id' siswa jadi NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
            // Kembalikan kolom 'kelas' lama jika di-rollback
            $table->string('kelas')->nullable()->after('name'); 
        });
    }
};