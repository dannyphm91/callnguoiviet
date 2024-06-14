<?php

namespace App\Services\Frontend;

use App\Models\Country;
use App\Models\HomePageSlider;
use Modules\Ad\Entities\Ad;
use Modules\Category\Entities\Category;
use Modules\Category\Transformers\CategoryResource;

class HomePageService
{
    public function execute()
    {
        $selected_country = session()->get('selected_country');

        // $ads = Ad::with('category')
        //     ->when($selected_country, function ($q) use ($selected_country) {
        //         return $q->where('country', $selected_country);
        //     })
        //     ->active()
        //     ->activeCategory()
        //     ->latest()
        //     ->get();

        $featured_ads = Ad::with(['category', 'adFeatures', 'galleries', 'customer'])
            ->when($selected_country, function ($q) use ($selected_country) {
                return $q->where('country', $selected_country);
            })
            ->active()
            ->activeCategory()
            ->latest()
            ->where('featured', 1)
            ->take(12)
            ->get();

        $latest_ads = Ad::with(['category', 'adFeatures', 'galleries', 'customer'])
            ->when($selected_country, function ($q) use ($selected_country) {
                return $q->where('country', $selected_country);
            })
            ->active()
            ->activeCategory()
            ->latest()
            ->take(12)
            ->get();

        $sliders = HomePageSlider::oldest('order')->get();

        $topCategories = CategoryResource::collection(
            Category::active()
                ->with('subcategories', function ($q) {
                    $q->where('status', 1);
                })
                ->withCount([
                    'ads as ad_count' => function ($query) {
                        if (session()->get('selected_country')) {
                            $query->where('country', session()->get('selected_country'))->active();
                        } else {
                            $query->active();
                        }
                    },
                ])
                ->latest('ad_count')
                ->take(12)
                ->get(),
        );

        $topCountries = $topCountries = Ad::select(
            'ads.country',
            \DB::raw('COUNT(*) as count'),
            'search_countries.icon',
            'search_countries.slug'
        )
            ->leftJoin('search_countries', 'ads.country', '=', 'search_countries.name')
            ->groupBy('ads.country', 'search_countries.icon', 'search_countries.slug')
            ->orderByDesc('count')
            ->limit(12)
            ->get();

        return [
            'featured_ads' => $featured_ads,
            'latest_ads' => $latest_ads,
            'sliders' => $sliders,
            'topCategories' => $topCategories,
            'topCountries' => $topCountries,
        ];
    }
}
