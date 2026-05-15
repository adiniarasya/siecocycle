<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\WasteType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Deposit::where('user_id', Auth::id())
            ->with('wasteType');

        if ($request->filled('start_date')) {
            $query->whereDate('deposit_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('deposit_date', '<=', $request->end_date);
        }

        if ($request->filled('waste_type')) {
            $query->where('waste_type_id', $request->waste_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $deposits = $query->orderBy('deposit_date', 'desc')->paginate(15);

        $totalBerat = $deposits->sum('weight_kg');

        $totalCO2 = $deposits->sum(function ($d) {
            return $d->weight_kg * $d->wasteType->co2_factor;
        });

        $totalPoin = $deposits->sum(function ($d) {
            return $d->weight_kg * $d->wasteType->reward_per_kg;
        });

        $wasteTypes = WasteType::all();

        return view('warga.dashboard', compact(
            'deposits',
            'totalBerat',
            'totalPoin',
            'totalCO2',
            'wasteTypes'
        ));
    }
}