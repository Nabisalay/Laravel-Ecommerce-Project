<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'description',
        'price',
        'warrenty',
        'prodImg',
        'prodCode',
        'CategoryNo',
        'prodId',
    ];
}
