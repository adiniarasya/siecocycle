<?php

namespace App\Http\Controllers;

use App\Models\Deposit;

class WargaController extends Controller
{
    public function index()
    {
        $deposits = Deposit::with('wasteType')->latest()->get();

        $totalBerat = $deposits->sum('weight_kg');

        $totalPoin = 0;
        $totalCO2 = 0;

        foreach ($deposits as $d) {
            $totalPoin += $d->weight_kg * $d->wasteType->reward_per_kg;
            $totalCO2  += $d->weight_kg * $d->wasteType->co2_factor;
        }

        return view('warga.dashboard', compact(
            'deposits',
            'totalBerat',
            'totalPoin',
            'totalCO2'
        ));
    }
}