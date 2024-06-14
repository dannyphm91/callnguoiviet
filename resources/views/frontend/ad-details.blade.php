@extends('frontend.layouts.app')

@section('title')
    {{ $ad->title }}
@endsection

@section('meta')
    <meta name="title" content="{{ $ad->title }}">
    <meta name="description" content="{{ $ad->description }}">

    <meta property="og:image" content="{{ $ad->image_url }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $ad->title }}">
    <meta property="og:url" content="{{ route('frontend.addetails', $ad->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{ $ad->description }}">

    <meta name=twitter:card content=summary_large_image />
    <meta name=twitter:site content="{{ config('app.name') }}" />
    <meta name=twitter:creator content="{{ $ad->customer->name }}" />
    <meta name=twitter:url content="{{ route('frontend.addetails', $ad->slug) }}" />
    <meta name=twitter:title content="{{ $ad->title }}" />
    <meta name=twitter:description content="{{ $ad->description }}" />
    <meta name=twitter:image content="{{ $ad->image_url }}" />
@endsection

@section('content')
    <div class="" x-data="{ filter: false }">
        <x-frontend.breadcrumb.breadcrumb :links="[['text' => $ad->title]]" />
        <section class="pt-8 pb-16 dark:bg-gray-800">
            <div class="container">
                <div class="flex flex-col xl:flex-row gap-6 overflow-hidden">
                    <div class="details-wrap w-full">
                        <x-frontend.ad-card.details.header :ad="$ad" />
                        <div class="flex flex-col lg:flex-row gap-5">
                            <div class="w-full flex-grow lg:max-w-[70%] max-w-full overflow-hidden">
                                <x-frontend.ad-card.details.slider :ad="$ad" />
                                <x-frontend.ad-card.details.info :ad="$ad" :product_custom_field_groups="$product_custom_field_groups" />
                            </div>
                            <div class="flex flex-col lg:max-w-[30%] gap-6">
                                <x-frontend.ad-card.details.sidebar-top :ad="$ad" />
                                <x-frontend.ad-card.details.sidebar-bottom :ad="$ad" />
                            </div>
                        </div>
                        <x-frontend.ad-card.details.footer />
                    </div>
                </div>
            </div>
        </section>
        <!-- Related Listing -->
        <section class="pt-16 bg-gray-50 dark:bg-gray-900">
            <div class="container">
                <h2 class="heading-03 dark:text-white text-center mb-8">{{ __('related_ads') }}</h2>
                @if ($related_ads)
                    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($related_ads as $ad)
                            <x-frontend.ad-card.card :ad="$ad" />
                        @endforeach
                    </div>
                @else
                    <div>
                        <x-not-found2 />
                    </div>
                @endif
                <div class="my-8 text-center">
                    <a href="{{ route('frontend.ads') }}" class="btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <span>{{ __('browse_all') }}</span>
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('css')
    <!-- Add venobox -->
    <link rel="stylesheet" href="{{ asset('frontend/css/leaflet.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}" type="text/css" />
    <style>
        .vbox-child {
            max-width: 750px !important;
        }

        .leaflet-shadow-pane {
            display: none;
        }
    </style>
@endpush


@push('js')
    <!-- Add venobox -->
    <script type="text/javascript" src="{{ asset('frontend/js/venobox.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            /* default settings */
            $('.venobox').venobox();
        });
    </script>
    <script src="{{ asset('frontend/js/leaflet.js') }}"></script>
    <script>
        var oldlat = {!! $ad->lat ? $ad->lat : $setting->default_lat !!};
        var oldlng = {!! $ad->long ? $ad->long : $setting->default_long !!};
        var map = L.map('map').setView([oldlat, oldlng], 8);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var marker = L.marker([oldlat, oldlng], {
            draggable: true,
        }).addTo(map);
        // var circle = L.circle([oldlat,oldlng], {
        //     color: 'red',
        //     fillColor: '#f03',
        //     fillOpacity: 1.5,
        //     radius: 5000
        // }).addTo(map);
    </script>
    <script>
        let isToastVisible = false;

        window.addEventListener('alert', event => {
            if (!isToastVisible) {
                isToastVisible = true;

                toastr.clear();

                toastr.options = {
                    "closeButton": true,
                    "progressBar": false,
                    "onHidden": function() {
                        isToastVisible = false;
                    }
                };

                toastr[event.detail.type](
                    event.detail.message,
                    event.detail.title ?? ''
                );
            }
        });
    </script>
@endpush
