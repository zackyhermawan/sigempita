<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildrenController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai query
        $query = \App\Models\Children::query();

        // 2. Logika Filter Pencarian (Nama Anak atau Nama Ibu)
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('parent_name', 'like', "%{$search}%");
            });
        }

        // 3. Ambil data dengan pagination (10 data per halaman)
        // withQueryString() wajib ada supaya saat pindah halman 2, hasil filternya gak ilang
        $children = $query->latest()->paginate(10)->withQueryString();

        return view('admin.children.index', compact('children'));
    }

    public function create()
    {
        // Ambil semua user dengan role 'user' untuk dropdown pilihan Bunda
        $users = User::where('role', 'user')->get();
        return view('admin.children.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required',
            'date_of_birth' => 'required|date',
            'parent_name' => 'required',
            'gender' => 'required|in:Laki-laki,Perempuan'
        ], [
            'name.required' => 'Nama wajib diisi',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi',
            'parent_name.required' => 'Nama orang tua wajib diisi',
            'gender.required' => 'Jenis kelamin wajib diisi'
        ]);

        Children::create($request->all());

        return redirect('/admin/children')->with('success', 'Data anak berhasil ditambahkan oleh Admin');
    }

    public function edit($id)
    {
        $child = Children::findOrFail($id);
        $users = User::where('role', 'user')->get();
        return view('admin.children.edit', compact('child', 'users'));
    }

    public function update(Request $request, $id)
    {
        $child = Children::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'date_of_birth' => 'required|date',
            'parent_name' => 'required',
            'gender' => 'required|in:Laki-laki,Perempuan'
        ], [
            'name.required' => 'Nama wajib diisi',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi',
            'parent_name.required' => 'Nama orang tua wajib diisi',
            'gender.required' => 'Jenis kelamin wajib diisi'
        ]);

        $child->update($request->all());

        return redirect('/admin/children')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $child = Children::findOrFail($id);
        $child->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}