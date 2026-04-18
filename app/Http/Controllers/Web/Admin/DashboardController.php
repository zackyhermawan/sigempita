<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\Monitoring;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    // ðŸ”¹ Total anak & bunda
    $totalChildren = Children::count();
    $totalParents = User::where('role', 'user')->count();

    // ðŸ”¹ Ambil semua anak + relasi
    $children = Children::with(['growthRecords', 'monitorings'])->get();

    $needValidation = 0;
    $riskCount = 0;

    foreach ($children as $child) {

        // Ambil growth terbaru
        $lastGrowth = $child->growthRecords
            ->sortByDesc('record_date')
            ->sortByDesc('created_at')
            ->first();

        // Ambil monitoring terbaru
        $lastMonitoring = $child->monitorings
            ->sortByDesc('created_at')
            ->first();

        // ðŸ”¥ 1. PERLU VALIDASI
        if ($lastGrowth && !$lastMonitoring) {
            $needValidation++;
        }

        if ($lastGrowth && $lastMonitoring) {
            // kalau ada data baru setelah dinilai
            if ($lastGrowth->created_at > $lastMonitoring->created_at) {
                $needValidation++;
            }
        }

        // ðŸ”¥ 2. ANAK BERISIKO
        if ($lastMonitoring && in_array($lastMonitoring->nutritional_status, [
            'Gizi Kurang', 'Stunting', 'Obesitas'
        ])) {
            $riskCount++;
        }
    }

    // ðŸ”¥ Monitoring terbaru (untuk tabel)
    $latestMonitoring = Monitoring::with(['child'])
        ->latest()
        ->take(5)
        ->get();

    // ðŸ”¥ Anak perlu perhatian (tidak update > 7 hari)
    $attention = $children->filter(function ($child) {
        $lastGrowth = $child->growthRecords
            ->sortByDesc('record_date')
            ->first();

        return !$lastGrowth || Carbon::parse($lastGrowth->record_date)->lt(now()->subDays(7));
    });

    $riskChildren = $children->filter(function ($child) {

    $lastMonitoring = $child->monitorings
        ->sortByDesc('created_at')
        ->first();

    return $lastMonitoring && in_array($lastMonitoring->nutritional_status, [
        'Gizi Kurang', 'Stunting', 'Obesitas'
    ]);
});

    return view('admin.dashboard', compact(
        'totalChildren',
        'totalParents',
        'needValidation',
        'riskCount',
        'latestMonitoring',
        'attention',
        'riskChildren'
    ));
}
}