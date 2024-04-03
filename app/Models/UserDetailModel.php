<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetailModel extends Model
{
    use HasFactory;

    protected $table = 'users_detail';

    protected $fillable = [
        'name',
        'email',
        'st_address',
        'city',
        'country',
        'zip_code',
        'number',
    ];
}
