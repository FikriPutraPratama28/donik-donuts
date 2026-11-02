<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'is_available',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'is_available' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name) . '-' . time();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            // Cek path baru (public/images/products/)
            if (file_exists(public_path($this->image))) {
                return asset($this->image);
            }
            // Fallback path lama (storage/app/public/)
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)) {
                return asset('storage/' . $this->image);
            }
        }
        return asset('images/no-image.png');
    }
}
