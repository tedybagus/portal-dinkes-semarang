@php
    $role = auth()->user()?->role?->slug;
    $route = request()->route()->getName();
    // Ambil menu dari database
    $menus = \App\Models\Menu::where('role_slug', $role)
                ->where('is_active', true)
                ->whereNull('parent_id')
                ->with(['children' => function($query) {
                    $query->where('is_active', true)->orderBy('sort_order');
                }])
                ->orderBy('sort_order')
                ->get();
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    {{-- BRAND --}}
    <a href="{{ route('dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-bold">
            <i class="fas fa-newspaper mr-1"></i> NEWS APP
        </span>
    </a>

    <div class="sidebar">

        {{-- USER --}}
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fas fa-user-circle fa-2x text-light"></i>
            </div>
            <div class="info">
                <span class="d-block text-white">
                    {{ auth()->user()->name }}
                </span>
                <small class="text-muted">
                    {{ strtoupper(str_replace('_',' ', $role)) }}
                </small>
            </div>
        </div>

        {{-- MENU DINAMIS --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" 
                data-widget="treeview" 
                data-accordion="false">

                @foreach ($menus as $menu)
                    @if ($menu->children->isEmpty())
                        {{-- Menu tanpa submenu --}}
                        <li class="nav-item">
                            <a href="{{ $menu->route_name ? route($menu->route_name) : '#' }}" 
                               class="nav-link {{ str_contains($route, $menu->route_name) ? 'active' : '' }}">
                                <i class="nav-icon {{ $menu->icon ?? 'fas fa-circle' }}"></i>
                                <p>{{ $menu->name }}</p>
                            </a>
                        </li>
                    @else
                        {{-- Menu dengan submenu --}}
                        <li class="nav-item {{ collect($menu->children)->pluck('route_name')->contains(fn($r) => str_contains($route, $r)) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ collect($menu->children)->pluck('route_name')->contains(fn($r) => str_contains($route, $r)) ? 'active' : '' }}">
                                <i class="nav-icon {{ $menu->icon ?? 'fas fa-folder' }}"></i>
                                <p>
                                    {{ $menu->name }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach ($menu->children as $child)
                                    <li class="nav-item">
                                        <a href="{{ $child->route_name ? route($child->route_name) : '#' }}" 
                                           class="nav-link {{ str_contains($route, $child->route_name) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ $child->name }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach

            </ul>
        </nav>
    </div>
</aside>