<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $banks = Bank::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($bank) {
                return [
                    'id' => $bank->id,
                    'name' => $bank->name,
                    'address' => $bank->address,
                    'lat' => (float) $bank->latitude,
                    'lng' => (float) $bank->longitude,
                    'operation_hours' => $bank->operation_hours,
                    'contact' => $bank->contact,
                ];
            });
        //dd($banks);
        return view('warga.pilih-bank', [
            'banks' => $banks,
            'apiKey' => env('GOOGLE_MAPS_API_KEY')
        ]);
    }

    public function selectBank(Request $request)
    {
        $request->validate([
            'bank_id' => 'required|exists:banks,id'
        ]);

        session(['selected_bank_id' => $request->bank_id]);

        return redirect()->route('warga.deposits.create')
            ->with('success', 'Bank sampah berhasil dipilih. Silakan isi setoran.');
    }
}