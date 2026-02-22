<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminReviewController extends Controller
{
    public function index(Request $request){
         $query = Review::query()->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reviewer_name', 'like', "%{$search}%")
                  ->orWhere('review_text', 'like', "%{$search}%");
            });
        }

        $reviews = $query->paginate(15);

        $stats = [
            'total' => Review::count(),
            'pending' => Review::pending()->count(),
            'approved' => Review::approved()->count(),
            'rejected' => Review::where('status', 'rejected')->count(),
            'average_rating' => round(Review::averageRating(), 1),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->approve(auth()->user()->name ?? 'Admin');

        return redirect()->back()
            ->with('success', 'Review berhasil disetujui!');
    }

    /**
     * Reject review
     */
    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->reject();

        return redirect()->back()
            ->with('success', 'Review ditolak.');
    }

    /**
     * Delete review
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Delete photo if exists
        if ($review->reviewer_photo) {
            Storage::disk('public')->delete($review->reviewer_photo);
        }

        $review->delete();

        return redirect()->back()
            ->with('success', 'Review berhasil dihapus!');
    }

    /**
     * Bulk approve
     */
    public function bulkApprove(Request $request)
    {
        $ids = $request->ids ?? [];
        
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Pilih review terlebih dahulu');
        }

        Review::whereIn('id', $ids)->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->user()->name ?? 'Admin'
        ]);

        return redirect()->back()
            ->with('success', count($ids) . ' review berhasil disetujui!');
    }

    /**
     * Bulk delete
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids ?? [];
        
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Pilih review terlebih dahulu');
        }

        $reviews = Review::whereIn('id', $ids)->get();
        
        foreach ($reviews as $review) {
            if ($review->reviewer_photo) {
                Storage::disk('public')->delete($review->reviewer_photo);
            }
        }

        Review::whereIn('id', $ids)->delete();

        return redirect()->back()
            ->with('success', count($ids) . ' review berhasil dihapus!');
    }
}
