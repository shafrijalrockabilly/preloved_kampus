<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name', 
        'category', 
        'price', 
        'description', 
        'location', 
        'whatsapp_number', 
        'image',
        'user_id',
        'is_sold',  
    ];

    /**
     * Relasi ke User: Satu produk dimiliki oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function favoritedBy()
{
    return $this->belongsToMany(User::class, 'wishlists');
}
}