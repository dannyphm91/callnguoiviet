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
    <link rel="stylesheet" href="https://adlisting.templatecookie.com/backend/plugins/flag-icon-css/css/flag-icon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @endsection

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-[#F5F6F7] to-[#E8F0FC] dark:bg-gradient-to-b-dark dark:from-gray-900 dark:to-[#11428b] pt-16 pb-32 dark:bg-gray-800">
        <div class="container">
            <div class="flex justify-center items-center">
                <div class="flex flex-col gap-4 pt-14 pb-16">
                    <h2 class="heading-01 dark:text-white text-gray-900 text-center"> {{__('buy_sell_and_find_just_about_anything')}} </h2>
                    <p class="max-w-2xl mx-auto body-lg-400 dark:text-white/80 tetx-gray-800 text-center">  {{ __('explore_active_ads_across_categories_from_all_over_bangladesh_for_free_find_what_you_are_looking_for_with_ease', ['activeAds' => activeAds(), 'activeCategory' => activeCategory()]) }}</p>
                    <livewire:nav-search-component landing="home2" />
                </div>
            </div>
            @if ($topCategories->count() > 0)
            <div>
                <h2 class="text-center dark:text-white heading-06"> {{__('categories')}}</h2>
                <div class="flex gap-2 items-center mt-4">
                    <div
                        class="hero-category-slider_prev cursor-pointer inline-flex items-center bg-primary-500 text-white w-[22px] h-[22px] rounded-full p-[5px]">
                        <x-svg.right-icon stroke="currentColor" class="rotate-180" />
                    </div>
                    <div class="swiper hero-category-slider">
                        <div class="swiper-wrapper">
                            @foreach ($topCategories as $category)
                                <div class="swiper-slide whitespace-nowrap max-w-max inline-flex py-[13px] group">
                                    <a href="{{ route('frontend.ads.category', $category['slug']) }}"
                                        class="heading-07 sm:min-w-[200px] p-4 rounded-lg flex flex-col gap-1.5 justify-center items-center transition-all duration-300 hover:bg-white dark:hover:bg-gray-700 hover:shadow-[0px_2px_4px_-2px_rgba(28,33,38,0.06),0px_4px_8px_-2px_rgba(28,33,38,0.10)]">
                                        <img class="bg-white dark:bg-gray-600 group-hover:bg-primary-50 p-2 rounded-full w-14 h-14"
                                            src="{{ $category->image }}" alt="">
                                        <h3 class="body-md-500 text-gray-900 dark:text-white mt-1.5">{{ $category->name }}</h3>
                                        <p class="body-sm-400 text-gray-700 dark:text-white/80">{{ $category->ad_count ?? 0 }} {{ __('ads') }}</p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div
                        class="hero-category-slider_next cursor-pointer inline-flex items-center bg-primary-500 text-white w-[22px] h-[22px] rounded-full p-[5px]">
                        <x-svg.right-icon stroke="currentColor" class="rtl:rotate-180" />
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- google adsense area -->
    @if (advertisementCode('home_page_center'))
        <div class="container my-4">
            {!! advertisementCode('home_page_center') !!}
        </div>
    @endif
    <!-- google adsense area end -->

    <!-- Featured Listing Section -->
    @if ($featured_ads->count() > 0)
        <section class="py-16 bg-white dark:bg-gray-800">
            <div class="container">
                <h2 class="heading-03 dark:text-white text-center mb-8">{{ __('featured_listing') }}</h2>
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
                            <x-frontend.ad-card.card :featured="$ad->featured" :ad="$ad" />
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
    <!-- top country section -->
    @if ($topCountries->count() > 0)
        <section
            class="py-16 border-b border-gray-50 dark:border-gray-700 dark:bg-gray-800 bg-gradient-to-b from-[#F5F6F7] via-[rgba(245,246,247,0.00)] to-white dark:bg-gradient-to-b-dark dark:from-gray-800">
            <div class="container">
                <h2 class="text-center heading-03 text-gray-900 dark:text-white mb-8">{{ __('top_country') }}</h2>
                <div class="grid xl:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 gap-6">
                    @foreach ($topCountries as $country)
                        <a href="ads?headerLocation={{$country->slug}}"
                            class="p-4 transition-all duration-300 hover:shadow-sm flex gap-3.5 items-center rounded-lg border border-primary-50 dark:border-gray-900 hover:-translate-y-1 bg-white dark:bg-gray-700 hover:border-primary-200 hover:bg-primary-50">

                            <i class="flag-icon {{$country->icon}}"></i>
                            <div>
                                <h3 class="heading-07 text-gray-900 dark:text-white line-clamp-1">{{ $country->country }}</h3>
                                <p class="body-base-400 text-gray-900 dark:text-white mt-2">{{ $country->count ?? 0 }} {{ __('ads') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- Latest Listing Section -->
    @if ($latest_ads->count() > 0)
        <section class="pt-16 dark:py-16 bg-gray-50 dark:bg-gray-900 ">
            <div class="container">
                <h2 class="heading-03 text-center text-gray-900 dark:text-white mb-8">{{ __('latest_ads') }}</h2>
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

    <!-- faqs Section -->
    <section class="py-16 dark:bg-gray-800">
        <div class="container">
            <h2 class="text-center heading-02 text-gray-900 dark:text-white mb-6">{{ __('frequently_asked_question') }}</h2>
            <p class="text-center body-md-400 text-gray-800 dark:text-gray-100 mb-14">{{ $cms->faq_content }}</p>

            <div class="flex flex-wrap xl:px-44 justify-center items-center">
                <div x-data="{tab: '{{ $initialTab }}'}" x-init="" class="relative w-full">

                    <div class="flex flex-wrap justify-center items-center gap-3 md:gap-6">
                        @foreach ($categories as $index => $faq_category)
                            <button @click="tab='tab-{{ $index + 1 }}'" type="button"
                                :class="{ '!bg-primary-500 dark:!bg-primary-800 text-white': tab==='tab-{{ $index + 1 }}' }"
                                class="flex flex-col gap-0.5 md:gap-4 justify-center items-center md:px-6 md:py-6 px-3 py-1.5 md:w-56 rounded-lg transition-all duration-300 text-gray-900 dark:text-white hover:text-white bg-gray-50 dark:bg-gray-600 hover:bg-primary-500">
                                <i class="{{ $faq_category->icon }} md:text-3xl text-sm"></i>
                                <span class="text-sm">{{ $faq_category->name }}</span>
                            </button>
                        @endforeach
                    </div>

                    <div class="w-full md:p-5 p-0 mt-2 text-xs text-gray-400 rounded-md content">

                        @foreach ($categories as $index => $faq_category)
                            <div x-show="tab==='tab-{{ $index + 1 }}'" x-cloak class="relative">
                                <div x-data="{
                                    activeAccordion: '',
                                    setActiveAccordion(id) {
                                        this.activeAccordion = (this.activeAccordion == id) ? '' : id
                                    }
                                }" class="relative w-full mx-auto heading-05">

                                    @forelse ($faq_category->faqs as $faq)
                                        <div x-data="{ id: $id('accordion') }"
                                            :class="{
                                                'text-primary-500 dark:text-primary-300': activeAccordion == {{ $faq->id }},
                                                'text-gray-900 dark:text-white/80': activeAccordion != {{ $faq->id }}
                                            }"
                                            class="mb-4 duration-300 ease-out bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-900 rounded-md cursor-pointer group" x-cloak>
                                            <button @click="setActiveAccordion({{ $faq->id }})"
                                                class="accordion-btn flex items-center justify-between w-full md:px-5 px-3 py-1.5 md:py-4 font-semibold text-left select-none">
                                                <span> {{ $faq->question }}</span>
                                                <div :class="{ 'rotate-90': activeAccordion == {{ $faq->id }} }"
                                                    class="relative flex items-center justify-center md:w-5 w-3 h-3 md:h-5 duration-300 ease-out">
                                                    <div
                                                        class="absolute w-0.5 h-full bg-neutral-500 group-hover:bg-neutral-800 group-hover:dark:bg-neutral-300 rounded-full">
                                                    </div>
                                                    <div :class="{ 'rotate-90': activeAccordion == {{ $faq->id }} }"
                                                        class="absolute w-full h-0.5 ease duration-500 bg-neutral-500 group-hover:bg-neutral-800 group-hover:dark:bg-neutral-300 rounded-full">
                                                    </div>
                                                </div>
                                            </button>
                                            <div x-show="activeAccordion=={{ $faq->id }}" x-collapse.duration.400ms
                                                x-cloak>
                                                <div class="accordion-item md:px-5 px-3 py-1.5 md:py-4 mt-2 body-md-400 text-gray-700 dark:text-gray-300">
                                                    {!! $faq->answer !!}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <x-no-data-found />
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
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
