<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'operation_hours',
        'contact'
    ];
}