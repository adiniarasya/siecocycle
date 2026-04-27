<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'user_id',
        'waste_type_id',
        'weight_kg',
        'deposit_date',
        'photo_url',
        'notes',
        'status'
    ];

    public function wasteType()
    {
        return $this->belongsTo(WasteType::class);
    }
}