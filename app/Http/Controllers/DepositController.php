<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\WasteType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
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