<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Ad\Entities\Ad;

class SellerAd extends Component
{
    public $user_id;

    public $ad_data;

    public $loadButton = true;

    public $total;

    public $count = 9;

    public $loading = false;

    // Load More Data
    public function loadMore()
    {
        $this->loading = true;
        $this->count += 9;
    }

    public function render()
    {
        session()->put(['seller_tab' => 'ads']);

        $this->ad_data = Ad::where('user_id', $this->user_id)
            ->activeCategory()
            ->with([
                'customer',
                'category',
            ])
            ->active()
            ->latest()
            ->take($this->count)
            ->get();

        $this->total = Ad::where('user_id', $this->user_id)
            ->activeCategory()
            ->active()
            ->count();

        $this->loading = false;

        return view('livewire.seller-ad');
    }
}
