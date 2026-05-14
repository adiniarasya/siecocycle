<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityReport extends Model
{
    use HasFactory;

    protected $table = 'community_reports';

    protected $fillable = [
        'rw_name',
        'period_start',
        'period_end',
        'total_weight',
        'total_co2',
        'total_saving',
        'file_pdf',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'total_weight' => 'decimal:2',
        'total_co2' => 'decimal:2',
        'total_saving' => 'decimal:2',
    ];
}