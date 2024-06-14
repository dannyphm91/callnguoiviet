<?php

namespace App\Http\Traits;

use Modules\Ad\Entities\Ad;

trait HasAd
{
    private function fetchLatestAds()
    {
        $selected_country = session('selected_country');

        return Ad::with('category')
            ->when($selected_country, function ($query, $selected_country) {
                return $query->where('country', $selected_country);
            })
            ->active()
            ->activeCategory()
            ->latest()
            ->limit(12)
            ->get();
    }

    private function fetchFeaturedAds()
    {
        $selected_country = session('selected_country');

        return Ad::with('category')
            ->when($selected_country, function ($query, $selected_country) {
                return $query->where('country', $selected_country);
            })
            ->active()
            ->activeCategory()
            ->featured()
            ->latest('featured_at')
            ->limit(12)
            ->get();
    }
}
