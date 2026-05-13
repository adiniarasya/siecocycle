<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Deposit;

class MitraController extends Controller
{
    public function index()
    {
        // Ambil bank milik user yang login
        $bank = auth()->user()->bank;
        if (!$bank) {
            return back()->with('error', 'Akun bank tidak valid. Hubungi admin.');
        }

        // Filter deposit berdasarkan bank_id
        $pendingDeposits = Deposit::where('bank_id', $bank->id)
            ->where('status', 'pending')
            ->with(['user', 'wasteType'])
            ->orderBy('deposit_date', 'desc')
            ->paginate(15);

        $totalVerified = Deposit::where('bank_id', $bank->id)
            ->where('status', 'verified')
            ->count();

        $totalPending = Deposit::where('bank_id', $bank->id)
            ->where('status', 'pending')
            ->count();

        $totalSampah = Deposit::where('bank_id', $bank->id)
            ->where('status', 'verified')
            ->sum('weight_kg');

        return view('mitra.dashboard', compact('pendingDeposits', 'totalVerified', 'totalPending', 'totalSampah', 'bank'));
    }
    
    
    public function decision(Request $request, $id)
    {
        $deposit = Deposit::findOrFail($id);

        $deposit->status = $request->status;
        $deposit->save();

        return back()->with('success', 'Status berhasil diupdate');
    }
}