<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('creator')
            ->ordered()
            ->paginate(15);

        $stats = [
            'total'  => Announcement::count(),
            'active' => Announcement::active()->count(),
            'pinned' => Announcement::pinned()->count(),
        ];

        return view('admin.announcements.index', compact('announcements', 'stats'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'is_active'  => 'boolean',
            'is_pinned'  => 'boolean',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file'       => 'nullable|file|max:10240', // 10MB
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('announcements/images', 'public');
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('announcements/files', 'public');
            
            $validated['file_path'] = $path;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getClientOriginalExtension();
            $validated['file_size'] = $file->getSize();
        }

        $validated['created_by'] = auth()->id();

        Announcement::create($validated);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.form', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'required|string',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'is_active'  => 'boolean',
            'is_pinned'  => 'boolean',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file'       => 'nullable|file|max:10240',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }
            $validated['image'] = $request->file('image')->store('announcements/images', 'public');
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($announcement->file_path) {
                Storage::disk('public')->delete($announcement->file_path);
            }
            
            $file = $request->file('file');
            $path = $file->store('announcements/files', 'public');
            
            $validated['file_path'] = $path;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getClientOriginalExtension();
            $validated['file_size'] = $file->getSize();
        }

        // Handle remove flags
        if ($request->has('remove_image') && $request->remove_image) {
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }
            $validated['image'] = null;
        }

        if ($request->has('remove_file') && $request->remove_file) {
            if ($announcement->file_path) {
                Storage::disk('public')->delete($announcement->file_path);
            }
            $validated['file_path'] = null;
            $validated['file_name'] = null;
            $validated['file_type'] = null;
            $validated['file_size'] = null;
        }

        $announcement->update($validated);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy(Announcement $announcement)
    {
        // Delete files
        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }
        if ($announcement->file_path) {
            Storage::disk('public')->delete($announcement->file_path);
        }

        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus!');
    }

    public function toggle(Announcement $announcement)
    {
        $announcement->update(['is_active' => !$announcement->is_active]);

        return back()->with('success', 'Status pengumuman berhasil diubah!');
    }

    public function togglePin(Announcement $announcement)
    {
        $announcement->update(['is_pinned' => !$announcement->is_pinned]);

        return back()->with('success', 'Pin status berhasil diubah!');
    }
}
