<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Image::with('uploader');

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Order by order then latest
        $images = $query->ordered()->paginate(12)->appends($request->query());

        return view('admin.images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'alt_text' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:5120', // 5MB = 5120 KB
            'type' => 'required|in:gallery,hero,banner',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'title.required' => 'Judul gambar harus diisi',
            'image.required' => 'Gambar harus diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus: JPEG, JPG, PNG, GIF, atau WEBP',
            'image.max' => 'Ukuran gambar maksimal 5MB',
            'type.required' => 'Tipe gambar harus dipilih',
        ]);

        try {
            // Upload image with unique name
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['title']) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('gallery', $filename, 'public');

            // Create image record
            Image::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'alt_text' => $validated['alt_text'] ?? $validated['title'],
                'image_path' => $imagePath,
                'type' => $validated['type'],
                'order' => $validated['order'] ?? 0,
                'is_active' => $request->has('is_active'),
                'uploaded_by' => auth()->id(),
            ]);

            return redirect()->route('admin.images.index')
                            ->with('success', 'Gambar berhasil diupload');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        $image->load('uploader');
        
        return view('admin.images.show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        return view('admin.images.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'alt_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120', // 5MB
            'type' => 'required|in:gallery,hero,banner',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'title.required' => 'Judul gambar harus diisi',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus: JPEG, JPG, PNG, GIF, atau WEBP',
            'image.max' => 'Ukuran gambar maksimal 5MB',
            'type.required' => 'Tipe gambar harus dipilih',
        ]);

        try {
            $data = [
                'title' => $validated['title'],
                'description' => $validated['description'],
                'alt_text' => $validated['alt_text'] ?? $validated['title'],
                'type' => $validated['type'],
                'order' => $validated['order'] ?? 0,
                'is_active' => $request->has('is_active'),
            ];

            // Upload new image if provided
            if ($request->hasFile('image')) {
                // Delete old image
                if ($image->image_path) {
                    Storage::disk('public')->delete($image->image_path);
                }

                // Upload new image
                $file = $request->file('image');
                $filename = time() . '_' . Str::slug($validated['title']) . '.' . $file->getClientOriginalExtension();
                $data['image_path'] = $file->storeAs('gallery', $filename, 'public');
            }

            $image->update($data);

            return redirect()->route('admin.images.index')
                            ->with('success', 'Gambar berhasil diupdate');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate gambar: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        try {
            // Delete image file
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }

            $image->delete();

            return redirect()->route('admin.images.index')
                            ->with('success', 'Gambar berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->route('admin.images.index')
                ->with('error', 'Gagal menghapus gambar: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete images
     */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|string',
            ]);

            $ids = explode(',', $request->ids);
            $images = Image::whereIn('id', $ids)->get();

            if ($images->isEmpty()) {
                return redirect()->route('admin.images.index')
                    ->with('error', 'Tidak ada gambar yang dipilih');
            }

            // Delete all images
            foreach ($images as $image) {
                if ($image->image_path) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }

            return redirect()->route('admin.images.index')
                ->with('success', "Berhasil menghapus {$images->count()} gambar");

        } catch (\Exception $e) {
            return redirect()->route('admin.images.index')
                ->with('error', 'Gagal menghapus gambar: ' . $e->getMessage());
        }
    }
}