<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'subtotal',
        'discount',
        'tax',
        'total',
        'payment_amount',
        'change_amount',
        'payment_method',
        'status',
        'notes',
        'customer_name',
    ];

    protected $casts = [
        'subtotal'       => 'decimal:2',
        'discount'       => 'decimal:2',
        'tax'            => 'decimal:2',
        'total'          => 'decimal:2',
        'payment_amount' => 'decimal:2',
        'change_amount'  => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public static function generateInvoice(): string
    {
        $prefix = 'TK-' . date('Ymd') . '-';
        $last   = static::where('invoice_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $number = $last
            ? (intval(substr($last->invoice_number, -4)) + 1)
            : 1;

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
