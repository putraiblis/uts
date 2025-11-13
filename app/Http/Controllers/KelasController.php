<?php

namespace App\Http\Controllers;

use App\Models\Kelas; // 1. Import model Kelas
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Untuk validasi unique

class KelasController extends Controller
{
    /**
     * Menampilkan daftar semua kelas.
     */
    public function index()
    {
        // Ambil semua data kelas, urutkan berdasarkan nama
        $daftar_kelas = Kelas::orderBy('nama_kelas')->get();
        
        // Kirim data ke view
        return view('kelas.index', compact('daftar_kelas'));
    }

    /**
     * Menampilkan formulir untuk membuat kelas baru.
     */
    public function create()
    {
        return view('kelas.create');
    }

    /**
     * Menyimpan kelas baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'kode_kelas' => 'required|string|max:10|unique:kelas,kode_kelas',
            'nama_kelas' => 'required|string|max:255',
        ]);

        // Buat kelas baru di database
        Kelas::create([
            'kode_kelas' => $request->kode_kelas,
            'nama_kelas' => $request->nama_kelas,
        ]);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('kelas.index')
                         ->with('success', 'Kelas baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit kelas.
     * Kita menggunakan $kelas (Route Model Binding)
     */
    public function edit(Kelas $kela) // $kela adalah nama parameter di route resource
    {
        return view('kelas.edit', [
            'kelas' => $kela // Kirim data kelas yang mau di-edit ke view
        ]);
    }

    /**
     * Memperbarui data kelas di database.
     */
    public function update(Request $request, Kelas $kela)
    {
        // Validasi data
        $request->validate([
            'kode_kelas' => [
                'required',
                'string',
                'max:10',
                // Pastikan kode_kelas unik, KECUALI untuk ID kelas ini sendiri
                Rule::unique('kelas')->ignore($kela->id),
            ],
            'nama_kelas' => 'required|string|max:255',
        ]);

        // Update data kelas
        $kela->update([
            'kode_kelas' => $request->kode_kelas,
            'nama_kelas' => $request->nama_kelas,
        ]);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('kelas.index')
                         ->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Menghapus data kelas dari database.
     */
    public function destroy(Kelas $kela)
    {
        try {
            // Hapus kelas
            $kela->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('kelas.index')
                             ->with('success', 'Data kelas berhasil dihapus.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani jika ada error foreign key (misal: kelas masih punya siswa)
            if ($e->getCode() == 23000) { // Error integritas database
                return redirect()->route('kelas.index')
                                 ->with('error', 'Data kelas tidak bisa dihapus karena masih digunakan oleh data siswa.');
            }
            // Jika error lain
            return redirect()->route('kelas.index')
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail satu kelas (jika diperlukan).
     * Saat ini kita tidak pakai, tapi biarkan saja.
     */
    public function show(Kelas $kela)
    {
        //
    }
}