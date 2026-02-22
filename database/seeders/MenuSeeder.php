<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua menu lama
        Menu::truncate();

        // Super Admin Menus
        Menu::create([
            'name' => 'Dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'route_name' => 'admin.dashboard',
            'role_slug' => 'super_admin',
            'parent_id' => null,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $manajemenUser = Menu::create([
            'name' => 'Manajemen User',
            'icon' => 'fas fa-users',
            'route_name' => null,
            'role_slug' => 'super_admin',
            'parent_id' => null,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Menu::create([
            'name' => 'Data User',
            'icon' => null,
            'route_name' => 'admin.users.index',
            'role_slug' => 'super_admin',
            'parent_id' => $manajemenUser->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $berita = Menu::create([
            'name' => 'Berita',
            'icon' => 'fas fa-newspaper',
            'route_name' => null,
            'role_slug' => 'super_admin',
            'parent_id' => null,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        Menu::create([
            'name' => 'Kategori',
            'icon' => null,
            'route_name' => 'admin.categories.index',
            'role_slug' => 'super_admin',
            'parent_id' => $berita->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'name' => 'Artikel',
            'icon' => null,
            'route_name' => 'admin.articles.index',
            'role_slug' => 'super_admin',
            'parent_id' => $berita->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Menu::create([
            'name' => 'Pengumuman',
            'icon' => 'fas fa-bullhorn',
            'route_name' => 'admin.announcements.index',
            'role_slug' => 'super_admin',
            'parent_id' => null,
            'sort_order' => 4,
            'is_active' => true,
        ]);

        Menu::create([
            'name' => 'Menu Website',
            'icon' => 'fas fa-bars',
            'route_name' => 'admin.menus.index',
            'role_slug' => 'super_admin',
            'parent_id' => null,
            'sort_order' => 5,
            'is_active' => true,
        ]);
        Menu::create([
            'name' => 'Profil Kesehatan',
            'icon' => 'fas fa-book',
            'route_name' => 'admin.health-profiles.index',
            'role_slug' => 'super_admin',
            'parent_id' => null,
            'sort_order' => 6,
            'is_active' => true,
        ]);
        // Setelah menu Profil Kesehatan, tambahkan:
            $fasyankes = Menu::create([
                'name' => 'Fasyankes',
                'icon' => 'fas fa-hospital',
                'route_name' => null,
                'role_slug' => 'super_admin',
                'parent_id' => null,
                'sort_order' => 7,
                'is_active' => true,
        ]);

            Menu::create([
                'name' => 'Data Fasyankes',
                'icon' => null,
                'route_name' => 'admin.fasyankes.index',
                'role_slug' => 'super_admin',
                'parent_id' => $fasyankes->id,
                'sort_order' => 1,
                'is_active' => true,
        ]);

            Menu::create([
                'name' => 'Peta Fasyankes',
                'icon' => null,
                'route_name' => 'admin.fasyankes.maps',
                'role_slug' => 'super_admin',
                'parent_id' => $fasyankes->id,
                'sort_order' => 2,
                'is_active' => true,
        ]);

            Menu::create([
                'name' => 'Kategori Fasyankes',
                'icon' => null,
                'route_name' => 'admin.kliniks.index',
                'role_slug' => 'super_admin',
                'parent_id' => $fasyankes->id,
                'sort_order' => 3,
                'is_active' => true,
            ]);

        // Reviewer Menus
        Menu::create([
            'name' => 'Dashboard',
            'icon' => 'fas fa-home',
            'route_name' => 'reviewer.dashboard',
            'role_slug' => 'reviewer',
            'parent_id' => null,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'name' => 'Review Artikel',
            'icon' => 'fas fa-check-circle',
            'route_name' => 'reviewer.articles.index',
            'role_slug' => 'reviewer',
            'parent_id' => null,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // Author Menus
        Menu::create([
            'name' => 'Dashboard',
            'icon' => 'fas fa-home',
            'route_name' => 'author.dashboard',
            'role_slug' => 'author',
            'parent_id' => null,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'name' => 'Artikel Saya',
            'icon' => 'fas fa-pen',
            'route_name' => 'author.articles.index',
            'role_slug' => 'author',
            'parent_id' => null,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        echo "✅ Menus created successfully!\n";
    }
}
