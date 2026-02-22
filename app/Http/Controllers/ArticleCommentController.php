<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\ArticleComment;
use Doctrine\DBAL\Logging\Middleware;
use Illuminate\Support\Facades\Validator;

class ArticleCommentController extends Controller
{
   // Rate limiting (tambahkan di constructor)
        // public function __construct()
        // {
            
        //     $this->middleware('throttle:3,10')->only('store'); // 3 komentar per 10 menit
        // }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   /**
     * Store komentar baru dari publik
     */
    public function store(Request $request, $articleId)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'comment' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 100 karakter',
            'comment.required' => 'Komentar wajib diisi',
            'comment.min' => 'Komentar minimal 10 karakter',
            'comment.max' => 'Komentar maksimal 1000 karakter',
            'rating.required' => 'Rating wajib dipilih',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi');
        }

        // Cek apakah artikel ada
        $article = Article::findOrFail($articleId);

        // Simpan komentar
        $comment = ArticleComment::create([
            'article_id' => $articleId,
            'name' => $request->name,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Terima kasih! Komentar Anda telah dikirim dan menunggu moderasi.');
    }

    /**
     * Get approved comments untuk artikel tertentu
     */
    public function getApprovedComments($articleId)
    {
        $comments = ArticleComment::where('article_id', $articleId)
            ->approved()
            ->latest()
            ->get();

        return response()->json($comments);
    }
}
