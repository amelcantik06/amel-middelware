<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number',
        'user_id',
        'customer_name',
        'customer_reference',
        'subtotal',
        'discount_percent',
        'discount_amount',
        'tax_amount',
        'additional_fee',
        'total',
        'amount_paid',
        'change_due',
        'payment_method',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'integer',
            'subtotal' => 'integer',
            'discount_percent' => 'decimal:2',
            'discount_amount' => 'integer',
            'tax_amount' => 'integer',
            'additional_fee' => 'integer',
            'amount_paid' => 'integer',
            'change_due' => 'integer',
        ];
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }
}
