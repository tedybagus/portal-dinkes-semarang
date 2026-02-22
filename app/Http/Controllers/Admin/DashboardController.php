<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Models\Department;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_articles' => Article::count(),
            'pending_articles' => Article::where('status', 'pending')->count(),
            'approved_articles' => Article::where('status', 'approved')->count(),
            'published_articles' => Article::where('status', 'published')->count(),
            'rejected_articles' => Article::where('status', 'rejected')->count(),
            'total_categories' => Category::count(),
            'total_departments' => Department::count(),
        ];

        $recent_articles = Article::with(['author', 'category'])
            ->latest()
            ->take(10)
            ->get();

        $pending_users = User::where('is_active', false)->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_articles', 'pending_users'));
    }
}
