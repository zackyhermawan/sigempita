<?php

namespace App\Http\Controllers\Web;

use App\Models\FoodRecord;
use App\Models\Children;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class FoodRecordController extends Controller
{
    // LIST / RIWAYAT
    public function index(Request $request)
    {
        // 1. Kunci query hanya untuk anak milik User yang sedang login
        $query = FoodRecord::whereHas('child', function ($q) {
            $q->where('user_id', Auth::id());
        })->with('child');

        // 2. Filter Berdasarkan Nama Anak (Jika Ibu punya lebih dari 1 anak)
        $query->when($request->child_id, function ($q) use ($request) {
            $q->where('child_id', $request->child_id);
        });

        // 3. Filter Berdasarkan Periode Makan
        $query->when($request->feeding_period, function ($q) use ($request) {
            $q->where('feeding_period', $request->feeding_period);
        });

        // 4. Filter Berdasarkan Tanggal
        $query->when($request->date, function ($q) use ($request) {
            $q->whereDate('record_date', $request->date);
        });

        // Pagination tetap 10 data
        $records = $query->latest()->paginate(10)->withQueryString();

        // Ambil daftar anak khusus milik Ibu ini saja untuk dropdown filter
        $children = \App\Models\Children::where('user_id', Auth::id())->get();

        return view('food.index', compact('records', 'children'));
    }

    // FORM CREATE
    public function create()
    {
        if (Auth::user()->role === 'admin') {
            $children = Children::all();
        } else {
            $children = Children::where('user_id', Auth::id())->get();
        }

        return view('food.create', compact('children'));
    }

    // SIMPAN
    public function store(Request $request)
    {
        $request->validate([
            'child_id' => 'required',
            'record_date' => 'required|date',
            'food_type' => 'required',
            'feeding_period' => 'required'
        ], [
            'child_id.required' => 'Pilih anak',
            'record_date.required' => 'Tanggal wajib diisi',
            'food_type.required' => 'Jenis makanan wajib diisi',
            'feeding_period.required' => 'Waktu wajib diisi',
        ]);

        FoodRecord::create([
            'child_id' => $request->child_id,
            'record_date' => $request->record_date,
            'food_type' => $request->food_type,
            'feeding_period' => $request->feeding_period
        ]);

        return redirect('/food')->with('success', 'Data makanan berhasil disimpan');
    }

    public function edit($id)
{
    // Eager load relasi 'child' untuk cek user_id
    $record = FoodRecord::with('child')->findOrFail($id);

    // Proteksi: Cek user_id milik anak yang ada di record tersebut
    if (Auth::user()->role === 'user' && $record->child->user_id != Auth::id()) {
        abort(403);
    }

    // Untuk dropdown edit, ambil daftar anak milik user tersebut
    $children = Children::where('user_id', Auth::id())->get();

    return view('food.edit', compact('record', 'children'));
}

public function update(Request $request, $id)
{
    $record = FoodRecord::with('child')->findOrFail($id);

    // Proteksi yang sama
    if (Auth::user()->role === 'user' && $record->child->user_id != Auth::id()) {
        abort(403);
    }

    $request->validate([
        'child_id' => 'required',
        'record_date' => 'required|date',
        'food_type' => 'required',
        'feeding_period' => 'required'
    ]);

    $record->update($request->only('child_id', 'record_date', 'food_type', 'feeding_period'));

    return redirect('/food')->with('success', 'Data makanan berhasil diupdate');
}

    // DELETE
    public function destroy($id)
{
    $record = FoodRecord::findOrFail($id);
    
    // Simpan informasi halaman saat ini sebelum dihapus
    $currentPage = request('page', 1);

    $record->delete();

    // Cek apakah setelah dihapus, halaman saat ini menjadi kosong
    // Kita cek sisa data milik user tersebut (atau semua jika admin)
    $remainingItems = FoodRecord::whereHas('child', function ($q) {
            $q->where('user_id', Auth::id());
        })->count();

    // Hitung total halaman yang tersedia sekarang (asumsi 10 data per halaman)
    $itemsPerPage = 10;
    $lastPage = ceil($remainingItems / $itemsPerPage);

    // Jika halaman saat ini lebih besar dari total halaman yang tersedia, 
    // dan total halaman masih ada (> 0), arahkan ke halaman terakhir yang ada.
    if ($currentPage > $lastPage && $lastPage > 0) {
        return redirect()->route('food.index', ['page' => $lastPage])
                         ->with('success', 'Catatan berhasil dihapus.');
    }

    return redirect('/food')->with('success', 'Catatan berhasil dihapus.');
}
}