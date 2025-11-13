<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Kelas extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     * (Laravel biasanya mencari 'kelas' (plural), tapi 'kelas' sudah plural)
     * Kita tegaskan saja nama tabelnya 'kelas'
     */
    protected $table = 'kelas';

    /**
     * Kolom yang boleh diisi
     */
    protected $fillable = [
        'kode_kelas',
        'nama_kelas',
    ];

    /**
     * Relasi: Satu Kelas punya BANYAK Siswa
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Relasi: Satu Kelas punya BANYAK Absensi (MELALUI Siswa)
     * Ini akan sangat berguna untuk rekap
     */
    public function attendances(): HasManyThrough
    {
        return $this->hasManyThrough(Attendance::class, Student::class);
    }
}