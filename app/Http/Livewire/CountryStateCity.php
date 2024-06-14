<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\SearchCountry;
use App\Models\State;
use Livewire\Component;

class CountryStateCity extends Component
{
    public $countries = [];

    public $states = [];

    public $cities = [];

    public $selectedCountryId;

    public $selectedStateId;

    public $selectedCityId;

    protected $listeners = [
        'getStateByCountryId' => 'getStateByCountryId',
        'getCityByStateId' => 'getCityByStateId',
    ];

    public function hydrate()
    {
        $this->dispatchBrowserEvent('render-select2');
    }

    public function render()
    {
        // If the country changes, reset the selected state unless a new state is selected
        if (! $this->selectedStateId || ! $this->isStateSelected()) {
            $this->selectedStateId = null;
        }
        $this->countries = SearchCountry::select('id', 'name')
            ->get()
            ->toArray();

        $selectedCountry = SearchCountry::where('name', $this->selectedCountryId)->first();
        if ($selectedCountry) {
            $countryId = $selectedCountry->id;
            $this->states = State::select('id', 'name', 'country_id')
                ->where('country_id', $countryId)
                ->get()
                ->toArray();
        } else {
            // Handle the case where the selected city was not found
            $this->states = [];
        }

        $selectedState = State::where('name', $this->selectedStateId)->first();

        if ($selectedState) {
            $stateId = ($this->selectedStateId == null) ? null : $selectedState->id;

            $this->cities = City::select('id', 'name', 'state_id')
                ->where('state_id', $stateId)
                ->get()
                ->toArray();
        } else {
            $this->cities = [];
        }

        return view('livewire.country-state-city');
    }

    protected function isStateSelected()
    {
        // Check if a state is currently selected
        return $this->selectedStateId !== null;
    }

    public function getStateByCountryId()
    {
        $selectedCity = SearchCountry::where('name', $this->selectedCountryId)->first();

        if ($selectedCity) {
            $countryId = $selectedCity->id;
            $this->states = State::select('id', 'name', 'country_id')
                ->where('country_id', $countryId)
                ->get()
                ->toArray();

        } else {
            // Handle the case where the selected city was not found
            $this->states = [];
        }
    }

    public function getCityByStateId()
    {
        // Assuming you have a Zone model with a 'country_id' attribute
        $selectedState = State::where('name', $this->selectedStateId)->first();

        if ($selectedState) {
            $stateId = $selectedState->id;

            $this->cities = City::select('id', 'name', 'state_id', 'long', 'lat')
                ->where('state_id', $stateId)
                ->get()
                ->toArray();
        } else {
            $this->cities = [];
        }
    }

    public function mount()
    {
        $this->selectedCountryId = session('selectedCountryId', null);
        $this->selectedStateId = session('selectedStateId', null);
        $this->selectedCityId = session('selectedCityId', null);
        session([
            'selectedCountryLong' => null,
            'selectedCountryLat' => null,
            'selectedStateLong' => null,
            'selectedStateLat' => null,
            'selectedCityLong' => null,
            'selectedCityLat' => null,
        ]);
    }

    public function updatedselectedCountryId($value)
    {
        session(['selectedCountryId' => $value]);
        // Update session values for 'long' and 'lat' based on the selected country
        $selectedCountry = SearchCountry::where('name', $value)->first();
        if ($selectedCountry) {
            session(['selectedCountryLong' => $selectedCountry->long]);
            session(['selectedCountryLat' => $selectedCountry->lat]);
        }
    }

    public function updatedselectedStateId($value)
    {
        session(['selectedStateId' => $value]);
        // Update session values for 'long' and 'lat' based on the selected state
        $selectedState = State::where('name', $value)->first();
        if ($selectedState) {
            session(['selectedStateLong' => $selectedState->long]);
            session(['selectedStateLat' => $selectedState->lat]);
        }
    }

    public function updatedselectedCityId($value)
    {
        session(['selectedCityId' => $value]);
        // Update session values for 'long' and 'lat' based on the selected city
        $selectedCity = City::where('name', $value)->first();
        if ($selectedCity) {
            session(['selectedCityLong' => $selectedCity->long]);
            session(['selectedCityLat' => $selectedCity->lat]);
        }
    }
}