<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\WasteType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index()
{
    $deposits = Deposit::with('wasteType')
        ->where('user_id', Auth::id()) // biar per user
        ->latest()
        ->get();

    $totalBerat = $deposits->sum('weight_kg');

    $totalPoin = $deposits->sum(function ($item) {
        return $item->wasteType
            ? $item->weight_kg * $item->wasteType->reward_per_kg
            : 0;
    });

    $totalCO2 = $deposits->sum(function ($item) {
        return $item->wasteType
            ? $item->weight_kg * $item->wasteType->co2_factor
            : 0;
    });

    return view('warga.dashboard', compact(
        'deposits',
        'totalBerat',
        'totalPoin',
        'totalCO2'
    ));
}

    public function create()
    {
        $wasteTypes = WasteType::where('is_active', 1)->get();
        return view('warga.deposits.create', compact('wasteTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'waste_type_id' => 'required|exists:waste_types,id',
            'weight_kg' => 'required|numeric|min:0.1',
            'deposit_date' => 'required|date',
        ]);

        $waste = WasteType::findOrFail($request->waste_type_id);
        $poin = $request->weight_kg * $waste->reward_per_kg;
        $co2  = $request->weight_kg * $waste->co2_factor;

        Deposit::create([
            'user_id' => Auth::id(), 
            'waste_type_id' => $request->waste_type_id,
            'weight_kg' => $request->weight_kg,
            'deposit_date' => $request->deposit_date,
            'status' => 'pending',
            'notes' => "Poin: $poin | CO2: $co2 kg"
        ]);

        return redirect()->route('warga.index')
            ->with('success', 'Berhasil tambah setoran!');
    }
}