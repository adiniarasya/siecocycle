<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Deposit;

class MitraController extends Controller
{
    public function index()
    {

        $bank = auth()->user()->bank;
        if (!$bank) {
            return back()->with('error', 'Akun bank tidak valid. Hubungi admin.');
        }


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
    

    public function approved()
    {
        $bank = auth()->user()->bank;
        if (!$bank) {
            return back()->with('error', 'Akun bank tidak valid. Hubungi admin.');
        }

        $approvedDeposits = Deposit::where('bank_id', $bank->id)
            ->where('status', 'verified')
            ->with(['user', 'wasteType'])
            ->orderBy('deposit_date', 'desc')
            ->paginate(15);

        $totalApproved = Deposit::where('bank_id', $bank->id)
            ->where('status', 'verified')
            ->count();

        $totalWeight = Deposit::where('bank_id', $bank->id)
            ->where('status', 'verified')
            ->sum('weight_kg');

        return view('mitra.approved', compact('approvedDeposits', 'totalApproved', 'totalWeight', 'bank'));
    }


    public function rejected()
    {
        $bank = auth()->user()->bank;
        if (!$bank) {
            return back()->with('error', 'Akun bank tidak valid. Hubungi admin.');
        }

        $rejectedDeposits = Deposit::where('bank_id', $bank->id)
            ->where('status', 'rejected')
            ->with(['user', 'wasteType'])
            ->orderBy('deposit_date', 'desc')
            ->paginate(15);

        $totalRejected = Deposit::where('bank_id', $bank->id)
            ->where('status', 'rejected')
            ->count();

        $totalWeight = Deposit::where('bank_id', $bank->id)
            ->where('status', 'rejected')
            ->sum('weight_kg');

        return view('mitra.rejected', compact('rejectedDeposits', 'totalRejected', 'totalWeight', 'bank'));
    }
    

    public function decision(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected'
        ]);
        
        $deposit = Deposit::findOrFail($id);
        

        $bank = auth()->user()->bank;
        if ($deposit->bank_id != $bank->id) {
            return back()->with('error', 'Anda tidak memiliki akses ke data ini.');
        }
        
        $deposit->status = $request->status;
        $deposit->save();
        
        $message = $request->status == 'verified' 
            ? 'Setoran berhasil disetujui!' 
            : 'Setoran berhasil ditolak!';
        
        return back()->with('success', $message);
    }


public function report()
{
    $bank = auth()->user()->bank;
    if (!$bank) {
        return back()->with('error', 'Akun bank tidak valid. Hubungi admin.');
    }

    $deposits = Deposit::where('bank_id', $bank->id)
        ->where('status', 'verified')
        ->with(['user', 'wasteType'])
        ->orderBy('deposit_date', 'desc')
        ->get();

    $totalDeposits = $deposits->count();
    $totalWeight = $deposits->sum('weight_kg');
    
    // Data per jenis sampah
    $wasteTypes = \App\Models\WasteType::all();
    $wasteTypeStats = [];
    foreach ($wasteTypes as $type) {
        $wasteTypeStats[$type->name] = [
            'weight' => $deposits->where('waste_type_id', $type->id)->sum('weight_kg'),
            'count' => $deposits->where('waste_type_id', $type->id)->count()
        ];
    }

    return view('mitra.report', compact('deposits', 'totalDeposits', 'totalWeight', 'wasteTypeStats', 'bank'));
}


public function reportPdf(Request $request)
{
    $bank = auth()->user()->bank;
    if (!$bank) {
        return back()->with('error', 'Akun bank tidak valid. Hubungi admin.');
    }


    $deposits = Deposit::where('bank_id', $bank->id)
        ->where('status', 'verified')
        ->with(['user', 'wasteType'])
        ->orderBy('deposit_date', 'desc')
        ->get();

    $totalDeposits = $deposits->count();
    $totalWeight = $deposits->sum('weight_kg');

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('mitra.report-pdf', compact('deposits', 'totalDeposits', 'totalWeight', 'bank'));
    
    return $pdf->download('laporan-setoran-' . date('Y-m-d') . '.pdf');
}
}