<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute; // Penting untuk casting tanggal

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'tanggal_absen',
        'keterangan',
        'semester', // <-- DITAMBAHKAN
    ];

    /**
     * Perlakukan 'tanggal_absen' sebagai objek Tanggal (Carbon)
     */
    protected function casts(): array
    {
        return [
            'tanggal_absen' => 'date',
        ];
    }

    /**
     * Relasi: Satu Absensi milik SATU Siswa
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}