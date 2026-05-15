<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\WasteType;

class WasteTypesController extends Controller
{
    

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WasteType::withCount('deposits');

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status == 'active');
        }

        $wasteTypes = $query->orderBy('name')->paginate(10);

        return view('admin.waste-types.index', compact('wasteTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.waste-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:waste_types,name',
            'co2_factor' => 'required|numeric|min:0',
            'reward_per_kg' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        WasteType::create($validated);

        return redirect()->route('admin.waste-types.index')
            ->with('success', 'Waste Type berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WasteType $wasteType)
    {
        $depositsCount = $wasteType->deposits()->count();
        $totalDepositWeight = $wasteType->deposits()->sum('weight') ?? 0;
        $recentDeposits = $wasteType->deposits()->with('user')->latest()->take(5)->get();

        return view('admin.waste-types.show', compact('wasteType', 'depositsCount', 'totalDepositWeight', 'recentDeposits'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WasteType $wasteType)  
    {
        return view('admin.waste-types.edit', compact('wasteType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WasteType $wasteType)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('waste_types')->ignore($wasteType->id)
            ],
            'co2_factor' => 'required|numeric|min:0',
            'reward_per_kg' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $wasteType->update($validated);

        return redirect()->route('admin.waste-types.index')
            ->with('success', 'Waste Type berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WasteType $wasteType)
    {
        if ($wasteType->deposits()->exists()) {  
            return redirect()->route('admin.waste-types.index')
                ->with('error', 'Tidak dapat menghapus! Waste Type "' . $wasteType->name . '" sudah digunakan di ' . 
                       $wasteType->deposits()->count() . ' transaksi deposit.');
        }

        $wasteType->delete();

        return redirect()->route('admin.waste-types.index')
            ->with('success', 'Waste Type "' . $wasteType->name . '" berhasil dihapus.');
    }

    public function toggleStatus(WasteType $wasteType)
    {
        $wasteType->update(['is_active' => !$wasteType->is_active]);
        
        $status = $wasteType->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Waste Type \"{$wasteType->name}\" berhasil {$status}.");
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }
        
        $usedIds = WasteType::whereIn('id', $ids)
            ->has('deposits')
            ->pluck('id')
            ->toArray();
        
        if (!empty($usedIds)) {
            $usedNames = WasteType::whereIn('id', $usedIds)->pluck('name')->implode(', ');
            return redirect()->back()->with('error', 'Waste Type berikut tidak bisa dihapus karena sudah digunakan di deposit: ' . $usedNames);
        }
        
        $deletedCount = WasteType::whereIn('id', $ids)->delete();
        
        return redirect()->back()->with('success', $deletedCount . ' Waste Type berhasil dihapus.');
    }
}