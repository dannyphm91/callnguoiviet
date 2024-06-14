@extends('frontend.layouts.app')

@section('title', __('home'))

@section('meta')
    @php
        $data = metaData('home');
    @endphp

    <meta name="title" content="{{ $data->title }}">
    <meta name="description" content="{{ $data->description }}">

    <meta property="og:image" content="{{ $data->image_url }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $data->title }}">
    <meta property="og:url" content="{{ route('frontend.index') }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{ $data->description }}">

    <meta name=twitter:card content={{ $data->image_url }} />
    <meta name=twitter:site content="{{ config('app.name') }}" />
    <meta name=twitter:url content="{{ route('frontend.index') }}" />
    <meta name=twitter:title content="{{ $data->title }}" />
    <meta name=twitter:description content="{{ $data->description }}" />
    <meta name=twitter:image content="{{ $data->image_url }}" />
@endsection

@section('content')

    <!-- Hero Section -->
    @if ($sliders->count() > 0)
        <section class="home-slider dark:bg-gray-900">
            <div class="container px-0 lg:px-[1rem]">
                <div class="swiper hero-banner relative">
                    <div class="swiper-wrapper">

                        @foreach ($sliders as $slider)
                            <div class="swiper-slide">
                                <img class="w-full xl:h-[420px] md:h-[350px] h-[280px] object-cover"
                                    src="{{ $slider->ImageUrl }}" alt="">
                            </div>
                        @endforeach
                    </div>
                    <div
                        class="banner-slider-next absolute right-4 top-1/2 z-50 -translate-y-1/2 hover:shadow-md cursor-pointer inline-flex justify-end items-center bg-white w-[22px] h-[22px] rounded-full p-[5px]">
                        <x-svg.right-icon stroke="#1768E0" />
                    </div>
                    <div
                        class="banner-slider-prev absolute left-4 top-1/2 z-50 -translate-y-1/2 hover:shadow-md cursor-pointer inline-flex justify-end items-center bg-white w-[22px] h-[22px] rounded-full p-[5px]">
                        <x-svg.left-icon stroke="#1768E0" />
                    </div>
                    <div
                        class="banner-slider-pagination z-50 flex justify-center gap-2.5 !absolute !bottom-6 !left-1/2 -translate-x-1/2">
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Category Section Start -->
    @if ($topCategories->count() > 0)
        <section
            class="py-16 bg-gray-50 dark:bg-gray-800">
            <div class="container">
                <h2 class="text-center heading-03 text-gray-900 dark:text-white mb-8">{{ __('top_category') }}</h2>
                <div class="grid xl:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 gap-6">
                    @foreach ($topCategories as $category)
                        <a href="{{ route('frontend.ads.category', $category['slug']) }}"
                            class="p-4 transition-all duration-300 hover:shadow-sm flex gap-3.5 items-center rounded-lg border border-primary-50 dark:border-gray-500 hover:-translate-y-1 bg-white dark:bg-white/10 hover:border-primary-100 hover:bg-primary-50 hover:dark:bg-gray-500">
                            <img class="w-14 h-14 object-contain" src="{{ $category->image }}" alt="">
                            <div>
                                <h3 class="heading-07 dark:text-white line-clamp-1">{{ $category->name }}</h3>
                                <p class="body-base-400 dark:text-white mt-2">{{ $category->ad_count ?? 0 }} {{ __('ads') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- Category Section End -->

    <!-- google adsense area -->
    @if (advertisementCode('home_page_center'))
        <div class="container my-4">
            {!! advertisementCode('home_page_center') !!}
        </div>
    @endif

    <!-- google adsense area end -->

    <!-- Featured Listing Section -->
    @if ($featured_ads->count() > 0)
        <section class="py-16 bg-white dark:bg-gray-900">
            <div class="container">
                <h2 class="heading-03 text-center dark:text-white mb-8">{{ __('featured_listing') }}</h2>
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @forelse ($featured_ads as $ad)
                        @if ($loop->index == 2)
                            <!-- google adsense area -->
                            @if (advertisementCode('ad_listing_page_inside_ad'))
                            <div class="h-[400px] max-h-[400px]">
                                {!! advertisementCode('ad_listing_page_inside_ad') !!}
                            </div>
                        @endif
                        @elseif($loop->index == 9)
                        @if (advertisementCode('ad_listing_page_left'))
                            <div class="h-[400px] max-h-[400px]">
                                {!! advertisementCode('ad_listing_page_left') !!}
                            </div>
                        @endif
                        @else
                          <x-frontend.ad-card.card :featured="$ad->featured" :ad="$ad"  />
                        @endif
                    @empty
                        <div class="col-span-full flex justify-center items-center">
                            <x-not-found2 message="{{ __('no_ads_found') }}" />
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    @endif
    <!-- Latest Listing Section -->
    @if ($latest_ads->count() > 0)
        <section class="pt-16 dark:pb-16 bg-gray-50 dark:bg-gray-800">
            <div class="container">
                <h2 class="heading-03 text-center dark:text-white mb-8">{{ __('latest_ads') }}</h2>
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($latest_ads as $ad)
                        <x-frontend.ad-card.card :featured="$ad->featured" :ad="$ad" />
                    @endforeach
                </div>
                <div class="mt-8 text-center">
                    <a href="{{ route('frontend.ads') }}" class="btn-secondary">
                        <x-svg.search-icon />
                        <span>{{ __('browse_all') }}</span>
                    </a>
                </div>
            </div>
        </section>
    @endif
    <!-- CTA Section -->
    <section class="py-16 dark:bg-gray-800">
        <div class="container">
            <div class="cta-area p-10 max-w-[984px] mx-auto rounded-2xl">
                <div class="flex flex-col md:flex-row gap-6 items-center">
                    <img src="{{ asset('frontend/images/cta-illustartion.png') }}" alt="">
                    <div>
                        <h2 class="mb-4 heading-03 text-gray-900 dark:text-gray-50">{{ __('sell_your_product_with_great_deals') }}</h2>
                        <p class="mb-6 body-lg-400 text-gray-900 dark:text-gray-100">
                            {{ __('pass_on_your_unuse_product_information_to_someone_who_needs_it_more_at_a_fantastic_price_let_us_handle_the_process_while_you_stay_focused_on_your_tasks') }}
                        </p>
                        <a href="{{ route('frontend.post') }}" class="btn-primary !text-base px-5 py-3">
                            <x-svg.plus-circle-icon />
                            <span>{{ __('post_your_listing') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
<script>
  let isToastVisible = false;

  window.addEventListener('alert', event => {
    if (!isToastVisible) {
      isToastVisible = true;

      toastr.clear();

      toastr.options = {
        "closeButton": true,
        "progressBar": false,
        "onHidden": function () {
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
