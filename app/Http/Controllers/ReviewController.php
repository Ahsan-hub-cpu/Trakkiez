<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display the product page with its reviews.
     */
    public function show(Request $request, $productId)
    {
        $product = Product::with('reviews')->findOrFail($productId);
        $reviews = $product->reviews()->paginate(5); // Paginate with 5 reviews per page
        $averageRating = $product->reviews->avg('rating'); // Calculate average rating
        $reviewCount = $product->reviews->count(); // Total number of reviews

        if ($request->ajax()) {
            return view('partials.reviews-list', compact('reviews'))->render();
        }

        return view('details', compact('product', 'reviews', 'averageRating', 'reviewCount'));
    }

    /**
     * Store a new review for the product.
     */
    public function store(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'reviewer_name' => 'nullable|string|max:255',
            'review' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        Review::create([
            'product_id' => $productId,
            'reviewer_name' => $request->reviewer_name,
            'review' => $request->review,
            'rating' => $request->rating,
            'is_approved' => false, // Pending admin approval
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted! It will appear after admin approval.'
        ]);
    }
}