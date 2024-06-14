@extends('frontend.layouts.app')

@section('title', __('about'))

@section('meta')
    @php
        $data = metaData('about');
    @endphp

    <meta name="title" content="{{ $data->title }}">
    <meta name="description" content="{{ $data->description }}">

    <meta property="og:image" content="{{ $data->image_url }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $data->title }}">
    <meta property="og:url" content="{{ route('frontend.about') }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{ $data->description }}">

    <meta name=twitter:card content="{{ $data->image_url }}" />
    <meta name=twitter:site content="{{ config('app.name') }}" />
    <meta name=twitter:url content="{{ route('frontend.about') }}" />
    <meta name=twitter:title content="{{ $data->title }}" />
    <meta name=twitter:description content="{{ $data->description }}" />
    <meta name=twitter:image content="{{ $data->image_url }}" />
@endsection

@section('content')
    <div>
        <x-frontend.breadcrumb.breadcrumb :links="[['url' => '#', 'text' => __('about_us')]]" />

        <!-- Hero Section -->
        <section class="py-16 dark:bg-gray-800">
            <div class="container">
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <div class="w-full body-md-400">
                        <h2 class="heading-03 mb-6 dark:text-white">{{ __('know_more_about_adlisting') }}</h2>
                        @if ($cms->about_body)
                            <div class="dark:text-gray-100">
                                {!! $cms->about_body !!}
                            </div>
                        @endif
                    </div>
                    @if ($cms->about_video_thumb)

                        <div class="w-full relative">
                            @if ($cms->about_video_thumb)
                                <img src="{{ $cms->about_video_thumb }}" alt="about" />
                            @endif
                            @if ($cms->about_video_url && $cms->about_video_thumb)
                                <a href="{{ $cms->about_video_url }}"
                                    class="venobox absolute inline-flex justify-center items-center bg-primary-500 w-16 h-16 rounded-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
                                    data-vbtype="video" data-autoplay="true">
                                    <x-svg.play-icon />
                                </a>
                            @endif
                        </div>

                    @endif
                </div>
            </div>
        </section>

        <!-- How it works Section -->
        <section class="py-16 bg-gray-50 dark:bg-gray-900">
            <div class="container">
                <h2 class="heading-03 text-center text-gray-900 dark:text-white mb-8">{{ __('how_it_work') }}</h2>
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="relative bg-white dark:bg-gray-800 md:p-8 p-4 rounded-lg">
                        <span class="inline-block mb-6">
                            <x-svg.user-plus-icon />
                        </span>
                        <span class="display-02 absolute md:top-8 top-4 text-gray-100 dark:text-gray-300 md:right-8 right-4">
                            01
                        </span>
                        <h2 class="heading-03 text-gray-900 dark:text-white/80">{{ __('create_account') }}</h2>
                        <p class="text-gray-300 body-md-400 mt-4">
                            {{ $cms->create_account }}
                        </p>
                    </div>
                    <div class="relative bg-white dark:bg-gray-800 md:p-8 p-4 rounded-lg">
                        <span class="inline-block mb-6">
                            <x-svg.big-list-icon />
                        </span>
                        <span class="display-02 absolute md:top-8 top-4 right-4 text-gray-100 dark:text-gray-300 md:right-8">
                            02
                        </span>
                        <h2 class="heading-03 text-gray-900 dark:text-white/80">{{ __('post_listing') }}</h2>
                        <p class="text-gray-300 body-md-400 mt-4">
                            {{ $cms->post_ads }}
                        </p>
                    </div>
                    <div class="relative bg-white dark:bg-gray-800 md:p-8 p-4 rounded-lg">
                        <span class="inline-block mb-6">
                            <x-svg.green-cube-icon />
                        </span>
                        <span class="display-01 absolute md:top-8 top-4 text-gray-100 dark:text-gray-300 right-4 md:right-8">
                            03
                        </span>
                        <h2 class="heading-03 text-gray-900 dark:text-white/80">{{ __('start_earning') }}</h2>
                        <p class="text-gray-300 body-md-400 mt-4">
                            {{ $cms->start_earning }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        @if ($testimonials->count() > 0)
            <!-- Testimonial Section -->
            <section class="pt-16 dark:bg-gray-800">
                <div class="container">
                    <h2 class="heading-02 text-center mb-8 dark:text-white/90">{{ __('customer_voice') }}</h2>
                    <div class="swiper testimonial-slider">
                        <div class="swiper-wrapper">
                            @foreach ($testimonials as $testimonial)
                                <div class="swiper-slide">
                                    <div class="testimonial-card shadow-sm rounded-lg p-6 dark:text-white/80">
                                        <p class="body-md-400 text-center mb-4">{{ $testimonial->description }}</p>
                                        <h2 class="text-center heading-06 mb-3">{{ $testimonial->name }}</h2>
                                        <ul class="rating flex justify-center items-center">
                                            @for ($i = 0; $i < $testimonial->stars; $i++)
                                                <li class="rating-icon">
                                                    <x-svg.star-icon />
                                                </li>
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- suppor-brand section start  -->
        @if ($aboutSliders->count() > 0)
        <section class="section py-16 dark:bg-gray-800">
            <div class="container">
                <h2 class="heading-06 text-center mb-16 dark:text-white">{{ __('supported_by') }}</h2>

                <div class="swiper brand-slider">
                    <div class="swiper-wrapper">
                        @foreach ($aboutSliders as $aboutSlider)
                            <div class="swiper-slide inline-flex max-w-max">
                                <img class="w-[120px] h-[45px] object-contain grayscale dark:grayscale-0" src="{{ $aboutSlider->ImageUrl }}"
                                    alt="brand-icon" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif
        <!-- suppor-brand section end  -->
    </div>
@endsection
@push('css')
    <!-- Add venobox -->
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}" type="text/css"
        media="screen" />
    <style>
        .vbox-child {
            max-width: 750px !important;
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
@endpush
