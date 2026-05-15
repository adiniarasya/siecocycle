<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\WasteType;
use Illuminate\Http\Request;

class AIScanController extends Controller
{
    public function index()
    {
        $wasteTypes = WasteType::where('is_active', true)->get();
        $banks = Bank::whereHas('user', function ($q) {
            $q->where('is_approved', true);
        })->get();

        return view('warga.ai-scan', compact('wasteTypes', 'banks'));
    }

    public function mapClass(Request $request)
    {
        $className = $request->className;
        $wasteType = WasteType::where('name', $className)->first();

        if ($wasteType) {
            return response()->json([
                'success' => true,
                'waste_type_id' => $wasteType->id,
                'waste_name' => $wasteType->name
            ]);
        }

        return response()->json(['success' => false]);
    }
}