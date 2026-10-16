<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    //
    protected $table = 'orders';

    protected $primaryKey = 'id_order';

    protected $fillable = [
        'id',
        'status',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'id_order', 'id_order');
    }
}
