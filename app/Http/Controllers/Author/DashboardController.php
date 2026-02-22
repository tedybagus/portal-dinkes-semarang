<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_articles' => Article::where('author_id', auth()->id())->count(),
            'pending_articles' => Article::where('author_id', auth()->id())->where('status', 'pending')->count(),
            'approved_articles' => Article::where('author_id', auth()->id())->where('status', 'approved')->count(),
            'published_articles' => Article::where('author_id', auth()->id())->where('status', 'published')->count(),
            'rejected_articles' => Article::where('author_id', auth()->id())->where('status', 'rejected')->count(),
        ];

        $recent_articles = Article::where('author_id', auth()->id())
            ->with(['category', 'reviewer'])
            ->latest()
            ->take(5)
            ->get();

        return view('author.dashboard', compact('stats', 'recent_articles'));
    }
}
