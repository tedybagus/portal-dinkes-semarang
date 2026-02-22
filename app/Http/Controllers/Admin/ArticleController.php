<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['category', 'author', 'reviewer', 'department']);
        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by department (optional)
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        // Order by latest
        $query->latest();

        // Paginate with query string
        $articles = $query->paginate(10)->appends($request->query());

        // Get categories for filter dropdown
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $departments = Department::all();
        $authors = User::whereHas('role', function ($q) {
            $q->where('slug', 'author');
        })->get();

        return view('admin.articles.create', compact('categories', 'departments', 'authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
            'department_id' => 'required|exists:departments,id',
            'article_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:pending,approved,published',
        ]);

        $validated['author_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    public function show(Article $article)
    {
        $article->load(['category', 'author', 'reviewer', 'department']);

        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        $departments = Department::all();
        $authors = User::whereHas('role', function ($q) {
            $q->where('slug', 'author');
        })->get();

        return view('admin.articles.edit', compact('article', 'categories', 'departments', 'authors'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
            'department_id' => 'required|exists:departments,id',
            'article_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:pending,approved,rejected,published',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        // Update published_at jika status berubah ke published
        if ($validated['status'] === 'published' && $article->status !== 'published') {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    public function publish(Article $article)
    {
        if ($article->status !== 'approved') {
            return redirect()->back()
                ->with('error', 'Hanya artikel yang sudah disetujui yang bisa dipublikasi.');
        }

        $article->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel "' . $article->title . '" berhasil dipublikasikan.');
    }
     public function unpublish(Article $article)
   {
       $article->update(['status' => 'draft']);
       
       return redirect()->back()->with('success', 'Artikel berhasil di-unpublish');
   }
}
