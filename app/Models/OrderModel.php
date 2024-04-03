<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = [
        'order_id',
        'email',
        'payment_method',
        'order_number',
        'total',
        'delivery_type',
    ];
}
