@props([
    // 'featured' => false,
    // 'highlight' => false,
    // 'urgent' => false,
    'top_ad' => false,
    'bump_up' => false,
    'ad' => null,
])

@php
    $today = now()->format('Y-m-d');
    $allow_featured = $ad->featured && Carbon\Carbon::parse($ad->featured_till)->format('Y-m-d') >= $today;
    $allow_highlight = $ad->highlight && Carbon\Carbon::parse($ad->highlight_till)->format('Y-m-d') >= $today;
    $allow_urgent = $ad->urgent && Carbon\Carbon::parse($ad->urgent_till)->format('Y-m-d') >= $today;
    $allow_top_ad = $ad->top && Carbon\Carbon::parse($ad->top_till)->format('Y-m-d') >= $today;
    $allow_bump_up = $ad->bump_up && Carbon\Carbon::parse($ad->bump_up_till)->format('Y-m-d') >= $today;
@endphp

<a href="{{ route('frontend.addetails', $ad?->slug) }}"
    class="bg-white dark:bg-gray-700 group relative overflow-hidden flex flex-col gap-4 pb-4 listing-card w-full hover:-translate-y-1
        {{ !$bump_up && !$top_ad && $allow_featured ? 'featured' : '' }}
        {{ $allow_highlight ? 'highlighted' : '' }}
        {{ $top_ad && $allow_top_ad ? 'highlighted' : '' }}
        {{ $bump_up && $allow_bump_up ? 'highlighted' : '' }}
    ">
    <div class="w-full overflow-hidden relative">
        <img class="w-full object-cover min-h-[220px] max-h-[220px]" src="{{ $ad?->image_url ?? '' }}" alt="">
        <button onclick="openModal(event)"
            class="absolute bottom-0 start-0 w-full bg-[rgba(23,104,224,0.8)] py-2 text-white text-center transition-all duration-300 translate-y-full invisible group-hover:visible group-hover:translate-y-0"
            type="button" data-drawer-target="ad-details_offcanvas_{{ $ad->id }}"
            data-drawer-show="ad-details_offcanvas_{{ $ad->id }}" data-drawer-placement="right"
            aria-controls="ad-details_offcanvas_{{ $ad->id }}">Quick View</button>
    </div>
    <div class="w-full px-4 flex flex-col gap-2.5">
        <div>
            <h2 class="heading-06 text-start text-error-500">
                {{ changeCurrency($ad?->price) }}
            </h2>
            <h3 class="body-md-500 text-start text-gray-900 dark:text-white line-clamp-1">
                {{ $ad?->title ?? '' }}
            </h3>
        </div>
        <ul class="flex flex-col gap-2.5">
            <li class="flex gap-1.5 items-center body-sm-400 text-gray-700 dark:text-white/70">
                <x-svg.heroicons.location class="w-5 h-5" />
                <span class="line-clamp-1">
                    {{ $ad?->country ?? '' }}
                </span>
            </li>
            <li class="flex gap-1.5 items-center body-sm-400 text-gray-700 dark:text-white/70">
                <x-svg.heroicons.stack class="w-5 h-5" />
                <span class="line-clamp-1">
                    {{ $ad?->category?->name ?? '' }}
                </span>
            </li>
        </ul>
    </div>
    <div class="w-full px-4 flex justify-between items-center">
        <p class="body-xs-400 text-gray-500 dark:text-white/50">
            {{ humanTime($ad?->created_at) }}
        </p>
        <div class="flex gap-2 items-center">
            {{-- Featured ad badge --}}
            @if (!$bump_up && !$top_ad && $allow_featured)
                <p class="inline-flex gap-1 text-primary-500 caption-04 items-center">
                    <x-svg.heroicons.featured />
                    <span>{{ __('fetaured') }}</span>
                </p>
            @endif

            {{-- Bump up ad badge --}}
            @if ($bump_up && $allow_bump_up)
                <p class="inline-flex justify-center items-center" title="{{ __('bump_up_listing') }}">
                    <x-frontend.icons.bump-up />
                </p>
            @endif
        </div>
    </div>

    {{-- Urgent ad badge  --}}
    @if ($allow_urgent)
        <span class="urgent-ribbon" title="{{ __('urgent_listing') }}">{{ __('urgent') }}</span>
    @endif

    {{-- Top ad badge  --}}
    @if ($top_ad && $allow_top_ad)
        <span class="absolute top-3 left-3" title="{{ __('top_listing') }}">
            <x-frontend.icons.top-ad />
        </span>
    @endif
</a>

<!-- drawer component -->
<x-frontend.ad-card.card-drawer :ad="$ad" />

@push('css')
    <style>
        .galleryView {
            height: 520px;
            width: 100%;
        }


        @media (max-width: 767px) {
            .galleryView {
                height: 320px;
            }
        }

        @media (max-width: 525px) {
            .galleryView {
                height: 250px;
            }
        }

        .swiper.galleryList {
            height: 60px;
            box-sizing: border-box;
            padding: 0;
        }

        .galleryList .swiper-slide {
            width: 80px !important;
            height: 100%;
            border-radius: 6px;
            border: 1px solid var(--gray-100);
        }

        .galleryList .swiper-slide-thumb-active {
            opacity: 1;
            border: 3px solid var(--primary-500);
        }

        .galleryList .swiper-slide img {
            height: 100%;
            object-fit: cover;
        }

        .galleryList .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
            padding: 10px
        }

        .galleryList .swiper-slide img {
            height: 100%;
            object-fit: cover;
        }

        .galleryView .swiper-button-prev,
        .galleryView .swiper-button-next {
            width: 24px;
            height: 24px;
            border-radius: 124px;
            background: rgba(0, 0, 0, 0.50);
            padding: 6px;
            transition: all 0.4s ease-in;
        }

        .galleryView .swiper-button-prev:hover,
        .galleryView .swiper-button-next:hover {
            background: var(--primary-500);
        }

        .galleryView .swiper-button-next:after {
            content: url("data:image/svg+xml,%3Csvg width='12' height='12' viewBox='0 0 12 12' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4.125 2.25L7.875 6L4.125 9.75' stroke='white' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
            font-size: unset;
        }

        .galleryView .swiper-button-prev:after {
            content: url("data:image/svg+xml,%3Csvg width='12' height='12' viewBox='0 0 12 12' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4.125 2.25L7.875 6L4.125 9.75' stroke='white' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
            font-size: unset;
            transform: rotate(180deg)
        }
    </style>
@endpush

@push('js')
    <script>
        function openModal(event) {
            console.log(event);
            event.preventDefault();
        }
    </script>
@endpush
