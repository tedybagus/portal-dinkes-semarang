<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'P2P', 'slug' => 'p2p'],
            ['name' => 'Humas', 'slug' => 'humas'],
            ['name' => 'IT', 'slug' => 'it'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}