<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AffiliatePointHistory extends Component
{
    public $affiliatePointHistory;

    public $visibleRows = 5;

    public $allDataLoaded = false;

    public function render()
    {
        return view('livewire.affiliate-point-history');
    }

    public function mount($affiliatePointHistory)
    {
        $this->affiliatePointHistory = $affiliatePointHistory;
    }

    public function loadMore()
    {
        if (! $this->allDataLoaded) {
            $this->visibleRows = count($this->affiliatePointHistory);
            $this->allDataLoaded = true;
        }
    }
}
