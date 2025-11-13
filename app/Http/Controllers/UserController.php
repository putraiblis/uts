<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user
     */
    public function index(): View
    {
        // Ambil semua user, urutkan berdasarkan nama
        $users = User::orderBy('name')->get();
        
        // Kirim data users ke view
        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan formulir untuk membuat user baru
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Menyimpan user baru ke database
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', 'in:admin,user'], // Pastikan role-nya valid
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // 'confirmed' akan mencocokkan dengan 'password_confirmation'
        ]);

        // Buat user baru
        // Password akan di-hash secara otomatis oleh Model (karena kita sudah setting di app/Models/User.php)
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir untuk mengedit user
     */
    public function edit(User $user): View
    {
        // $user otomatis diambil oleh Laravel (Route Model Binding)
        return view('users.edit', compact('user'));
    }

    /**
     * Memperbarui data user di database
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$user->id], // Unik KECUALI untuk user ini sendiri
            'role' => ['required', 'in:admin,user'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Password boleh kosong (nullable)
        ]);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Cek jika admin mengisi password baru
        if ($request->filled('password')) {
            $user->password = $request->password; // Password akan di-hash otomatis oleh Model
        }

        $user->save(); // Simpan perubahan

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user dari database
     */
    public function destroy(User $user): RedirectResponse
    {
        // Hapus user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Data user berhasil dihapus.');
    }
}