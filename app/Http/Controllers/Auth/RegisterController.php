<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        // Hanya role author dan reviewer yang bisa register sendiri
        $roles = Role::whereIn('slug', ['author', 'reviewer'])->get();
        $departments = Department::all();

        return view('auth.register', compact('roles', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        // Pastikan role yang dipilih bukan super-admin
        $role = Role::find($validated['role_id']);
        if ($role->slug === 'super-admin') {
            return back()->withErrors(['role_id' => 'Anda tidak dapat mendaftar sebagai Super Admin.']);
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'department_id' => $validated['department_id'],
            'is_active' => false, // Perlu aktivasi oleh Super Admin
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan tunggu aktivasi dari administrator.');
    }
}
