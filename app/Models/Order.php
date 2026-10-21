<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    //
    protected $table = 'orders';

    protected $primaryKey = 'id_order';

    protected $fillable = [
        'customer',
        'status',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'id_order', 'id_order');
    }
}
