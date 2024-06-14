<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Review\Entities\Review;

class SellerReview extends Component
{
    public $reviews;

    // public $rating_details;

    public $user_id;

    public $loadbutton = true;

    public $total;

    public $count = 5;

    public $loading = false;

    // Load More Data
    public function loadmoreReview()
    {
        $this->loading = true;
        $this->count += 5;
    }

    public function render()
    {
        session(['seller_tab' => 'review_list']);

        $this->reviews = Review::with('user:id,name,image,username')
            ->whereSellerId($this->user_id)
            ->whereStatus(1)
            ->latest()
            ->take($this->count)
            ->get();

        $this->total = Review::whereSellerId($this->user_id)->count();

        // To show average rating into Seller review
        // $this->rating_details = [
        //     'total' => $this->reviews->count(),
        //     'rating' => $this->reviews->sum('stars'),
        //     'average' => number_format($this->reviews->avg('stars')),
        // ];
        // To show average rating into Seller review

        $this->loading = false;

        return view('livewire.seller-review');
    }
}
