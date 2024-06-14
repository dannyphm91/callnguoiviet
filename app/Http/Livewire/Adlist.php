<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Ad\Entities\Ad;
use Modules\Brand\Entities\Brand;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategory;

class Adlist extends Component
{
    public $ads;

    public $topAds;

    public $bumpUpAds;

    public $count = 15;

    public $loading = false;

    public $search = '';

    public $selectedCategory = '';

    public $selectedSubcategory = '';

    public $minPrice;

    public $maxPrice;

    public $brands;

    public $selectedbrand;

    public $dateRange;

    public $seletedFeatured;

    public $location;

    public $seletedLatest;

    public $selectedUrgent;

    public $selectAll;

    public $showLoadMore = true;

    public $adsCount = 0;

    public $seletedOption;

    public $search_ad_val = '';

    public $filter_value;

    protected $listeners = ['adListSearchText'];

    public function mount()
    {
        $this->search = request('headerSearch');
    }

    public function render()
    {
        // divide the url into segments
        $path = parse_url(request()->url(), PHP_URL_PATH);
        $pathSegments = explode('/', $path);

        // fetching top ads and bump up ads
        $this->topAds = $this->loadTopAds();
        $this->bumpUpAds = $this->loadBumpUpAds();
        $except_ids = array_merge($this->topAds->pluck('id')->toArray(), $this->bumpUpAds->pluck('id')->toArray());

        // fetching all ads
        $query = Ad::query()
            ->select('id', 'title', 'slug', 'user_id', 'category_id', 'subcategory_id', 'price', 'brand_id', 'thumbnail', 'country', 'region', 'urgent', 'highlight', 'top', 'featured', 'featured_at', 'bump_up', 'created_at')
            ->active()
            ->when(session()->get('selected_country'), function ($query) {
                $query->where('country', session()->get('selected_country'));
            })
            ->when(count($except_ids), function ($query) use ($except_ids) {
                $query->whereNotIn('id', $except_ids);
            })
            ->latest();

        // Check if there are enough segments in the path
        if (count($pathSegments) >= 3) {
            $secondSegment = $pathSegments[2]; // category
            // Apply category filter if selected
            if ($secondSegment) {
                $category = Category::where('slug', $secondSegment)->first();
                if ($category) {
                    $query->whereIn('category_id', [$category->id]);
                    $this->selectedCategory = [$category->slug];
                }
            }

            // Check if there are enough segments in the path
            if (count($pathSegments) >= 4) {
                $thirdSegment = $pathSegments[3]; // subcategory
                // Apply category filter if selected
                if ($thirdSegment) {
                    $subcategory = SubCategory::where('slug', $thirdSegment)->first();
                    if ($subcategory) {
                        $query->whereIn('subcategory_id', [$subcategory->id]);
                        $this->selectedSubcategory = $subcategory->slug;
                    }
                }
            }
        }

        if (request('headerSearch')) {
            $this->ads = $query
                ->when(request('headerSearch'), function ($query) {
                    $query->where('title', 'like', '%'.request('headerSearch').'%');
                })
                ->with(['category'])
                ->take($this->count)
                ->get();
        }

        // Apply category filter if selected
        if ($this->selectedCategory) {
            $catID = Category::where('slug', $this->selectedCategory)->first();
            $query->whereIn('category_id', [$catID->id]);
        }

        // Apply subcategory filter if selected
        if ($this->selectedSubcategory) {
            $subCatID = SubCategory::with('category:id,slug')
                ->where('slug', $this->selectedSubcategory)
                ->first();
            $this->selectedCategory = $subCatID->category?->slug ?? '';
            $query->WhereIn('subcategory_id', [$subCatID->id]);
        }

        // Apply brands filter if selected
        if ($this->selectedbrand) {
            $brandId = Brand::where('name', $this->selectedbrand)->first();
            $query->where('brand_id', [$brandId->id]);
        }

        // Debugging statement
        // dd($this->seletedOption);

        // Apply seletedFeatured filter if selected
        if ($this->seletedOption == 1) {
            $query->where('featured', 1);
        }

        // Apply seletedLatest filter if selected
        if ($this->seletedOption == 'asc') {
            $query->orderBy('updated_at', 'asc');
        }

        // Apply urgent filter if selected
        if ($this->seletedOption == 2) {
            $query->where('urgent', 1);
        }

        // Apply price range filter if min and/or max price are selected
        if ($this->minPrice || $this->maxPrice) {
            $query->whereBetween('price', [$this->minPrice, $this->maxPrice]);
        }

        // Apply date range filter if specified
        if ($this->dateRange) {
            $startDate = now()
                ->subDays($this->dateRange)
                ->startOfDay();
            $endDate = now()->endOfDay();
            $query->whereBetween('updated_at', [$startDate, $endDate]);
        }
        // Apply date range filter if specified
        if ($this->location) {
            $query->where(function ($q) {
                $q->where('country', 'like', '%'.$this->location.'%')
                    ->orWhere('region', 'like', '%'.$this->location.'%')
                    ->orWhere('district', 'like', '%'.$this->location.'%');
            });
        }

        if (request('country') || request('state') || request('city')) {
            $query->where(function ($q) {
                $q->where('country', 'like', '%'.request('country').'%')
                    ->orWhere('region', 'like', '%'.request('state').'%')
                    ->orWhere('district', 'like', '%'.request('city').'%');
            });

            if (request()->filled('country')) {
                $this->location = request()->country;
            }
            if (request()->filled('state')) {
                $this->location = $this->location.', '.request()->state;
            }
            if (request()->filled('city')) {
                $this->location = $this->location.', '.request()->city;
            }
        }

        $this->ads = $query
            ->with(['category'])
            ->take($this->count)
            ->get();

        $this->adsCount = $query->count();

        $this->showLoadMore = $this->adsCount > $this->count ? true : false;

        $this->loading = false;

        if (! is_null($this->search_ad_val) && (strlen(($this->search_ad_val)) > 1)) {
            $this->filter_value = Ad::active()->where('title', 'like', '%'.$this->search_ad_val.'%')
                ->take(5)
                ->get();
        } else {
            $this->filter_value = [];
        }

        return view('livewire.adlist');
    }

