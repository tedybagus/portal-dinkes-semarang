<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super_admin',
                'description' => 'Mengelola seluruh sistem'
            ],
            [
                'name' => 'Author',
                'slug' => 'author',
                'description' => 'Menulis dan mengelola artikel'
            ],
            [
                'name' => 'Reviewer',
                'slug' => 'reviewer',
                'description' => 'Mereview artikel dari penulis'
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }

        echo "✅ Roles created successfully!\n";
    }
}
