<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Relasi ke Product: Satu user bisa punya banyak produk.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role', // TAMBAHKAN INI agar kolom role bisa diisi
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function wishlist()
{
    // Menghubungkan User ke Product melalui tabel pivot 'wishlists'
    return $this->belongsToMany(\App\Models\Product::class, 'wishlists');
}
}