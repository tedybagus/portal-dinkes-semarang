<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Article;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_review' => Article::where('department_id', auth()->user()->department_id)
                ->where('status', 'pending')
                ->count(),
            'reviewed_articles' => Article::where('reviewer_id', auth()->id())->count(),
            'approved_articles' => Article::where('reviewer_id', auth()->id())
                ->where('status', 'approved')
                ->count(),
            'rejected_articles' => Article::where('reviewer_id', auth()->id())
                ->where('status', 'rejected')
                ->count(),
        ];

        $pending_articles = Article::where('department_id', auth()->user()->department_id)
            ->where('status', 'pending')
            ->with(['author', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('reviewer.dashboard', compact('stats', 'pending_articles'));
    }
}