    public function adListSearchText($data)
    {
        $this->location = $data;
    }

    public function loadMore()
    {
        $this->loading = true;
        $this->count += 15;
    }

    public function removeSelectedBrand()
    {
        $this->selectedbrand = null;
    }

    public function removeSelectedDate()
    {
        $this->dateRange = null;
    }

    public function updatedSelectedCategory()
    {
        $this->selectedSubcategory = '';
        $this->updateUrl();
    }

    public function updatedSelectedSubcategory()
    {
        $this->updateUrl();
    }

    public function updateUrl()
    {
        $query = Ad::query()
            ->select('id', 'title', 'slug', 'user_id', 'category_id', 'featured', 'subcategory_id', 'price', 'brand_id', 'thumbnail', 'country', 'region', 'created_at')
            ->active()
            ->latest();
        $metatitle = '';
        // Apply category filter if selected
        if ($this->selectedCategory) {
            $catID = Category::where('slug', $this->selectedCategory)->first();
            $countCategory = $query->whereIn('category_id', [$catID->id])->count();
            $metatitle = $countCategory.' '.__('ads_found_for');
        }
        // Apply subcategory filter if selected
        if ($this->selectedSubcategory) {
            $subCatID = SubCategory::with('category:id,slug')
                ->where('slug', $this->selectedSubcategory)
                ->first();
            $this->selectedCategory = $subCatID->category?->slug ?? '';
            $countSubCategory = $query->WhereIn('subcategory_id', [$subCatID->id])->count();
            $metatitle = $countSubCategory.__('ads_found_for');
        }
        $this->dispatchBrowserEvent('update-selected-category', ['category' => $this->selectedCategory, 'subcategory' => $this->selectedSubcategory, 'metatitle' => $metatitle]);
    }

    private function loadTopAds()
    {
        $query = Ad::query()
            ->with('category')
            ->select('id', 'title', 'slug', 'user_id', 'category_id', 'subcategory_id', 'price', 'brand_id', 'thumbnail', 'country', 'region', 'urgent', 'highlight', 'top', 'featured', 'featured_at', 'bump_up', 'created_at')
            ->active()
            ->when(session()->get('selected_country'), function ($query) {
                $query->where('country', session()->get('selected_country'));
            })
            ->when($this->selectedCategory, function ($query) {
                $catID = Category::where('slug', $this->selectedCategory)->first();
                $query->whereIn('category_id', [$catID->id]);
            })
            ->top()
            ->inRandomOrder()
            ->take(5);
        // Apply seletedLatest filter if selected
        if ($this->seletedOption == 'asc') {
            $query->orderBy('updated_at', 'asc');
        }

        // Apply urgent filter if selected
        if ($this->seletedOption == 2) {
            $query->where('urgent', 1);
        }

        return $query->get();
    }

    private function loadBumpUpAds()
    {
        $query = Ad::query()
            ->with('category')
            ->select('id', 'title', 'slug', 'user_id', 'category_id', 'subcategory_id', 'price', 'brand_id', 'thumbnail', 'country', 'region', 'urgent', 'highlight', 'top', 'featured', 'featured_at', 'bump_up', 'created_at')
            ->active()
            ->when(session()->get('selected_country'), function ($query) {
                $query->where('country', session()->get('selected_country'));
            })
            ->when($this->selectedCategory, function ($query) {
                $catID = Category::where('slug', $this->selectedCategory)->first();
                $query->whereIn('category_id', [$catID->id]);
            })
            ->bumpUp()
            ->inRandomOrder()
            ->take(5);

        // Apply seletedLatest filter if selected
        if ($this->seletedOption == 'asc') {
            $query->orderBy('updated_at', 'asc');
        }

        // Apply urgent filter if selected
        if ($this->seletedOption == 2) {
            $query->where('urgent', 1);
        }

        return $query->get();
    }
}
