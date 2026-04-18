<?php

namespace App\Http\Controllers\Web;

use App\Models\GrowthRecord;
use App\Models\Children;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Monitoring;

class GrowthRecordController extends Controller
{
    // LIST / RIWAYAT
    public function index(Request $request)
    {
        $query = GrowthRecord::with(['child', 'admin']);

        // 1. Filter Role (Hanya lihat data anak sendiri jika bukan admin)
        if (Auth::user()->role !== 'admin') {
            $query->whereHas('child', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }

        // 2. Filter Nama Anak
        $query->when($request->child_id, function ($q) use ($request) {
            $q->where('child_id', $request->child_id);
        });

        // 3. Filter Status Gizi (Sangat berguna untuk melihat history anak tertentu)
        $query->when($request->status, function ($q) use ($request) {
            $q->where('nutritional_status', $request->status);
        });

        // 4. Filter Berdasarkan Bulan/Tahun (Opsional, tapi bagus untuk laporan)
        $query->when($request->date, function ($q) use ($request) {
            $q->whereDate('record_date', $request->date);
        });

        // Ambil data terbaru di paling atas dan gunakan pagination
        $records = $query->latest()->paginate(10)->withQueryString();

        // Ambil daftar anak untuk dropdown filter
        $children = Auth::user()->role === 'admin' 
                    ? \App\Models\Children::all() 
                    : \App\Models\Children::where('user_id', Auth::id())->get();

        return view('growth.index', compact('records', 'children'));
    }

    // FORM CREATE
    public function create()
    {
        if (Auth::user()->role === 'admin') {
            $children = Children::all();
        } else {
            $children = Children::where('user_id', Auth::id())->get();
        }

        return view('growth.create', compact('children'));
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'child_id' => 'required',
            'record_date' => 'required|date',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
        ], [
            'child_id.required' => 'Pilih anak',
            'record_date.required' => 'Tanggal wajib diisi',
            'weight.required' => 'Berat badan wajib diisi',
            'height.required' => 'Tinggi badan wajib diisi',
        ]);

        GrowthRecord::create([
            'child_id' => $request->child_id,
            'record_date' => $request->record_date,
            'weight' => $request->weight,
            'height' => $request->height,
        ]);

        return redirect('/growth')->with('success', 'Data pertumbuhan berhasil disimpan');
    }

    public function edit($id)
    {
        $record = GrowthRecord::with('child')->findOrFail($id);
    
        // Gunakan !=
        if (Auth::user()->role === 'user' && $record->child->user_id != Auth::id()) {
            abort(403);
        }
        return view('growth.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = GrowthRecord::with('child')->findOrFail($id);

    // Gunakan !=
        if (Auth::user()->role === 'user' && $record->child->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'child_id' => 'required',
            'record_date' => 'required|date',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
        ]);

        $record->update($request->only('child_id', 'record_date', 'weight', 'height'));

        return redirect('/growth')->with('success', 'Data pertumbuhan berhasil diupdate');
    }

    public function history(Request $request)
    {
        $query = Monitoring::with(['child', 'growth', 'admin'])
            ->whereHas('child', function ($q) {
                $q->where('user_id', Auth::id());
            });

        // 1. Filter Nama Anak
        $query->when($request->child_id, function ($q) use ($request) {
            $q->where('child_id', $request->child_id);
        });

        // 2. Filter Status Monitoring (Pending/Reviewed/Warning)
        $query->when($request->status, function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        // 3. Filter Tanggal Penilaian
        $query->when($request->date, function ($q) use ($request) {
            $q->whereDate('created_at', $request->date);
        });

        // Ambil data terbaru dan paginate
        $history = $query->latest()->paginate(10)->withQueryString();

        // Daftar anak milik Bunda untuk dropdown filter
        $children = \App\Models\Children::where('user_id', Auth::id())->get();

        return view('growth.history', compact('history', 'children'));
    }

    // DELETE (opsional)
    public function destroy(Request $request, $id) // Tambahkan Request $request
    {
        $record = GrowthRecord::findOrFail($id);

        // Proteksi user (Sudah Mantap!)
        if (Auth::user()->role === 'user' && $record->child->user_id != Auth::id()) {
            abort(403);
        }

        // Simpan halaman saat ini sebelum dihapus
        $currentPage = $request->query('page', 1);

        $record->delete();

        // Cek sisa data untuk menentukan apakah harus pindah halaman
        $remainingItems = GrowthRecord::whereHas('child', function ($q) {
            if (Auth::user()->role !== 'admin') {
                $q->where('user_id', Auth::id());
            }
        })->count();

        $itemsPerPage = 10;
        $lastPage = ceil($remainingItems / $itemsPerPage);

        // Jika halaman saat ini lebih besar dari total halaman yang tersedia, 
        // dan total halaman masih ada (> 0), arahkan ke halaman terakhir yang ada.
        if ($currentPage > $lastPage && $lastPage > 0) {
            return redirect()->route('growth.index', ['page' => $lastPage])
                            ->with('success', 'Catatan berhasil dihapus.');
        }

        return redirect('/growth')->with('success', 'Catatan berhasil dihapus.');
    }
}
