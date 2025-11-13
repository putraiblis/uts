<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan semester.
     */
    public function index()
    {
        // Cari setting 'semester_aktif' di DB.
        // Jika tidak ada, buat baru dengan default 'Ganjil'.
        $setting = Setting::firstOrCreate(
            ['key' => 'semester_aktif'],
            ['value' => 'Ganjil']
        );

        return view('settings.index', [
            'currentSemester' => $setting->value
        ]);
    }

    /**
     * Update pengaturan semester.
     */
    public function update(Request $request)
    {
        $request->validate([
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        // Cari dan update setting 'semester_aktif'
        $setting = Setting::where('key', 'semester_aktif')->first();
        $setting->value = $request->semester;
        $setting->save();

        // (Opsional tapi sangat disarankan) Hapus cache jika ada
        // agar aplikasi mengambil nilai baru
        Cache::forget('semester_aktif');

        return redirect()->route('settings.index')->with('success', 'Semester aktif berhasil diperbarui!');
    }
}