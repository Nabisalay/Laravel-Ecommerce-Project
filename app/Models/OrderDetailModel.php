<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailModel extends Model
{
    use HasFactory;

    protected $table = 'order_details';

    protected $fillable = [
        'order_number',
        'product_id',
        'quantity',
        'price',
        'total',
    ];
}
