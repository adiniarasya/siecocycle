<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteType extends Model
{
    protected $fillable = [
        'name', 
        'co2_factor',
        'reward_per_kg',
        'is_active'
        ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }
}