<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get roles
        $superAdminRole = Role::where('slug', 'super_admin')->first();
        $authorRole = Role::where('slug', 'author')->first();
        $reviewerRole = Role::where('slug', 'reviewer')->first();

        // Get departments
        $p2pDept = Department::where('slug', 'p2p')->first();
        $humasDept = Department::where('slug', 'humas')->first();
        $itDept = Department::where('slug', 'it')->first();

        // Create Super Admin
        User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role_id' => $superAdminRole->id,
            'department_id' => $itDept->id,
            'is_active' => true,
        ]);

        // Create Reviewers for each department
        $reviewerP2P = User::create([
            'name' => 'Reviewer P2P',
            'email' => 'reviewer.p2p@test.com',
            'password' => Hash::make('password'),
            'role_id' => $reviewerRole->id,
            'department_id' => $p2pDept->id,
            'is_active' => true,
        ]);

        $reviewerHumas = User::create([
            'name' => 'Reviewer Humas',
            'email' => 'reviewer.humas@test.com',
            'password' => Hash::make('password'),
            'role_id' => $reviewerRole->id,
            'department_id' => $humasDept->id,
            'is_active' => true,
        ]);

        $reviewerIT = User::create([
            'name' => 'Reviewer IT',
            'email' => 'reviewer.it@test.com',
            'password' => Hash::make('password'),
            'role_id' => $reviewerRole->id,
            'department_id' => $itDept->id,
            'is_active' => true,
        ]);

        // Update departments with reviewers
        $p2pDept->update(['reviewer_id' => $reviewerP2P->id]);
        $humasDept->update(['reviewer_id' => $reviewerHumas->id]);
        $itDept->update(['reviewer_id' => $reviewerIT->id]);

        // Create Authors for each department
        User::create([
            'name' => 'Penulis P2P',
            'email' => 'author.p2p@test.com',
            'password' => Hash::make('password'),
            'role_id' => $authorRole->id,
            'department_id' => $p2pDept->id,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Penulis Humas',
            'email' => 'author.humas@test.com',
            'password' => Hash::make('password'),
            'role_id' => $authorRole->id,
            'department_id' => $humasDept->id,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Penulis IT',
            'email' => 'author.it@test.com',
            'password' => Hash::make('password'),
            'role_id' => $authorRole->id,
            'department_id' => $itDept->id,
            'is_active' => true,
        ]);

        // Create additional authors
        User::create([
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'password' => Hash::make('password'),
            'role_id' => $authorRole->id,
            'department_id' => $p2pDept->id,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@test.com',
            'password' => Hash::make('password'),
            'role_id' => $authorRole->id,
            'department_id' => $humasDept->id,
            'is_active' => true,
        ]);

        echo "✅ Users created successfully!\n";
        echo "📧 Super Admin: admin@admin.com | password\n";
        echo "📧 Reviewer P2P: reviewer.p2p@test.com | password\n";
        echo "📧 Reviewer Humas: reviewer.humas@test.com | password\n";
        echo "📧 Reviewer IT: reviewer.it@test.com | password\n";
        echo "📧 Author P2P: author.p2p@test.com | password\n";
        echo "📧 Author Humas: author.humas@test.com | password\n";
        echo "📧 Author IT: author.it@test.com | password\n";
    }
}
