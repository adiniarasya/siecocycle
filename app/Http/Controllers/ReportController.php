<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default filter
        $rwName = $request->rw_name ?? 'RW 05';
        $startDate = $request->period_start ?? now()->startOfMonth()->toDateString();
        $endDate = $request->period_end ?? now()->endOfMonth()->toDateString();

        // Hitung statistik
        $query = Deposit::where('status', 'verified')
            ->whereHas('user', fn($q) => $q->where('rw_name', $rwName))
            ->whereBetween('deposit_date', [$startDate, $endDate]);

        $totalWeight = $query->sum('weight_kg');

        $totals = (clone $query)->join('waste_types', 'deposits.waste_type_id', '=', 'waste_types.id')
            ->selectRaw('SUM(weight_kg * waste_types.co2_factor) as total_co2, SUM(weight_kg * waste_types.reward_per_kg) as total_saving')
            ->first();

        $totalCo2 = $totals->total_co2 ?? 0;
        $totalSaving = $totals->total_saving ?? 0;

        // Data untuk grafik
        $chartRaw = (clone $query)->select('waste_type_id', DB::raw('SUM(weight_kg) as total'))
            ->groupBy('waste_type_id')
            ->get();

        $chartData = $chartRaw->map(function ($item) {
            $wasteType = \App\Models\WasteType::find($item->waste_type_id);
            return ['name' => $wasteType->name ?? 'Unknown', 'total' => $item->total];
        });

        $details = (clone $query)->with(['user', 'wasteType'])->orderBy('deposit_date', 'desc')->limit(50)->get();
        
        return view('admin.reports.index', compact('rwName', 'startDate', 'endDate', 'totalWeight', 'totalCo2', 'totalSaving', 'chartData','details'));
    }

    // Generate dan download PDF
    public function pdf(Request $request)
    {
        $request->validate([
            'rw_name' => 'required|string',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
        ]);

        $rwName = $request->rw_name;
        $startDate = $request->period_start;
        $endDate = $request->period_end;

        $query = Deposit::where('status', 'verified')
            ->whereHas('user', fn($q) => $q->where('rw_name', $rwName))
            ->whereBetween('deposit_date', [$startDate, $endDate]);

        $totalWeight = $query->sum('weight_kg');

        $totals = (clone $query)->join('waste_types', 'deposits.waste_type_id', '=', 'waste_types.id')
            ->selectRaw('SUM(weight_kg * waste_types.co2_factor) as total_co2, SUM(weight_kg * waste_types.reward_per_kg) as total_saving')
            ->first();

        $totalCo2 = $totals->total_co2 ?? 0;
        $totalSaving = $totals->total_saving ?? 0;

        $details = (clone $query)->with(['user', 'wasteType'])->orderBy('deposit_date', 'desc')->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact('rwName', 'startDate', 'endDate', 'totalWeight', 'totalCo2', 'totalSaving', 'details'));
        return $pdf->download("laporan_{$rwName}_{$startDate}_to_{$endDate}.pdf");
    }
}