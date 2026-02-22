<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class UserHelper
{
  public static function createSuperAdmin($name, $email, $password = 'password')
  {
    $role = Role::where('slug', 'super_admin')->first();
    $department = Department::first();

    return User::create([
      'name' => $name,
      'email' => $email,
      'password' => Hash::make($password),
      'role_id' => $role->id,
      'department_id' => $department->id,
      'is_active' => true,
    ]);
  }

  public static function createAuthor($name, $email, $departmentSlug, $password = 'password')
  {
    $role = Role::where('slug', 'author')->first();
    $department = Department::where('slug', $departmentSlug)->first();

    return User::create([
      'name' => $name,
      'email' => $email,
      'password' => Hash::make($password),
      'role_id' => $role->id,
      'department_id' => $department->id,
      'is_active' => true,
    ]);
  }

  public static function createReviewer($name, $email, $departmentSlug, $password = 'password')
  {
    $role = Role::where('slug', 'reviewer')->first();
    $department = Department::where('slug', $departmentSlug)->first();

    $user = User::create([
      'name' => $name,
      'email' => $email,
      'password' => Hash::make($password),
      'role_id' => $role->id,
      'department_id' => $department->id,
      'is_active' => true,
    ]);

    // Set as department reviewer
    $department->update(['reviewer_id' => $user->id]);

    return $user;
  }

  public static function listUsers()
  {
    return User::with(['role', 'department'])->get()->map(function ($user) {
      return [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role->name,
        'department' => $user->department->name,
        'active' => $user->is_active ? 'Yes' : 'No',
      ];
    });
  }
}
