<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Http\Controllers\Controller;

class AnnouncementPublicController extends Controller
{
    public function index()
    {
        $announcements = Announcement::active()
            ->ordered()
            ->paginate(12);

        $pinnedAnnouncements = Announcement::active()
            ->pinned()
            ->ordered()
            ->take(3)
            ->get();

        return view('announcements.index', compact('announcements', 'pinnedAnnouncements'));
    }

    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Only show if active
        if (!$announcement->isActive()) {
            abort(404);
        }

        // Increment view count
        $announcement->incrementView();

        // Related announcements
        $relatedAnnouncements = Announcement::active()
            ->where('id', '!=', $announcement->id)
            ->ordered()
            ->take(3)
            ->get();

        return view('announcements.show', compact('announcement', 'relatedAnnouncements'));
    }
}