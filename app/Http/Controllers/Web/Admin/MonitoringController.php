<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\FoodRecord;
use App\Models\GrowthRecord;
use App\Models\Monitoring;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua data dengan relasi
        $children = Children::with(['growthRecords', 'monitorings'])->get();

        // 2. Proses Mapping Status (Logika kamu yang tadi)
        $mappedData = $children->map(function ($child) {
            $lastGrowth = $child->growthRecords
                ->sortByDesc('record_date')
                ->sortByDesc('created_at')
                ->first();

            $lastMonitoring = $child->monitorings
                ->sortByDesc('created_at')
                ->first();

            $status = 'pending';

            if (!$lastGrowth) {
                $status = 'warning';
            } elseif ($lastMonitoring && Carbon::parse($lastGrowth->created_at)->gt(Carbon::parse($lastMonitoring->created_at))) {
                $status = 'pending';
            } elseif ($lastGrowth && Carbon::parse($lastGrowth->record_date)->lt(now()->subDays(7))) {
                $status = 'warning';
            } elseif ($lastMonitoring) {
                $status = $lastMonitoring->status;
            }

            return [
                'child' => $child,
                'last_growth' => $lastGrowth,
                'monitoring' => $lastMonitoring,
                'status' => $status
            ];
        });

        // 3. LOGIKA PAGINATION MANUAL
        $currentPage = $request->input('page', 1); // Halaman saat ini
        $perPage = 20; // Data per halaman
        
        // Potong collection sesuai halaman
        $currentItems = $mappedData->slice(($currentPage - 1) * $perPage, $perPage)->values();

        // Buat Paginator
        $data = new LengthAwarePaginator(
            $currentItems, 
            $mappedData->count(), 
            $perPage, 
            $currentPage, 
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.monitoring.index', compact('data'));
    }


    public function edit($child_id)
    {
        $child = Children::with(['growthRecords', 'monitorings'])
            ->findOrFail($child_id);

        // ðŸ”¥ ambil 3 data pertumbuhan terakhir
        $growthRecords = $child->growthRecords()
            ->orderByDesc('record_date')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        $lastGrowth = $growthRecords->first();
        $lastMonitoring = $child->monitorings
            ->sortByDesc('created_at')
            ->first();

        // ðŸ”¥ makanan hari ini saja
        $foodToday = FoodRecord::where('child_id', $child_id)
            ->whereDate('record_date', today())
            ->get();

        // ðŸ”¥ indikator perubahan BB
        $weightDiff = null;
        if ($growthRecords->count() >= 2) {
            $weightDiff = $growthRecords->values()[0]->weight - $growthRecords->values()[1]->weight;
        }

        return view('admin.monitoring.edit', compact(
            'child',
            'lastGrowth',
            'lastMonitoring',
            'growthRecords',
            'foodToday',
            'weightDiff'
        ));
    }

    public function update(Request $request, $child_id)
    {
        $lastGrowth = GrowthRecord::where('child_id', $child_id)->first();

        if (!$lastGrowth) {
            return redirect()->back()
                ->with('error', 'Gagal! Tidak dapat memberi penilaian karena data pertumbuhan anak masih kosong.');
        }

        $request->validate([
            'status' => 'required|in:pending,reviewed,warning',
            'nutritional_status' => 'nullable|string|max:255',
            'admin_notes' => 'nullable|string',
        ]);

        Monitoring::create([
            'child_id' => $child_id,
            'growth_record_id' => $lastGrowth->id,
            'admin_id' => Auth::id(),
            'status' => $request->status,
            'nutritional_status' => $request->nutritional_status,
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect('/admin/monitoring')
            ->with('success', 'Penilaian berhasil disimpan');
    }

    public function history(Request $request, $child_id)
    {
        $child = Children::findOrFail($child_id);

        // 1. Inisialisasi Query
        $query = Monitoring::with(['admin', 'growth'])
            ->where('child_id', $child_id);

        // 2. Filter berdasarkan Status (misal: reviewed, warning)
        $query->when($request->status, function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        // 3. Filter berdasarkan Rentang Tanggal (Opsional)
        $query->when($request->date, function ($q) use ($request) {
            $q->whereDate('created_at', $request->date);
        });

        // 4. Pagination (misal 10 data per halaman)
        // withQueryString agar saat pindah halaman, filter status/tanggal tetap ikut
        $monitorings = $query->latest()->paginate(10)->withQueryString();

        return view('admin.monitoring.history', compact('monitorings', 'child'));
    }
    
}