<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Support\Facades\Auth;
class WargaController extends Controller
{
    public function index()
    {
        $totalPoin = 0;
        $totalCO2 = 0;
        
        $deposits = Deposit::where('user_id', Auth::id())
            ->orderBy('deposit_date', 'desc')
            ->with('wasteType')
            ->paginate(15);


        $totalBerat = $deposits->sum('weight_kg');

        $totalCO2 = $deposits->sum(function ($d) {
            return $d->weight_kg * $d->wasteType->co2_factor;
        });
        

        $totalPoin = $deposits->sum(function ($d) {
            return $d->weight_kg * $d->wasteType->reward_per_kg;
        });
    

        return view('warga.dashboard', compact(
            'deposits',
            'totalBerat',
            'totalPoin',
            'totalCO2'
        ));
    }
}