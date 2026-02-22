<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    protected $signature = 'user:create 
                            {--role= : Role slug (super-admin, author, reviewer)}
                            {--name= : User name}
                            {--email= : User email}
                            {--password= : User password}
                            {--department= : Department slug (p2p, humas, it)}
                            {--active : Set user as active}';

    protected $description = 'Create a new user with specified role and department';

    public function handle()
    {
        // Get or ask for role
        $roleSlug = $this->option('role') ?? $this->choice(
            'Select role',
            ['super_admin', 'author', 'reviewer'],
            0
        );

        $role = Role::where('slug', $roleSlug)->first();
        if (!$role) {
            $this->error("Role '{$roleSlug}' not found!");
            return 1;
        }

        // Get or ask for department
        $departmentSlug = $this->option('department') ?? $this->choice(
            'Select department',
            ['p2p', 'humas', 'it'],
            0
        );

        $department = Department::where('slug', $departmentSlug)->first();
        if (!$department) {
            $this->error("Department '{$departmentSlug}' not found!");
            return 1;
        }

        // Get or ask for name
        $name = $this->option('name') ?? $this->ask('Enter user name');

        // Get or ask for email
        $email = $this->option('email') ?? $this->ask('Enter user email');

        // Validate email
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|unique:users,email'
        ]);

        if ($validator->fails()) {
            $this->error($validator->errors()->first('email'));
            return 1;
        }

        // Get or ask for password
        $password = $this->option('password') ?? $this->secret('Enter user password (min 8 characters)');

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters!');
            return 1;
        }

        // Check if active flag
        $isActive = $this->option('active') ?? $this->confirm('Set user as active?', true);

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => $role->id,
            'department_id' => $department->id,
            'is_active' => $isActive,
        ]);

        $this->info('✅ User created successfully!');
        $this->line('');
        $this->table(
            ['Field', 'Value'],
            [
                ['Name', $user->name],
                ['Email', $user->email],
                ['Role', $role->name],
                ['Department', $department->name],
                ['Active', $user->is_active ? 'Yes' : 'No'],
            ]
        );

        return 0;
    }
}
