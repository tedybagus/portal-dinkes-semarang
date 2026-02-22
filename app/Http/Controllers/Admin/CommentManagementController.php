<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentManagementController extends Controller
{
    /**
     * Tampilkan daftar semua komentar
     */
    public function index(Request $request)
    {
        $query = ArticleComment::with(['article', 'approver']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan artikel
        if ($request->filled('article_id')) {
            $query->where('article_id', $request->article_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        // Urutkan terbaru
        $comments = $query->latest()->paginate(20);

        // Hitung statistik
        $stats = [
            'total' => ArticleComment::count(),
            'pending' => ArticleComment::pending()->count(),
            'approved' => ArticleComment::approved()->count(),
            'rejected' => ArticleComment::rejected()->count(),
        ];

        return view('admin.comments.index', compact('comments', 'stats'));
    }

    /**
     * Approve komentar
     */
    public function approve($id)
    {
        $comment = ArticleComment::findOrFail($id);
        
        $comment->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Komentar berhasil disetujui dan dipublikasikan');
    }

    /**
     * Reject komentar
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $comment = ArticleComment::findOrFail($id);
        
        $comment->update([
            'status' => 'rejected',
            'approved_at' => null,
            'approved_by' => Auth::id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Komentar berhasil ditolak');
    }

    /**
     * Delete komentar
     */
    public function destroy($id)
    {
        $comment = ArticleComment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus');
    }

    /**
     * Bulk approve komentar
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:article_comments,id',
        ]);

        ArticleComment::whereIn('id', $request->comment_ids)
            ->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);

        return back()->with('success', count($request->comment_ids) . ' komentar berhasil disetujui');
    }

    /**
     * Bulk reject komentar
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:article_comments,id',
        ]);

        ArticleComment::whereIn('id', $request->comment_ids)
            ->update([
                'status' => 'rejected',
                'approved_by' => Auth::id(),
            ]);

        return back()->with('success', count($request->comment_ids) . ' komentar berhasil ditolak');
    }
}