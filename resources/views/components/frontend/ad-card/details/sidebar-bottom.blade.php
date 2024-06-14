{{-- <div class="border border-gray-100 rounded-l-lg">
    <div class="px-5 pt-5 pb-3 flex flex-col gap-2">
        <h3 class="body-lg-500 text-gray-900">Locations</h3>
        <p class="body-md-400 text-gray-700">House: 34/4, Road: 3, Block: A, Dhaka-Uddan,
            Mohammadpur,</p>
    </div>
    <div id="map" class="min-h-[248px]"></div>
</div> --}}


@props(['ad' => null])

<div class="border border-gray-100 rounded-l-lg">
    <div class="px-5 pt-5 pb-3 flex flex-col gap-2">
        <h3 class="body-lg-500 text-gray-900">{{ __('location') }}</h3>
        <p class="body-md-400 text-gray-700">
            {{ $ad->district ? $ad->district . ', ' : '' }}
            {{ $ad->region ? $ad->region . ', ' : '' }}
            {{ $ad->country ?? '' }}
        </p>
    </div>
    {{-- @php
        $map = $setting->default_map;
    @endphp
    @if ($map == 'map-box')
        <div class="map mymap" id='map-box' class="min-h-[248px]"></div>
    @elseif ($map == 'google-map')
        <div class="map mymap" id="google-map" class="min-h-[248px]"></div>
    @elseif ($map == 'leaflet')
        <div id="leaflet-map" class="min-h-[248px]"></div>
    @endif --}}

    <div id="map" class="min-h-[248px]"></div>
</div>
