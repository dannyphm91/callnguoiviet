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
    <!-- Category Section Start -->
    @if ($topCategories->count() > 0)
        <section
            class="py-16 border-b border-gray-50 dark:border-gray-600 bg-white dark:bg-gray-900">
            <div class="container">
                <h2 class="text-center heading-03 mb-8 dark:text-white">{{ __('all_categories') }}</h2>
                <div class="grid xl:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 gap-6">
                    @foreach ($topCategories as $category)
                        <a href="{{ route('frontend.ads.category', $category['slug']) }}"
                            class="group p-4 transition-all duration-300 hover:shadow-sm flex gap-3.5 items-center rounded-lg border border-gray-50 dark:border-gray-600 hover:-translate-y-1 hover:bg-primary-50 hover:dark:bg-gray-700">
                            <img class="w-14 h-14 object-contain" src="{{ $category->image }}" alt="">
                            <div>
                                <h3 class="heading-07 line-clamp-1 dark:group-hover:text-gray-white dark:text-white">{{ $category->name }}</h3>
                                <p class="body-base-400 mt-2 dark:text-gray-300">{{ $category->ad_count ?? 0 }} {{ __('ads') }}</p>
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
        <section class="py-16 bg-white dark:bg-gray-800">
            <div class="container">
                <h2 class="heading-03 text-center mb-8 dark:text-white">{{ __('featured_listing') }}</h2>
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
    <!-- Latest Listing Section -->
    @if ($latest_ads->count() > 0)
        <section class="py-16 dark:bg-gray-900 bg-gray-300">
            <div class="container">
                <h2 class="heading-03 text-center mb-8 dark:text-white">{{ __('latest_ads') }}</h2>
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
