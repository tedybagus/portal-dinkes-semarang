<?php

namespace App\Http\Controllers\Author;

use Log;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('author_id', auth()->id())
            ->with(['category', 'reviewer', 'department'])
            ->latest()
            ->paginate(10);

        return view('author.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('author.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
            'article_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Judul artikel harus diisi',
            'content.required' => 'Konten artikel harus diisi',
            'content.min' => 'Konten artikel minimal 10 karakter',
            'category_id.required' => 'Kategori harus dipilih',
            'category_id.exists' => 'Kategori tidak valid',
            'article_date.required' => 'Tanggal artikel harus diisi',
            'article_date.date' => 'Format tanggal tidak valid',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Gambar harus berformat: jpeg, png, jpg, gif',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            $validated['author_id'] = auth()->id();
            $validated['department_id'] = auth()->user()->department_id;
            $validated['slug'] = Str::slug($validated['title']);
            $validated['status'] = 'pending';

            // Upload image
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('articles', 'public');
            }

            Article::create($validated);

            return redirect()->route('author.articles.index')
                ->with('success', 'Artikel berhasil dibuat dan dikirim ke reviewer ' . auth()->user()->department->name . ' untuk direview.');
        } catch (\Exception $e) {
            Log::error('Error creating article: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan artikel. Silakan coba lagi.');
        }
    }

    public function edit(Article $article)
    {
        // Pastikan hanya author yang membuat yang bisa edit
        if ($article->author_id !== auth()->id()) {
            abort(403);
        }

        // Hanya bisa edit jika status pending atau rejected
        if (!in_array($article->status, ['pending', 'rejected'])) {
            return redirect()->route('author.articles.index')
                ->with('error', 'Artikel tidak dapat diedit.');
        }

        $categories = Category::all();
        return view('author.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        if ($article->author_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'article_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['status'] = 'pending'; // Reset ke pending setelah edit

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($validated);

        return redirect()->route('author.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->author_id !== auth()->id()) {
            abort(403);
        }

        if ($article->status === 'published') {
            return redirect()->route('author.articles.index')
                ->with('error', 'Artikel yang sudah dipublikasi tidak dapat dihapus.');
        }

        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('author.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
