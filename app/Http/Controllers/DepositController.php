<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\WasteType;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index()
    {
        $deposits = Deposit::with('wasteType')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('warga.dashboard', compact('deposits'));
    }

    public function create(Request $request)
    {
        // $wasteTypes = WasteType::where('is_active', 1)->get();
        // $selectedBankId = $request->query('bank_id');

        // $banks = Bank::whereHas('user', function ($q) {
        //     $q->where('is_approved', true);
        // })->get(); // bank yang sudah disetujui


        // $selectedBank = null;
        // if ($selectedBankId) {
        //     $selectedBank = Bank::find($selectedBankId);
        // }

        $wasteTypes = WasteType::where('is_active', true)->get();
        $selectedBankId = $request->query('bank_id'); // ambil dari URL

        $banks = Bank::whereHas('user', function ($q) {
            $q->where('is_approved', true);
        })->get(); 
        
        $selectedBank = null;
        if ($selectedBankId) {
            $selectedBank = Bank::find($selectedBankId);
        }
        
        return view('warga.deposits.create', compact(
            'wasteTypes',
            'banks',
            'selectedBank'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'waste_type_id' => 'required|exists:waste_types,id',
            'bank_id' => 'required|exists:banks,id',
            'weight_kg' => 'required|numeric|min:0.1',
            'deposit_date' => 'required|date',
            'photo_url' => 'nullable|url',
            'notes' => 'nullable|string',
            'ai_scanned' => 'sometimes|boolean',
        ]);

        $wasteType = WasteType::find($request->waste_type_id);
        $co2Saved = $request->weight_kg * $wasteType->co2_factor;
        $points = $request->weight_kg * $wasteType->reward_per_kg;

        $deposit = Deposit::create([
            'user_id' => Auth::id(),
            'waste_type_id' => $request->waste_type_id,
            'bank_id' => $request->bank_id,
            'weight_kg' => $request->weight_kg,
            'deposit_date' => $request->deposit_date,
            'photo_url' => $request->photo_url,
            'notes' => $request->notes,
            'status' => 'pending',
            'ai_scanned' => $request->ai_scanned ?? false,
            'co2_saved' => $co2Saved,
            'points' => $points,
        ]);
        
        return redirect()->route('warga.dashboard')
            ->with('success', 'Berhasil tambah setoran!');
    }

    public function edit(Deposit $deposit)
    {
        if ($deposit->user_id !== Auth::id()) {
            abort(403);
        }
        
        $wasteTypes = WasteType::where('is_active', true)->get();
        return view('warga.deposits.edit', compact('deposit', 'wasteTypes'));
    }

    public function show($id)
    {
        $deposit = Deposit::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('warga.deposits.show', compact('deposit'));
    }

    public function update(Request $request, Deposit $deposit)
    {
         if ($deposit->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'waste_type_id' => 'required|exists:waste_types,id',
            'weight_kg' => 'required|numeric|min:0.1',
            'deposit_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $deposit->update($request->only(['waste_type_id', 'weight_kg', 'deposit_date', 'notes']));

        return redirect()->route('warga.dashboard')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(Deposit $deposit)
    {
        $this->authorizeDeposit($deposit);

        $deposit->delete();

        return back()->with('success', 'Data berhasil dihapus!');
    }

    private function authorizeDeposit($deposit)
    {
        if ($deposit->user_id !== Auth::id()) {
            abort(403);
        }
    }

    public function scanAI()
    {
        $text = "Scan AI";
        return view('errors.comingsoon', compact('text'));
    }

}