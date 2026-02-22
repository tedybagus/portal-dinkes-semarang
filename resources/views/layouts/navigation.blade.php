<!-- Mobile menu button -->
<div class="lg:hidden fixed top-0 left-0 right-0 z-40 flex items-center justify-between bg-white border-b border-gray-200 px-4 py-3">
    <div class="flex items-center">
        <button id="mobile-menu-button" type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <span class="ml-3 text-lg font-semibold text-gray-900">Portal Berita</span>
    </div>
    
    <!-- User Menu Mobile -->
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center text-sm focus:outline-none">
            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                 @auth
                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
            @else
                G
            @endauth
            </div>
        </button>
        
        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50">
            <div class="px-4 py-2 border-b">
                @auth
                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->role->name }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
            @else
                <!-- Menu untuk guest/user belum login -->
                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </a>
                <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-user-plus mr-2"></i> Register
                </a>
            @endauth
        </div>
    </div>
</div>

<!-- Sidebar for desktop -->
<div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center shadow-lg">
                    <i class="fas fa-newspaper text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900">Portal Berita</h1>
                    <p class="text-xs text-gray-500">{{ auth()->user()->role->name }}</p>
                </div>
            </div>
            
            <button id="sidebar-close" class="lg:hidden text-gray-500 hover:text-gray-700">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-4 overflow-y-auto">
            <ul class="space-y-1">
                @foreach($menus as $menu)
                    @if($menu->hasChildren())
                        <!-- Parent Menu with Children -->
                        <li>
                            <button 
                                onclick="toggleSubmenu({{ $menu->id }})"
                                class="sidebar-link w-full flex items-center justify-between px-3 py-2.5 text-sm text-gray-700 rounded-lg border-l-4 border-transparent group"
                            >
                                <div class="flex items-center gap-3">
                                    @if($menu->icon)
                                    <i class="{{ $menu->icon }} text-gray-400 group-hover:text-blue-600 w-5"></i>
                                    @endif
                                    <span class="font-medium">{{ $menu->name }}</span>
                                </div>
                                <svg id="arrow-{{ $menu->id }}" class="h-4 w-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <!-- Submenu -->
                            <ul id="submenu-{{ $menu->id }}" class="submenu ml-4 mt-1 space-y-1">
                                @foreach($menu->children as $child)
                                <li>
                                    <a 
                                        href="{{ $child->route_name ? route($child->route_name) : '#' }}" 
                                        class="sidebar-link flex items-center gap-3 px-3 py-2 text-sm text-gray-600 rounded-lg border-l-4 border-transparent hover:text-gray-900 {{ request()->routeIs($child->route_name . '*') ? 'active text-blue-600' : '' }}"
                                    >
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                        <span>{{ $child->name }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <!-- Single Menu -->
                        <li>
                            <a 
                                href="{{ $menu->route_name ? route($menu->route_name) : '#' }}" 
                                class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 rounded-lg border-l-4 border-transparent hover:text-gray-900 {{ request()->routeIs($menu->route_name . '*') ? 'active text-blue-600' : '' }}"
                            >
                                @if($menu->icon)
                                <i class="{{ $menu->icon }} text-gray-400 {{ request()->routeIs($menu->route_name . '*') ? 'text-blue-600' : '' }} w-5"></i>
                                @endif
                                <span class="font-medium">{{ $menu->name }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>

        <!-- User Section -->
        <div class="border-t border-gray-200 p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold shadow-md">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="submit" 
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-500 to-red-600 rounded-lg hover:from-red-600 hover:to-red-700 transition shadow-sm"
                >
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Overlay for mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden hidden"></div>

<!-- Alpine.js for dropdowns -->
<script src="//unpkg.com/alpinejs" defer></script>

<script>
    // Toggle submenu
    function toggleSubmenu(menuId) {
        const submenu = document.getElementById(`submenu-${menuId}`);
        const arrow = document.getElementById(`arrow-${menuId}`);
        
        submenu.classList.toggle('open');
        arrow.classList.toggle('rotate-180');
    }
    
    // Mobile menu
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const sidebarClose = document.getElementById('sidebar-close');
    
    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
    }
    
    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
    }
    
    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', openSidebar);
    }
    
    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeSidebar);
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }
    
    // Auto open submenu if child is active
    document.addEventListener('DOMContentLoaded', function() {
        const activeLinks = document.querySelectorAll('.sidebar-link.active');
        activeLinks.forEach(link => {
            const parentSubmenu = link.closest('.submenu');
            if (parentSubmenu) {
                const menuId = parentSubmenu.id.replace('submenu-', '');
                toggleSubmenu(menuId);
            }
        });
    });
</script>