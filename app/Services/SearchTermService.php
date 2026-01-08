<?php

namespace App\Services;

use App\Models\SearchTerm;
use Illuminate\Support\Collection;

class SearchTermService
{
    /**
     * Get top searched terms
     */
    public function getTopSearchedTerms(int $limit = 10): Collection
    {
        return SearchTerm::orderByDesc('search_count')
            ->limit($limit)
            ->orderBy('search_count', 'desc')
            ->get();
    }
}
