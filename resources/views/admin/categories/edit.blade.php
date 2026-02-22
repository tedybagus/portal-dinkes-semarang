@extends('layouts.app')

@section('title', 'Edit Kategori Berita')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Edit Kategori Berita</h1>
        <p class="text-gray-500 text-sm">Perbarui data kategori berita</p>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-xl shadow">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-t-xl">
            <h2 class="text-white font-semibold flex items-center gap-2">
                ✏️ Form Edit Kategori
            </h2>
        </div>

        <form action="{{ route('admin.categories.update', $category->id) }}"
              method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name"
                       value="{{ old('name', $category->name) }}"
                       class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Status
                </label>
                <select name="status"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="1" {{ $category->status ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$category->status ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            {{-- Action --}}
            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.categories.index') }}"
                   class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
