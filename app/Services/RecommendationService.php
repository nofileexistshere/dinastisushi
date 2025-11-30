<?php

namespace App\Services;

use App\Models\User;
use App\Models\MenuItem;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class RecommendationService
{
    /**
     * Get personalized recommendations using collaborative filtering
     * 
     * @param User $user
     * @param int $limit
     * @return array
     */
    public function getRecommendations(User $user, $limit = 5)
    {
        // Get user's ratings
        $userRatings = Rating::where('user_id', $user->id)
            ->pluck('rating', 'menu_item_id')
            ->toArray();

        if (empty($userRatings)) {
            // If user hasn't rated anything, return popular items
            return MenuItem::orderBy('average_rating', 'desc')
                ->orderBy('rating_count', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($item) {
                    return [
                        'menu_item' => $item,
                        'score' => $item->average_rating / 5, // Normalize to 0-1
                        'similar_users' => 0,
                    ];
                })
                ->toArray();
        }

        // Find similar users based on cosine similarity
        $similarUsers = $this->findSimilarUsers($user->id, $userRatings);

        // Get recommendations based on similar users' ratings
        $recommendations = [];
        $ratedMenuIds = array_keys($userRatings);

        foreach ($similarUsers as $similarUserId => $similarity) {
            $similarUserRatings = Rating::where('user_id', $similarUserId)
                ->whereNotIn('menu_item_id', $ratedMenuIds)
                ->get();

            foreach ($similarUserRatings as $rating) {
                $menuItemId = $rating->menu_item_id;
                
                if (!isset($recommendations[$menuItemId])) {
                    $recommendations[$menuItemId] = [
                        'total_score' => 0,
                        'count' => 0,
                    ];
                }

                // Weight the rating by user similarity
                $recommendations[$menuItemId]['total_score'] += $rating->rating * $similarity;
                $recommendations[$menuItemId]['count']++;
            }
        }

        // Calculate average weighted scores
        $scoredRecommendations = [];
        foreach ($recommendations as $menuItemId => $data) {
            $menuItem = MenuItem::find($menuItemId);
            if ($menuItem) {
                $score = $data['total_score'] / ($data['count'] * 5); // Normalize to 0-1
                $scoredRecommendations[] = [
                    'menu_item' => $menuItem,
                    'score' => round($score, 2),
                    'similar_users' => count($similarUsers),
                ];
            }
        }

        // Sort by score and limit results
        usort($scoredRecommendations, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return array_slice($scoredRecommendations, 0, $limit);
    }

    /**
     * Find similar users using cosine similarity
     * 
     * @param int $userId
     * @param array $userRatings
     * @return array
     */
    private function findSimilarUsers($userId, $userRatings)
    {
        $similarities = [];

        // Get all other users who have rated items
        $otherUsers = Rating::where('user_id', '!=', $userId)
            ->select('user_id')
            ->distinct()
            ->pluck('user_id');

        foreach ($otherUsers as $otherUserId) {
            $otherUserRatings = Rating::where('user_id', $otherUserId)
                ->pluck('rating', 'menu_item_id')
                ->toArray();

            // Calculate cosine similarity
            $similarity = $this->cosineSimilarity($userRatings, $otherUserRatings);

            if ($similarity > 0) {
                $similarities[$otherUserId] = $similarity;
            }
        }

        // Sort by similarity (descending)
        arsort($similarities);

        return $similarities;
    }

    /**
     * Calculate cosine similarity between two rating vectors
     * 
     * @param array $ratings1
     * @param array $ratings2
     * @return float
     */
    private function cosineSimilarity($ratings1, $ratings2)
    {
        $commonItems = array_intersect_key($ratings1, $ratings2);

        if (empty($commonItems)) {
            return 0;
        }

        $dotProduct = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        foreach ($commonItems as $itemId => $rating) {
            $dotProduct += $ratings1[$itemId] * $ratings2[$itemId];
            $magnitude1 += pow($ratings1[$itemId], 2);
            $magnitude2 += pow($ratings2[$itemId], 2);
        }

        $magnitude1 = sqrt($magnitude1);
        $magnitude2 = sqrt($magnitude2);

        if ($magnitude1 == 0 || $magnitude2 == 0) {
            return 0;
        }

        return $dotProduct / ($magnitude1 * $magnitude2);
    }
}
