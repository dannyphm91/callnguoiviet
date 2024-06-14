<?php

namespace Database\Seeders;

use App\Models\SearchCountry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewSearchCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $countriesCount = SearchCountry::count();
        if ($countriesCount) {
            $this->makeCountry();
        }
    }

    protected function makeCountry()
    {
        $countries_list = json_decode(file_get_contents(base_path('resources/seed-data/search_countries.json')), true);

        foreach ($countries_list as $countryData) {
            $slug = Str::slug($countryData['name']);
            $image = 'backend/image/flags/flag-of-'.str_replace(' ', '-', $countryData['name'].'.jpg');
            $icon = 'flag-icon-'.Str::lower($countryData['iso2']);

            // Check if the country already exists in the database
            $existingCountry = SearchCountry::where('id', $countryData['id'])->first();

            if ($existingCountry) {
                // Update the existing country
                $existingCountry->update([
                    'slug' => $slug,
                    'image' => $image,
                    'icon' => $icon,
                ]);
            }
        }
    }
}
