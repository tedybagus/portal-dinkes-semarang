<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    //
  }

  public function boot(): void
  {
    View::composer('layouts.navigation', function ($view) {
      $menus = [];

      if (auth()->check()) {
        $roleSlug = auth()->user()->role->slug;

        $menus = Menu::active()
          ->forRole($roleSlug)
          ->parent()
          ->with('children')
          ->orderBy('sort_order')
          ->get();
      }

      $view->with('menus', $menus);
    });
  }
}
