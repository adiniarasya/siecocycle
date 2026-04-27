<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Deposit;

class MitraController extends Controller
{
    public function index()
{
    // DATA BANK (opsional)
    $totalBank = Bank::count();
    $banks = Bank::latest()->get();

    // DATA DEPOSIT
    $deposits = Deposit::with(['wasteType', 'user'])->latest()->get();

    // ✅ SUMMARY (INI YANG KURANG TADI)
    $totalPending = $deposits->where('status', 'pending')->count();
    $totalVerified = $deposits->where('status', 'verified')->count();
    $totalSampah = $deposits->sum('weight_kg');

    // OPSIONAL (kalau mau dipakai nanti)
    $totalPoin = $deposits->sum(function ($item) {
        return $item->wasteType
            ? $item->weight_kg * $item->wasteType->reward_per_kg
            : 0;
    });

    return view('mitra.dashboard', compact(
        'totalBank',
        'banks',
        'deposits',
        'totalPending',
        'totalVerified',
        'totalSampah',
        'totalPoin'
    ));
}
    public function decision(Request $request, $id)
{
    $deposit = Deposit::findOrFail($id);

    $deposit->status = $request->status;
    $deposit->save();

    return back()->with('success', 'Status berhasil diupdate');
}
}