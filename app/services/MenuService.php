<?php

namespace App\Services;

use App\Models\Menu;

class MenuService
{
  public static function getSidebarMenus($user)
  {
    return Menu::where('is_active', true)
      ->orderBy('order')
      ->get()
      ->filter(
        fn($menu) =>
        $menu->hasRole($user->role->slug)
      );
  }
}
