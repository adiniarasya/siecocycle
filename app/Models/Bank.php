<?php

namespace App\Models;

use App\Models\Deposit;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'operation_hours',
        'contact',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }
}