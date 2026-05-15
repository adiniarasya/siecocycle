<?php

namespace App\Http\Controllers;

use App\Models\Bank;
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

    public function datawarga()
    {
        $warga = User::where('role', 'warga')->get();
        return view('admin.warga.data', compact('warga'));
    }

    public function mitra()
    {
        $pending = User::where('role', 'mitra')
                    ->where('is_approved', false)
                    ->with('bank')
                    ->get();

        $approved = User::where('role', 'mitra')
                        ->where('is_approved', true)
                        ->with('bank')
                        ->get();

        return view('admin.mitra.index', compact('pending','approved'));
    }

    public function banksEdit(Bank $bank)
    {
        $user = $bank->user;
        return view('admin.mitra.edit', compact('bank','user'));
    }

    public function banksUpdate(Request $request, Bank $bank)
    {
        $user = $bank->user;

        $validatedBank = $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'nullable|string',
            'operation_hours' => 'nullable|string|max:100',
            'contact' => 'nullable|string|max:15',
        ]);

        $validatedUser = $request->validate([
            'user_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . ($user ? $user->id : 'NULL'),
        ]);

        // Update bank
        $bank->update($validatedBank);

        // Update user jika ada
        if ($user) {
            $user->name = $request->user_name;
            $user->email = $request->email;
            $user->save();
        }
        return redirect()->route('admin.mitra')->with('success', 'Mitra berhasil diperbarui.');
    }

    public function banksDestroy(Bank $bank)
    {
        if ($bank->deposits()->count() > 0) {
            return back()->with('error', 'Bank memiliki setoran, tidak bisa dihapus.');
        }
        $bank->delete();
        return back()->with('success', 'Bank dihapus.');
    }

    public function banksLocation(Bank $bank)
    {
        return view('admin.mitra.location', compact('bank'));
    }

    public function banksUpdateLocation(Request $request, Bank $bank)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $bank->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('admin.mitra')->with('success', 'Lokasi bank diperbarui.');
    }
    
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return back()->with('success', 'Mitra berhasil di-approve');
    }
}