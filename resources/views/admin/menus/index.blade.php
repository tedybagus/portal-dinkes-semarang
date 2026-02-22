@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Kelola Menu</h2>
                <p class="mt-1 text-sm text-gray-500">Kelola menu navigasi untuk setiap role</p>
            </div>
            <a href="{{ route('admin.menus.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md font-medium">
                <i class="fas fa-plus mr-2"></i> Tambah Menu
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
            <div class="flex">
                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
            <div class="flex">
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="ml-3 text-sm text-red-700">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($menus as $menu)
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                        <!-- Parent Menu -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    @if($menu->icon)
                                    <div class="h-10 w-10 rounded-lg bg-white shadow-sm flex items-center justify-center text-blue-600">
                                        <i class="{{ $menu->icon }}"></i>
                                    </div>
                                    @endif
                                    
                                    <div>
                                        <div class="flex items-center gap-3">
                                            <h3 class="font-semibold text-lg text-gray-900">{{ $menu->name }}</h3>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $menu->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $menu->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                                {{ ucwords(str_replace('_', ' ', $menu->role_slug)) }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center gap-4 mt-1 text-sm text-gray-600">
                                            @if($menu->route_name)
                                            <span><i class="fas fa-link mr-1"></i> {{ $menu->route_name }}</span>
                                            @endif
                                            <span><i class="fas fa-sort-numeric-up mr-1"></i> Urutan: {{ $menu->sort_order }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('admin.menus.edit', $menu) }}" class="px-3 py-2 bg-white text-indigo-600 rounded-lg hover:bg-indigo-50 transition text-sm font-medium border border-indigo-200">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <button 
                                        type="button"
                                        onclick="openDeleteModal({{ $menu->id }}, '{{ addslashes($menu->name) }}')"
                                        class="px-3 py-2 bg-white text-red-600 rounded-lg hover:bg-red-50 transition text-sm font-medium border border-red-200"
                                    >
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Sub Menus -->
                        @if($menu->children->count() > 0)
                        <div class="bg-white px-6 py-3 space-y-2">
                            @foreach($menu->children as $child)
                            <div class="flex items-center justify-between bg-gray-50 px-4 py-3 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-arrow-right text-gray-400"></i>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium text-gray-900">{{ $child->name }}</span>
                                            <span class="px-2 py-0.5 text-xs rounded-full {{ $child->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $child->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </div>
                                        @if($child->route_name)
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            <i class="fas fa-link mr-1"></i> {{ $child->route_name }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.menus.edit', $child) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button 
                                        type="button"
                                        onclick="openDeleteModal({{ $child->id }}, '{{ addslashes($child->name) }}')"
                                        class="text-red-600 hover:text-red-900 text-sm ml-3"
                                    >
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-bars text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada menu</p>
                        <p class="text-sm text-gray-400 mt-1">Tambahkan menu pertama Anda</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full">
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                        <i class="fas fa-trash text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Hapus Menu</h3>
                </div>
                <button 
                    type="button"
                    onclick="closeDeleteModal()"
                    class="text-white hover:text-red-100 transition"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="p-6">
                <div class="flex justify-center mb-4">
                    <div class="h-16 w-16 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                    </div>
                </div>

                <div class="text-center mb-6">
                    <p class="text-lg font-semibold text-gray-900 mb-2">Hapus menu ini?</p>
                    <p class="text-sm text-gray-600 mb-4" id="deleteMenuName"></p>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-left">
                        <p class="text-sm text-red-800">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <strong>Peringatan:</strong> Menu akan dihapus permanen dan tidak dapat dikembalikan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 rounded-b-2xl flex items-center justify-end gap-3">
                <button 
                    type="button"
                    onclick="closeDeleteModal()"
                    class="px-6 py-2.5 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium"
                >
                    <i class="fas fa-times mr-2"></i> Batal
                </button>
                <button 
                    type="submit" 
                    class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium shadow-lg"
                >
                    <i class="fas fa-trash mr-2"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDeleteModal(menuId, menuName) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const nameElement = document.getElementById('deleteMenuName');
        
        form.action = `/admin/menus/${menuId}`;
        nameElement.textContent = `"${menuName}"`;
        
        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });

    document.getElementById('deleteModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection