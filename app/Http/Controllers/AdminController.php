<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\User;
Use App\Models\Deposit;

class AdminController extends Controller
{
    public function index()
    {
        $deposits = Deposit::with(['wasteType', 'user'])->latest()->get();
        $totalVerified = $deposits->where('status', 'verified')->count();
        $totalmitra = User::where('role', 'mitra')->where('is_approved', true)->count();
        $totalsampah = Deposit::where('status', 'verified')->sum('weight_kg');
        $totalwarga = User::where('role', 'warga')->count();
        $totaladmin = User::where('role', 'admin')->count();
        $totalpengguna = $totalmitra + $totalwarga + $totaladmin;
        $users = User::whereIn('role', ['mitra', 'warga'])->latest()->get();
        return view('admin.dashboard', compact('totalmitra', 'deposits', 'totalVerified', 'totalpengguna', 'totalsampah', 'totalwarga', 'totalpengguna', 'totaladmin', 'users'));

    }

    public function setoran()
    {
        $setoran = Deposit::with(['wasteType', 'user'])->where('status', 'verified')->latest()->get();

        return view('admin.mitra.setoran', compact('setoran'));
    }

    public function mitra()
    {
        $pending = User::where('role', 'mitra')
                    ->where('is_approved', false)
                    ->get();

        $approved = User::where('role', 'mitra')
                        ->where('is_approved', true)
                        ->get();

        return view('admin.mitra.index', compact('pending','approved'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return back()->with('success', 'Mitra berhasil di-approve');
    }
}
