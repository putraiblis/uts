<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Kelas; // 1. IMPORT MODEL KELAS
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Untuk validasi unique

class StudentController extends Controller
{
    /**
     * Menampilkan daftar siswa
     */
    public function index()
    {
        // 2. Gunakan 'with('kelas')' untuk mengambil relasi (Eager Loading)
        // Ini lebih efisien dan memperbaiki error N+1 query
        $students = Student::with('kelas')->orderBy('name')->get();
        
        return view('students.index', compact('students'));
    }

    /**
     * Menampilkan form tambah siswa
     */
    public function create()
    {
        // 3. Ambil semua data kelas untuk ditampilkan di dropdown
        $daftar_kelas = Kelas::orderBy('nama_kelas')->get();
        
        return view('students.create', compact('daftar_kelas'));
    }

    /**
     * Simpan data siswa baru
     */
    public function store(Request $request)
    {
        // 4. Tambahkan validasi untuk 'kelas_id'
        $request->validate([
            'nis' => 'required|string|max:20|unique:students,nis',
            'name' => 'required|string|max:255',
            'kelas_id' => 'required|integer|exists:kelas,id', // Wajib ada & harus ada di tabel 'kelas'
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // 5. Simpan data (request->all() masih aman karena $fillable di model)
        Student::create($request->all());
        
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    /**
     * Tampilkan form edit
     */
    public function edit(Student $student)
    {
        // 6. Ambil juga daftar kelas untuk dropdown di halaman edit
        $daftar_kelas = Kelas::orderBy('nama_kelas')->get();
        
        return view('students.edit', compact('student', 'daftar_kelas'));
    }

    /**
     * Update data siswa
     */
    public function update(Request $request, Student $student)
    {
        // 7. Tambahkan validasi 'kelas_id' juga di sini
        $request->validate([
            'nis' => [
                'required',
                'string',
                'max:20',
                Rule::unique('students')->ignore($student->id), // Validasi unique saat update
            ],
            'name' => 'required|string|max:255',
            'kelas_id' => 'required|integer|exists:kelas,id', // Wajib ada
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // 8. Update data
        $student->update($request->all());
        
        return redirect()->route('students.index')->with('success', 'Data siswa diperbarui');
    }

    /**
     * Hapus data siswa
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Data siswa dihapus');
    }
}