<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Ad\Entities\Ad;

class MobileNavSearchComponent extends Component
{
    public $location_mobile;

    public $location_search_active_country;

    public $location_search_active_state;

    public $location_search_active_city;

    public $search_ad_val = '';

    protected $listeners = ['adListSearchText', 'activeLocationFields'];

    public function adListSearchText($data)
    {
        $this->location_mobile = $data;
    }

    public function activeLocationFields($data)
    {
        $this->location_search_active_country = $data['country'];
        $this->location_search_active_state = $data['state'];
        $this->location_search_active_city = $data['city'];
    }

    public function OpenModalMobile()
    {
        $this->emit('openModal');
    }

    public function render()
    {
        if (! is_null($this->search_ad_val) && (strlen(($this->search_ad_val)) > 1)) {
            $filter_ads = Ad::where('title', 'like', '%'.$this->search_ad_val.'%')
                ->take(5)
                ->get();
        } else {
            $filter_ads = [];
        }

        return view('livewire.mobile-nav-search-component', [
            'filter_ads' => $filter_ads,
        ]);

    }
}
