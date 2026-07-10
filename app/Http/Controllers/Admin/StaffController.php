<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::whereIn('role', ['kasir', 'barista'])->latest()->get();
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|in:kasir,barista',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Akun staf berhasil dibuat.');
    }

    public function edit(User $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $staff->id,
            'role' => 'required|in:kasir,barista',
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $staff->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        if ($validated['password']) {
            $staff->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('admin.staff.index')->with('success', 'Data staf berhasil diperbarui.');
    }

    public function destroy(User $staff)
    {
        if ($staff->role === 'admin') {
            return back()->with('error', 'Tidak bisa menghapus akun admin.');
        }

        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Akun staf berhasil dihapus.');
    }
}
