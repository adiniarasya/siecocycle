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

        return view('warga.deposits.index', compact('deposits'));
    }

    public function create(Request $request)
    {
        $wasteTypes = WasteType::where('is_active', 1)->get();
        $banks = Bank::all();
        $selectedBank = null;
        if ($request->bank_id) {
            $selectedBank = Bank::find($request->bank_id);
        }

        return view('warga.deposits.create', compact(
            'wasteTypes',
            'banks',
            'selectedBank'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waste_type_id' => 'required|exists:waste_types,id',
            'weight_kg' => 'required|numeric|min:0.1',
            'deposit_date' => 'required|date',
            'bank_id' => 'required|exists:banks,id',
            'notes' => 'nullable|string',
            'photo_url' => 'nullable|url'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        Deposit::create($validated);

        return redirect()->route('warga.dashboard')
            ->with('success', 'Berhasil tambah setoran!');
    }

    public function edit(Deposit $deposit)
    {
        $this->authorizeDeposit($deposit);

        $wasteTypes = WasteType::all();
        $banks = Bank::all();

        return view('warga.deposits.edit', compact(
            'deposit',
            'wasteTypes',
            'banks'
        ));
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
        $this->authorizeDeposit($deposit);

        $validated = $request->validate([
            'waste_type_id' => 'required|exists:waste_types,id',
            'weight_kg' => 'required|numeric|min:0.1',
            'deposit_date' => 'required|date',
            'bank_id' => 'required|exists:banks,id',
            'notes' => 'nullable|string',
            'photo_url' => 'nullable|url'
        ]);

        $deposit->update($validated);

        return redirect()->route('warga.deposits.index')
            ->with('success', 'Data berhasil diupdate!');
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
        return view('warga.scan');
    }

}