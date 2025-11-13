<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Student;

class RecapController extends Controller
{
    /**
     * Menampilkan halaman rekap absensi dengan filter
     * dan hasil data rekapitulasi.
     */
    public function index(Request $request)
    {
        // 1. Ambil semua kelas untuk dropdown filter
        $daftar_kelas = Kelas::orderBy('nama_kelas')->get();

        // 2. Ambil data filter dari request
        $selected_kelas_id = $request->input('kelas_id');
        $selected_semester = $request->input('semester');

        // 3. Query dasar untuk siswa
        // Kita hanya akan mengambil siswa jika kelas sudah dipilih
        $studentsQuery = Student::query();

        // 4. Proses filtering data
        if ($selected_kelas_id) {
            $studentsQuery->where('kelas_id', $selected_kelas_id);
        }

        // 5. Logika inti:
        // Jika kelas DAN semester sudah dipilih,
        // kita ambil data siswa-nya DAN hitung (count) absensinya.
        if ($selected_kelas_id && $selected_semester) {
            
            // 'withCount' adalah magic-nya.
            // Kita membuat kolom virtual (total_sakit, total_ijin, dll)
            // yang berisi hasil perhitungan absensi berdasarkan kriteria.
            $students = $studentsQuery->withCount([
                'attendances as total_sakit' => function ($query) use ($selected_semester) {
                    $query->where('keterangan', 'Sakit')
                          ->where('semester', $selected_semester);
                },
                'attendances as total_ijin' => function ($query) use ($selected_semester) {
                    $query->where('keterangan', 'Ijin')
                          ->where('semester', $selected_semester);
                },
                'attendances as total_alpha' => function ($query) use ($selected_semester) {
                    $query->where('keterangan', 'Alpha')
                          ->where('semester', $selected_semester);
                },
                'attendances as total_terlambat' => function ($query) use ($selected_semester) {
                    $query->where('keterangan', 'Terlambat')
                          ->where('semester', $selected_semester);
                },
            ])
            ->with('kelas') // Ambil juga data relasi kelas-nya
            ->orderBy('name')
            ->get();

        } else {
            // Jika filter belum lengkap, jangan tampilkan data siswa dulu
            $students = collect(); // Kirim koleksi kosong
        }

        // 6. Kirim semua data yang diperlukan ke view
        return view('recap.index', [
            'daftar_kelas' => $daftar_kelas,
            'students' => $students,
            'selected_kelas_id' => $selected_kelas_id,
            'selected_semester' => $selected_semester,
        ]);
    }
}