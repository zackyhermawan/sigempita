<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Children;

class ChildController extends Controller
{
    // LIST DATA
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $children = Children::latest()->get();
        } else {
            $children = Children::where('user_id', $user->id)->latest()->get();
        }

        return view('children.index', compact('children'));
    }

    // FORM CREATE
    public function create()
    {
        return view('children.create');
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
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

        Children::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'parent_name' => $request->parent_name,
            'gender' => $request->gender
        ]);

        return redirect('/children')->with('success', 'Data anak berhasil ditambahkan');
    }

    // FORM EDIT
    public function edit($id)
    {
        $child = Children::findOrFail($id);

        // proteksi user
        if (Auth::user()->role === 'user' && $child->user_id !== Auth::id()) {
            abort(403);
        }

        return view('children.edit', compact('child'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $child = Children::findOrFail($id);

        if (Auth::user()->role === 'user' && $child->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'date_of_birth' => 'required|date',
            'parent_name' => 'required',
            'gender' => 'required|in:Laki-laki,Perempuan'
        ]);

        $child->update($request->only('name', 'date_of_birth', 'parent_name', 'gender'));

        return redirect('/children')->with('success', 'Data anak berhasil diupdate');
    }

    // DELETE
    public function destroy($id)
    {
        $child = Children::findOrFail($id);

        if (Auth::user()->role === 'user' && $child->user_id !== Auth::id()) {
            abort(403);
        }

        $child->delete();

        return redirect('/children')->with('success', 'Data anak berhasil dihapus');
    }
}