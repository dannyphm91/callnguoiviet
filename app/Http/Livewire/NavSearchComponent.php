<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\SearchCountry;
use App\Models\State;
use Livewire\Component;
use Modules\Ad\Entities\Ad;

class NavSearchComponent extends Component
{
    public $location_search_country_input = '';

    public $location_search_state_input = '';

    public $location_search_city_input = '';

    public $location_search_countries = [];

    public $location_search_states = [];

    public $location_search_cities = [];

    public $location_search_active_country = '';

    public $location_search_active_country_id = '';

    public $location_search_active_state = '';

    public $location_search_active_state_id = '';

    public $location_search_active_city = '';

    public $location_search_active_city_id = '';

    public $location_search_modal = false;

    public $see_all_country_btn = true;

    public $search = null;

    public $landing = '';

    public $search_ad_val = '';

    protected $listeners = ['openModal'];

    public function getStates($id, $name)
    {
        $this->location_search_states = State::where('country_id', $id)->select('id', 'name', 'country_id')->orderBy('name')->get();
        $this->location_search_active_country = $name;
        $this->location_search_active_country_id = $id;

        $this->updateMobileSearchNav();
        $this->searchInput();

        if ($this->location_search_states->isEmpty()) {
            $this->closeModal();
        }
    }

    public function getCities($id, $name)
    {
        $this->location_search_cities = City::where('state_id', $id)->select('id', 'name', 'state_id')->orderBy('name')->get();
        $this->location_search_active_state = $name;
        $this->location_search_active_state_id = $id;

        $this->updateMobileSearchNav();
        $this->searchInput();

        if ($this->location_search_cities->isEmpty()) {
            $this->closeModal();
        }
    }

    public function setCity($id, $name)
    {
        $this->location_search_active_city = $name;
        $this->location_search_active_city_id = $id;

        $this->updateMobileSearchNav();
        $this->searchInput();
        $this->closeModal();
    }

    public function search($model)
    {
        switch ($model) {
            case 'Country':
                $this->location_search_countries = SearchCountry::where('name', 'like', '%'.$this->location_search_country_input.'%')
                    ->select('id', 'name', 'slug', 'image', 'icon')
                    ->get();
                $this->see_all_country_btn = false;
                break;
            case 'State':
                $this->location_search_states = State::where('name', 'like', '%'.$this->location_search_state_input.'%')
                    ->where('country_id', $this->location_search_active_country_id)
                    ->select('id', 'name', 'country_id')->get();
                break;
            case 'City':
                $this->location_search_cities = City::where('name', 'like', '%'.$this->location_search_city_input.'%')
                    ->where('state_id', $this->location_search_active_state_id)
                    ->select('id', 'name', 'state_id')->get();
                break;
        }
    }

    public function searchInput()
    {
        if ($this->location_search_active_country) {
            $this->search = $this->location_search_active_country;
            $this->location_search_active_country = $this->location_search_active_country;
        }
        if ($this->location_search_active_state) {
            $this->search = $this->search.', '.$this->location_search_active_state;
            $this->location_search_active_state = $this->location_search_active_state;
        }
        if ($this->location_search_active_city) {
            $this->search = $this->search.', '.$this->location_search_active_city;
            $this->location_search_active_city = $this->location_search_active_city;
        }

        // Send Data to AdList Page and Mobile Search Nav
        $this->emit('adListSearchText', $this->search == 'Search' ? '' : $this->search);
    }

    public function updateMobileSearchNav()
    {
        // Send Data to Mobile Search Nav
        $this->emit('activeLocationFields', [
            'country' => $this->location_search_active_country,
            'state' => $this->location_search_active_state,
            'city' => $this->location_search_active_city,
        ]);
    }

    public function back($to)
    {
        switch ($this->location_search_active_country_id == '' ? 'empty' : $to) {
            case 'country':
                $this->location_search_active_country = '';
                $this->location_search_active_city = '';
                $this->search = 'Search';
                $this->searchInput();
                $this->updateMobileSearchNav();
                $this->seeAllCountry();
                break;
            case 'state':
                $this->location_search_active_state = '';
                $this->location_search_active_city = '';
                $this->search = $this->location_search_active_country;
                $this->searchInput();
                $this->updateMobileSearchNav();
                break;
            default:
                $this->location_search_active_country = '';
                $this->location_search_active_state = '';
                $this->location_search_active_city = '';
        }
    }

    public function seeAllCountry()
    {
        $this->location_search_countries = loadCountries();
        $this->see_all_country_btn = false;
    }

    public function gotoCountries()
    {
        $this->location_search_active_country = '';
        $this->location_search_active_country_id = '';
        $this->location_search_active_state = '';
        $this->location_search_active_state_id = '';
        $this->location_search_active_city = '';
        $this->location_search_active_city_id = '';
        $this->search = 'Search';
        $this->searchInput();
        $this->updateMobileSearchNav();

        $this->seeAllCountry();
    }

    public function openModal()
    {
        $this->location_search_modal = true;
        $this->see_all_country_btn = true;
        $this->location_search_countries = loadCountries()->take(5);

        if (! request()->filled('country') && ! is_null(@selected_country()->name)) {
            $this->search = @selected_country()->name;
            $country = SearchCountry::where('name', 'like', '%'.@selected_country()->name.'%')
                ->select('id', 'name', 'slug', 'image', 'icon')
                ->first();

            $this->getStates($country->id, $country->name);
        }
    }

    public function closeModal()
    {
        $this->location_search_modal = false;
        $this->see_all_country_btn = false;
        $this->location_search_countries = [];
    }

    public function mount()
    {
        //
    }

    public function render()
    {
        if (! is_null($this->search_ad_val) && (strlen(($this->search_ad_val)) > 1)) {
            $filter_ads = Ad::active()->where('title', 'like', '%'.$this->search_ad_val.'%')
                ->take(5)
                ->get();
        } else {
            $filter_ads = [];
        }

        return view('livewire.nav-search-component', [
            'filter_ads' => $filter_ads,
        ]);
    }
}
