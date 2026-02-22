<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        // Artikel dari department reviewer yang statusnya pending
        $articles = Article::where('department_id', auth()->user()->department_id)
            ->where('status', 'pending')
            ->with(['author', 'category'])
            ->latest()
            ->paginate(10);

        // Artikel yang sudah direview oleh reviewer ini
        $reviewedArticles = Article::where('reviewer_id', auth()->id())
            ->with(['author', 'category'])
            ->latest()
            ->paginate(10);

        return view('reviewer.articles.index', compact('articles', 'reviewedArticles'));
    }

    public function show(Article $article)
    {
        // Pastikan artikel dari department yang sama
        if ($article->department_id !== auth()->user()->department_id) {
            abort(403, 'Anda tidak memiliki akses untuk artikel ini.');
        }

        $article->load(['author', 'category', 'department']);

        return view('reviewer.articles.show', compact('article'));
    }

    public function approve(Article $article)
    {
        if ($article->department_id !== auth()->user()->department_id) {
            abort(403);
        }

        if ($article->status !== 'pending') {
            return redirect()->route('reviewer.articles.index')
                ->with('error', 'Artikel ini sudah direview sebelumnya.');
        }

        $article->update([
            'status' => 'approved',
            'reviewer_id' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()->route('reviewer.articles.index')
            ->with('success', 'Artikel "' . $article->title . '" berhasil disetujui dan siap dipublikasi oleh Super Admin.');
    }

    public function reject(Request $request, Article $article)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ], [
            'rejection_reason.required' => 'Alasan penolakan harus diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter.',
        ]);

        if ($article->department_id !== auth()->user()->department_id) {
            abort(403);
        }

        if ($article->status !== 'pending') {
            return redirect()->route('reviewer.articles.index')
                ->with('error', 'Artikel ini sudah direview sebelumnya.');
        }

        $article->update([
            'status' => 'rejected',
            'reviewer_id' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->route('reviewer.articles.index')
            ->with('success', 'Artikel ditolak dan dikembalikan ke penulis untuk diperbaiki.');
    }
}
