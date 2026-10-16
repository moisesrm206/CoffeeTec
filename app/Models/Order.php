<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
