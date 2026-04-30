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
        'status',
        'bank_id'
    ];

    protected $casts = [
        'deposit_date' => 'date',
    ];

    // RELASI
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wasteType()
    {
        return $this->belongsTo(WasteType::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    // ACCESSOR
    public function getPointsAttribute()
    {
        return $this->weight_kg * ($this->wasteType->reward_per_kg ?? 0);
    }

    public function getFormattedDateAttribute()
    {
        return $this->deposit_date->format('d/m/Y');
    }

    public function getStatusLabelAttribute()
    {
        return [
            'pending' => 'Menunggu',
            'verified' => 'Diverifikasi',
            'rejected' => 'Ditolak',
        ][$this->status] ?? 'Unknown';
    }

    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'text-warning',
            'verified' => 'text-success',
            'rejected' => 'text-danger',
        ][$this->status] ?? 'text-secondary';
    }
}