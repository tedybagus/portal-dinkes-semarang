<?php

namespace App\Http\View\Composers;

use App\Models\Review;
use Illuminate\View\View;

class ReviewComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Get approved reviews
        $reviews = Review::approved()->latest()->get();
        
        // Get total approved reviews
        $totalReviews = Review::approved()->count();
        
        // Calculate average rating
        $averageRating = Review::approved()->avg('rating') ?: 0;
        
        // Get rating distribution
        $ratingDistribution = Review::getRatingDistribution();
        
        // Ensure all ratings are present (1-5)
        $ratingDistribution = array_merge([
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0,
        ], $ratingDistribution);
        
        // Share with view
        $view->with([
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating,
            'ratingDistribution' => $ratingDistribution,
        ]);
    }
}