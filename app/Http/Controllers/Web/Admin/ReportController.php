<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\FoodRecord;
use App\Models\GrowthRecord;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Halaman Filter Makanan
    public function foodReport(Request $request)
    {
        $children = Children::orderBy('name')->get();

        $query = FoodRecord::with('child')->latest('record_date');

        // Filter Nama Anak
        if ($request->filled('child_id')) {
            $query->where('child_id', $request->child_id);
        }

        // Filter Tanggal
        if ($request->filled('date')) {
            $query->whereDate('record_date', $request->date);
        }

        $foodRecords = $query->paginate(25)->withQueryString();

        return view('admin.reports.food', compact('foodRecords', 'children'));
    }

    // Halaman Filter Pertumbuhan
    // public function growthReport(Request $request)
    // {
    //     $children = Children::orderBy('name')->get();

    //     $query = GrowthRecord::with('child')
    //         ->where('nutritional_status', '!=', 'Data Pendukung')
    //         ->whereNotNull('nutritional_status')
    //         ->latest('record_date');

    //     if ($request->filled('child_id')) {
    //         $query->where('child_id', $request->child_id);
    //     }

    //     if ($request->filled('status')) {
    //         $query->where('nutritional_status', $request->status);
    //     }

    //     $growthRecords = $query->paginate(15)->withQueryString();

    //     return view('admin.reports.growth', compact('growthRecords', 'children'));
    // }
}