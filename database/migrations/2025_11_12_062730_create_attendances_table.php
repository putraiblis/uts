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
            Schema::create('attendances', function (Blueprint $table) {
                $table->id();
                
                // Ini adalah 'foreign key' yang terhubung ke tabel 'students'
                $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
                
                $table->date('tanggal_absen');
                $table->enum('keterangan', ['Sakit', 'Ijin', 'Alpha', 'Terlambat']);
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('attendances');
        }
    };