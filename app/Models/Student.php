<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Pastikan nama class-nya adalah Student
class Student extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi
     * Pastikan 'kelas_id' ada di sini (menggantikan 'kelas')
     */
    protected $fillable = [
        'nis',
        'name',
        'kelas_id', // Ini yang benar, bukan 'kelas'
        'email',
        'phone',
    ];

    /**
     * Relasi: Satu Siswa milik SATU Kelas
     * (Nama fungsi: kelas)
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Relasi: Satu Siswa punya BANYAK Absensi
     * (Nama fungsi: attendances)
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}