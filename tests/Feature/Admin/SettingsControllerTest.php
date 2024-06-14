<?php

use App\Models\Setting;

beforeEach(function () {
    $this->admin = createAdmin();
    $this->actingAs($this->admin, 'admin');
});

test('admin can visit preferences settings page', function () {
    $this->get(route('settings.system'))
        ->assertStatus(200)
        ->assertSeeText('List');
});

// test('admin can update website configuration', function () {
//     $data = [
//         "facebook" => "https://facebook.com/zakirsoft",
//         "twitter" => "https://twitter.com/zakirsoft",
//         "instagram" => "https://instagram.com/opusaha",
//         "youtube" => "https://www.youtube.com/channel/UCMSp_qPtYbaUMjEICDLhDCQ",
//         "linkdin" => "https://www.linkedin.com/in/zakirsof",
//         "whatsapp" => "https://web.whatsapp.com/",
//     ];

//     $this->put(route('settings.website.configuration.update'), $data)
//         ->assertStatus(302);
//     expect(Setting::first()->instagram)->tobe('https://instagram.com/opusaha');
// });

test('admin can update map', function () {
    $data = [
        'from_preference' => 'true',
        'map_type' => 'leaflet',
        'map_box_key' => 'pk.eyJ1IjoiZGV2a2hhbGlsMCIsImEiOiJjbDN2NDQybDMxbnVlM2lsdHlramkwNWRxIn0.WWyDML7tKoWPAtgu27jBxQ',
        'google_map_key' => 'AIzaSyC3m_TyDp94bKpyOxWzojZgcUXYj8DdbBc',
    ];

    $this->put(route('module.map.update'), $data)
        ->assertStatus(302);
});

test('admin can visit seo index page', function () {
    $this->get(route('settings.seo.index'))
        ->assertStatus(200)
        ->assertSeeText('Seo');
});
