<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleComment;
use App\Models\CategoryArticle;

class PublicArticleController extends Controller
{
    /**
     * Tampilkan halaman publik artikel dengan filter
     */
    public function index(Request $request)
    {
        // Query dasar - hanya artikel yang published
        $query = Article::with('category')
            ->where('status', 'published');

        // Filter berdasarkan search (judul atau konten)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('konten', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // // Filter berdasarkan tag
        // if ($request->filled('tag')) {
        //     $query->where('tags', 'like', "%{$request->tag}%");
        // }

        // Urutkan berdasarkan tanggal terbaru
        $query->orderBy('article_date', 'desc');

        // Pagination
        $articles = $query->paginate(9)->withQueryString();

        // Ambil semua kategori dengan jumlah artikel
        $categories = Category::withCount([
            'articles' => function($query) {
                $query->where('status', 'published');
            }
        ])->orderBy('name', 'asc')->get();

        // Total semua artikel published
        $totalArticles = Article::where('status', 'published')->count();

        // Artikel unggulan (featured) - artikel terbaru atau yang paling banyak dilihat
        $featuredArticle = Article::where('status', 'published')
            ->orderBy('views', 'desc')
            ->orderBy('article_date', 'desc')
            ->first();

        return view('articles.public', compact(
            'articles', 
            'categories', 
            'totalArticles',
            'featuredArticle'
        ));
    }

    /**
     * Tampilkan detail artikel untuk publik
     */
public function show($id){
        // Ambil artikel dengan kategori
    $article = Article::with('category')
        ->where('status', 'published')
        ->findOrFail($id);

    // Ambil komentar yang sudah approved
    $approvedComments = ArticleComment::where('article_id', $id)
        ->approved()
        ->latest()
        ->get();

    // Artikel terkait
    $relatedArticles = Article::where('category_id', $article->category_id)
        ->where('id', '!=', $article->id)
        ->where('status', 'published')
        ->orderBy('article_date', 'desc')
        ->limit(5)
        ->get();

    // Artikel populer
    $popularArticles = Article::where('status', 'published')
        ->orderBy('views', 'desc')
        ->limit(5)
        ->get();

    // Semua kategori
    $categories = Category::withCount([
        'articles' => function($query) {
            $query->where('status', 'published');
        }
    ])->get();

    return view('articles.detail', compact(
        'article',
        'approvedComments', // Tambahkan ini
        'relatedArticles',
        'popularArticles',
        'categories'
    ));
}

    /**
     * Update view count ketika artikel dibuka
     */
    public function updateViews($id)
    {
        $article = Article::findOrFail($id);
        $article->increment('views');
        
        return response()->json(['success' => true]);
    }
}