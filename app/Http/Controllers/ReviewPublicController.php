<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReviewPublicController extends Controller
{
    public function index(Request $request)
    {
        // Query reviews
        $query = Review::with('reviewServices')
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc');

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by service
        if ($request->filled('service')) {
            $query->whereHas('reviewServices', function($q) use ($request) {
                $q->where('service_type', $request->service);
            });
        }

        $reviews = $query->paginate(12)->appends($request->query());

        // ═══════════════════════════════════════════════════════════
        // STATISTICS - WITH DEBUG
        // ═══════════════════════════════════════════════════════════
        
        // Total reviews
        $totalReviews = Review::where('status', 'approved')->count();
        
        // Average rating
        $averageRating = Review::where('status', 'approved')->avg('rating') ?: 0;
        $averageRating = min(max($averageRating, 0), 5);
        
        // ✅ Count per rating - DETAILED DEBUG
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = Review::where('status', 'approved')
                ->where('rating', $i)
                ->count();
            
            $ratingDistribution[$i] = $count;
            
            // Debug log
            Log::info("Rating $i count: $count");
        }

        // Calculate percentages
        $ratingPercentages = [];
        foreach ($ratingDistribution as $rating => $count) {
            $percentage = $totalReviews > 0 
                ? round(($count / $totalReviews) * 100, 1) 
                : 0;
            $ratingPercentages[$rating] = $percentage;
            
            // Debug log
            Log::info("Rating $rating percentage: $percentage%");
        }

        // Get service types
        $serviceTypes = Review::LAYANAN_TYPES;

        // ═══════════════════════════════════════════════════════════
        // COMPREHENSIVE DEBUG LOG
        // ═══════════════════════════════════════════════════════════
        Log::info('=== REVIEW STATISTICS DEBUG ===', [
            'total_reviews'        => $totalReviews,
            'average_rating'       => $averageRating,
            'rating_distribution'  => $ratingDistribution,
            'rating_percentages'   => $ratingPercentages,
        ]);

        // Additional: Check raw data
        $rawCounts = DB::table('reviews')
            ->select('rating', DB::raw('count(*) as count'))
            ->where('status', 'approved')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();
        
        Log::info('Raw rating counts from DB:', $rawCounts->toArray());

        // ═══════════════════════════════════════════════════════════
        // RETURN VIEW
        // ═══════════════════════════════════════════════════════════
        return view('public.reviews.index', compact(
            'reviews',
            'totalReviews',
            'averageRating',
            'ratingDistribution',
            'ratingPercentages',
            'serviceTypes'
        ));
    }

    public function create()
    {
        $serviceTypes = Review::LAYANAN_TYPES;
        return view('public.reviews.create', compact('serviceTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'email'         => 'required|email',
            'telepon'       => 'nullable|string|max:20',
            'rating'        => 'required|integer|min:1|max:5',
            'review_text'   => 'required|string|min:10',
            'services'      => 'required|array|min:1',
            'services.*'    => 'in:' . implode(',', array_keys(Review::LAYANAN_TYPES)),
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('reviews', 'public');
        }

        $validated['ip_address'] = $request->ip();
        $validated['status'] = 'pending';

        $review = Review::create($validated);

        foreach ($request->services as $service) {
            $review->reviewServices()->create(['service_type' => $service]);
        }

        $review->update([
            'tracking_code' => 'REV-' . strtoupper(substr(md5($review->id . time()), 0, 8)),
        ]);

        return redirect()->route('public.reviews.success', ['code' => $review->tracking_code]);
    }

    public function success($code)
    {
        $review = Review::where('tracking_code', $code)->firstOrFail();
        return view('public.reviews.success', compact('review'));
    }
}




