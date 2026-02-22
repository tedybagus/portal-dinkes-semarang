@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.menus.update', $menu) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Menu <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name', $menu->name) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror" 
                            required
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon & Route -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">
                                Icon (Font Awesome)
                            </label>
                            <input 
                                type="text" 
                                name="icon" 
                                id="icon" 
                                value="{{ old('icon', $menu->icon) }}" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                placeholder="fas fa-home"
                            >
                            <p class="mt-1 text-xs text-gray-500">
                                <i class="fas fa-info-circle"></i> Lihat icon di <a href="https://fontawesome.com/icons" target="_blank" class="text-blue-600 hover:underline">fontawesome.com</a>
                            </p>
                        </div>

                        <div>
                            <label for="route_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Route Name
                            </label>
                            <input 
                                type="text" 
                                name="route_name" 
                                id="route_name" 
                                value="{{ old('route_name', $menu->route_name) }}" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                placeholder="admin.dashboard"
                            >
                            <p class="mt-1 text-xs text-gray-500">
                                <i class="fas fa-info-circle"></i> Kosongkan jika menu memiliki sub-menu
                            </p>
                        </div>
                    </div>

                    <!-- Role & Parent Menu -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="role_slug" class="block text-sm font-semibold text-gray-700 mb-2">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="role_slug" 
                                id="role_slug" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('role_slug') border-red-500 @enderror" 
                                required
                            >
                                <option value="">Pilih Role</option>
                                <option value="super_admin" {{ old('role_slug', $menu->role_slug) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="author" {{ old('role_slug', $menu->role_slug) == 'author' ? 'selected' : '' }}>Author</option>
                                <option value="reviewer" {{ old('role_slug', $menu->role_slug) == 'reviewer' ? 'selected' : '' }}>Reviewer</option>
                            </select>
                            @error('role_slug')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="parent_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Parent Menu
                            </label>
                            <select 
                                name="parent_id" 
                                id="parent_id" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            >
                                <option value="">Tidak Ada (Menu Utama)</option>
                                @foreach($parentMenus as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }} ({{ ucwords(str_replace('_', ' ', $parent->role_slug)) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Sort Order & Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="sort_order" class="block text-sm font-semibold text-gray-700 mb-2">
                                Urutan <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="sort_order" 
                                id="sort_order" 
                                value="{{ old('sort_order', $menu->sort_order) }}" 
                                min="0"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('sort_order') border-red-500 @enderror" 
                                required
                            >
                            @error('sort_order')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Status
                            </label>
                            <div class="flex items-center h-12">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        name="is_active" 
                                        value="1" 
                                        {{ old('is_active', $menu->is_active) ? 'checked' : '' }}
                                        class="sr-only peer"
                                    >
                                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-700">Aktif</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end gap-4">
                        {{-- <a href="{{ route('admin.menus.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a> --}}
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition font-medium shadow-lg">
                            <i class="fas fa-save mr-2"></i> Update Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection