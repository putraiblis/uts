<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- Tambahkan ini
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // <-- Tambahkan HasFactory

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Fungsi custom kamu, ini sudah bagus!
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array // <-- Tambahkan method ini
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // <-- Ini akan otomatis hash password
        ];
    }
}