<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderIdModel extends Model
{
    use HasFactory;

    protected $table = 'order_id';

    protected $fillable = ['order_id'];
}
