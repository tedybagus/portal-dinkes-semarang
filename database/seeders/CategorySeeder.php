<?php

namespace Database\Seeders;


use App\Models\Category;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Berita Utama',
                'slug' => 'berita-utama',
                'description' => 'Berita utama dan terkini'
            ],
            [
                'name' => 'Politik',
                'slug' => 'politik',
                'description' => 'Berita seputar politik'
            ],
            [
                'name' => 'Ekonomi',
                'slug' => 'ekonomi',
                'description' => 'Berita ekonomi dan bisnis'
            ],
            [
                'name' => 'Teknologi',
                'slug' => 'teknologi',
                'description' => 'Berita teknologi dan inovasi'
            ],
            [
                'name' => 'Olahraga',
                'slug' => 'olahraga',
                'description' => 'Berita olahraga dan pertandingan'
            ],
            [
                'name' => 'Kesehatan',
                'slug' => 'kesehatan',
                'description' => 'Berita kesehatan dan gaya hidup'
            ],
            [
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'description' => 'Berita pendidikan dan pembelajaran'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        echo "✅ Categories created successfully!\n";
    }
}
