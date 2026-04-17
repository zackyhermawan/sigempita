<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.password-index', compact('users'));
    }

    /**
     * FORM EDIT PASSWORD USER
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.password-edit', compact('user'));
    }

    /**
     * UPDATE PASSWORD
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('admin.users.password.index')
            ->with('success', 'Password berhasil diperbarui');
    }
}