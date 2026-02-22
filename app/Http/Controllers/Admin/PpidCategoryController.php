<?php

namespace App\Http\Controllers\Admin;

use App\Models\PpidCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PpidCategoryController extends Controller
{
    public function index()
    {
        $categories = PpidCategory::withCount('informations')->ordered()->get();
        return view('admin.ppid.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.ppid.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        PpidCategory::create($validated);

        return redirect()->route('admin.ppid-categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $category = PpidCategory::findOrFail($id);
        return view('admin.ppid.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = PpidCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $category->update($validated);

        return redirect()->route('admin.ppid-categories.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $category = PpidCategory::findOrFail($id);

        if ($category->informations()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki informasi');
        }

        $category->delete();

        return redirect()->route('admin.ppid-categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
