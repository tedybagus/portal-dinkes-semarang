<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
  public function create()
  {
    $roles = Role::whereIn('slug', ['author', 'reviewer'])->get();
    $departments = Department::all();

    return view('auth.register', compact('roles', 'departments'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'role_id' => ['required', 'exists:roles,id'],
      'department_id' => ['required', 'exists:departments,id'],
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role_id' => $request->role_id,
      'department_id' => $request->department_id,
      'is_active' => false, // Perlu aktivasi oleh Super Admin
    ]);

    event(new Registered($user));

    return redirect()->route('login')->with('success', 'Registrasi berhasil! Tunggu aktivasi dari Super Admin.');
  }
}