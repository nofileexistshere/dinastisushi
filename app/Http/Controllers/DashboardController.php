<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\RecommendationService;
use App\Models\Order;
use App\Models\Rating;

class DashboardController extends Controller
{
    protected $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function index()
    {
        $user = Auth::user();
        
        // Get user statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)->sum('total_price');
        $averageRating = Rating::where('user_id', $user->id)->avg('rating');
        
        // Get recommendations
        $recommendations = $this->recommendationService->getRecommendations($user, 1);
        
        return view('dashboard', compact(
            'user',
            'totalOrders',
            'totalSpent',
            'averageRating',
            'recommendations'
        ));
    }
}
