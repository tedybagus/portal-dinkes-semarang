<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PpidCategory;

class PpidSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Informasi Berkala',
                'slug' => 'berkala',
                'description' => 'Informasi yang wajib disediakan dan diumumkan secara berkala',
                'color' => '#3b82f6',
                'order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Informasi Serta Merta',
                'slug' => 'serta-merta',
                'description' => 'Informasi yang dapat mengancam hajat hidup orang banyak dan ketertiban umum',
                'color' => '#ef4444',
                'order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Informasi Setiap Saat',
                'slug' => 'setiap-saat',
                'description' => 'Informasi yang wajib tersedia setiap saat',
                'color' => '#10b981',
                'order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Informasi Dikecualikan',
                'slug' => 'dikecualikan',
                'description' => 'Informasi yang rahasia sesuai undang-undang, kepatutan, dan kepentingan umum',
                'color' => '#f59e0b',
                'order' => 4,
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            PpidCategory::create($category);
        }
    }
}