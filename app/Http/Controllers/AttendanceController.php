<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Setting; // <-- TAMBAHKAN IMPORT SETTING
use Illuminate\Support\Facades\Cache; // <-- TAMBAHKAN IMPORT CACHE

class AttendanceController extends Controller
{
    /**
     * Helper function untuk mengambil semester aktif
     */
    private function getSemesterAktif()
    {
        // Gunakan cache agar tidak query DB terus-menerus
        return Cache::rememberForever('semester_aktif', function () {
            return Setting::where('key', 'semester_aktif')->firstOrCreate(
                ['key' => 'semester_aktif'],
                ['value' => 'Ganjil']
            )->value;
        });
    }

    // Menampilkan daftar absensi
    public function index()
    {
        // ... (tidak ada perubahan di sini)
        $attendances = Attendance::with('student.kelas') 
                                ->orderBy('tanggal_absen', 'desc')
                                ->paginate(10); 
        return view('attendance.index', compact('attendances'));
    }

    // Menampilkan form tambah absensi
    public function create()
    {
        // AMBIL SEMESTER AKTIF
        $semester_aktif = $this->getSemesterAktif();
        
        // KIRIM KE VIEW
        return view('attendance.create', compact('semester_aktif'));
    }

    // Simpan data absensi baru
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|exists:students,nis', 
            'tanggal_absen' => 'required|date',
            // 'semester' TIDAK PERLU VALIDASI DARI REQUEST LAGI
            'keterangan' => 'required|in:Sakit,Ijin,Alpha,Terlambat',
        ]);

        // Cari student_id dari NIS
        $student = Student::where('nis', $request->nis)->first();

        // AMBIL SEMESTER AKTIF DARI DB/CACHE (BUKAN DARI REQUEST)
        $semester_aktif = $this->getSemesterAktif();

        Attendance::create([
            'student_id' => $student->id,
            'tanggal_absen' => $request->tanggal_absen,
            'semester' => $semester_aktif, // <-- GUNAKAN SETTING GLOBAL
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Data absensi berhasil ditambahkan');
    }

    // Tampilkan form edit
    public function edit(Attendance $attendance)
    {
        $attendance->load('student'); 
        
        // AMBIL SEMESTER AKTIF
        $semester_aktif = $this->getSemesterAktif();

        // Kirim data absensi DAN semester aktif ke view
        return view('attendance.edit', compact('attendance', 'semester_aktif'));
    }

    // Update data absensi
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'nis' => 'required|string|exists:students,nis',
            'tanggal_absen' => 'required|date',
            // 'semester' TIDAK PERLU VALIDASI DARI REQUEST LAGI
            'keterangan' => 'required|in:Sakit,Ijin,Alpha,Terlambat',
        ]);

        // Cari student_id dari NIS
        $student = Student::where('nis', $request->nis)->first();
        
        // AMBIL SEMESTER AKTIF DARI DB/CACHE (BUKAN DARI REQUEST)
        $semester_aktif = $this->getSemesterAktif();

        $attendance->update([
            'student_id' => $student->id,
            'tanggal_absen' => $request->tanggal_absen,
            'semester' => $semester_aktif, // <-- GUNAKAN SETTING GLOBAL
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Data absensi berhasil diperbarui');
    }

    // Hapus data absensi
    public function destroy(Attendance $attendance)
    {
        // ... (tidak ada perubahan di sini)
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'Data absensi berhasil dihapus');
    }
}