<div class="bg-white rounded-xl border shadow-sm p-6 space-y-6">

    {{-- Nama --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Nama Kategori
        </label>
        <input type="text"
               name="name"
               value="{{ old('name', $category->name ?? '') }}"
               required
               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
               placeholder="Contoh: Kesehatan">
    </div>

    {{-- Status --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Status
        </label>
        <select name="is_active"
                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            <option value="1" @selected(old('is_active', $category->is_active ?? 1) == 1)>
                Aktif
            </option>
            <option value="0" @selected(old('is_active', $category->is_active ?? 1) == 0)>
                Nonaktif
            </option>
        </select>
    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-2 pt-4 border-t">
        <a href="{{ route('admin.categories.index') }}"
           class="px-4 py-2 text-sm rounded-lg border text-gray-700 hover:bg-gray-50">
            Batal
        </a>

        <button type="submit"
                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
            Simpan
        </button>
    </div>
</div>
