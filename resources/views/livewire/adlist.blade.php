<div>
    <!-- Filter Sectioon -->
    {{-- <x-frontend.listing.filter-top /> --}}
    <!-- Filter Sectioon -->
    {{-- <x-frontend.listing.filter-top /> --}}
    <section class="pt-8 pb-6">
        <div x-data="{ isTyped: false }">
            <div class="container">
                <div class="flex flex-wrap xl:flex-nowrap gap-3 items-center">
                    <button class="btn-secondary py-2.5 px-5" @click="filter = !filter">
                        <x-svg.all-category-icon />
                        <span>{{ __('filters') }}</span>
                    </button>

                    <div class="relative w-full max-w-[393px]">
                        <input x-on:input.debounce.400ms="isTyped = ($event.target.value != '')" autocomplete="off"
                            wire:model.debounce.500ms="search_ad_val" class="tc-input !w-full max-w-[393px]"
                            type="text" placeholder="Search" name="search">
                        <div x-show="isTyped" x-cloak>
                            @if (count($filter_value) > 0)

                                <div class="search-box" style="display: block">
                                    <ul>
                                        @foreach ($filter_value as $value)
                                            @php
                                                $url = url('/') . '/ad/details/' . $value->slug;
                                            @endphp

                                            <a href="{{ $url }}">
                                                <li>
                                                    {{ Illuminate\Support\Str::limit($value->title, 60) }}
                                                </li>
                                            </a>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <div class="search-box" style="display: none">
                                </div>
                            @endif
                        </div>
                    </div>
                    <input wire:model.debounce.500ms="location" wire:click="$emit('openModal')"
                        class="tc-input max-w-[393px]" type="text" placeholder="Location" readonly>
                    <div class="flex dark:bg-gray-900 dark:border-gray-600 radio-box__wrap">
                        {{-- <label
                            class="py-3 px-5 body-sm-500 hover:bg-primary-50 transition-all duration-300 text-center cursor-pointe all-selected"
                            for="all_con">
                            <input wire:model="seletedFeatured" value="0" type="radio" name="condition"
                                id="all_con" checked class="hidden">
                            <span>{{ __('all') }}</span>
                        </label>
                        <label
                            class="py-3 px-5 body-sm-500 hover:bg-primary-50 transition-all duration-300 text-center cursor-pointer"
                            for="used">
                            <input type="radio" wire:model="seletedFeatured" value="1" name="condition"
                                id="used" class="hidden">
                            <span>{{ __('featured') }}</span>
                        </label>
                        <label
                            class="py-3 px-5 body-sm-500 hover:bg-primary-50 transition-all duration-300 text-center cursor-pointer"
                            for="seletedLatest">
                            <input type="radio" wire:model="seletedFeatured" value="asc" name="seletedLatest"
                                id="seletedLatest" class="hidden">
                            <span>{{ __('latest') }}</span>
                        </label> --}}
                        <label
                            class="py-3 px-5 body-sm-500 dark:text-white hover:bg-primary-50 dark:hover:bg-gray-600 transition-all duration-300 text-center cursor-pointer all-selected"
                            for="all_con">
                            <input wire:model="seletedOption" value="0" type="radio" id="all_con"
                                class="hidden">
                            <span>{{ __('all') }}</span>
                        </label>
                        <label
                            class="py-3 px-5 body-sm-500 dark:text-white hover:bg-primary-50 dark:hover:bg-gray-600 transition-all duration-300 text-center cursor-pointer"
                            for="used">
                            <input type="radio" wire:model="seletedOption" value="1" id="used"
                                class="hidden">
                            <span>{{ __('featured') }}</span>
                        </label>
                        <label
                            class="py-3 px-5 body-sm-500 dark:text-white hover:bg-primary-50 dark:hover:bg-gray-600 transition-all duration-300 text-center cursor-pointer"
                            for="selectedUrgent">
                            <input type="radio" wire:model="seletedOption" value="2" id="selectedUrgent"
                                class="hidden">
                            <span>{{ __('urgent') }}</span>
                        </label>
                        <label
                            class="py-3 px-5 body-sm-500 dark:text-white hover:bg-primary-50 dark:hover:bg-gray-600 transition-all duration-300 text-center cursor-pointer"
                            for="seletedLatest">
                            <input type="radio" wire:model="seletedOption" value="asc" id="seletedLatest"
                                class="hidden">
                            <span>{{ __('latest') }}</span>
                        </label>
                    </div>
                </div>
            </div>
    </section>

    <section x-data="filters" class="dark:bg-gray-800">
        <div class="container pb-8">
            <div class="flex" :class="filter ? 'gap-6' : 'gap-0'">
                <x-frontend.listing.filter-sidebar :brands="$brands" />
                <div class="flex-grow">
                    <div class="body-sm-500 text-gray-700">
                        <ul class="flex flex-wrap gap-x-3 gap-y-2.5 items-center mb-4">
                            <li class="inline-flex gap-1 items-center">
                                @if ($selectedbrand || $dateRange)
                                    <span class="heading-07 text-primary-500 ">{{ __('active_filter') }}:</span>
                                @endif
                            </li>
                            @if ($selectedbrand)
                                <li class="inline-flex gap-1 items-center">
                                    <span class="filter-title text-gray-500"> {{ __('brand') }}:</span>
                                    <span>{{ $selectedbrand }}</span>
                                    <button wire:click="removeSelectedBrand('{{ $selectedbrand }}')"
                                        class="hover:bg-gray-50 transition-all duration-300 p-1 rounded-full">
                                        <span>&times;</span>
                                    </button>
                                </li>
                            @endif
                            @if ($dateRange)
                                <li class="inline-flex gap-1 items-center">
                                    <span class="filter-title text-gray-500">{{ __('posted_within') }}:</span>
                                    <span>{{ $dateRange }} days</span>
                                    <button wire:click="removeSelectedDate('{{ $dateRange }}')"
                                        class="hover:bg-gray-50 transition-all duration-300 p-1 rounded-full">
                                        <span>&times;</span>
                                    </button>
                                </li>
                            @endif
                        </ul>
                    </div>

                    @if ($ads->count() > 0)
                        <div class="w-full flex-grow grid gap-[15px] grid-cols-1 sm:grid-cols-2"
                            :class="{
                                'md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4': filter,
                                'md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5': !filter
                            }">
                            {{-- Top ads  --}}
                            @foreach ($topAds as $ad)
                                <x-frontend.ad-card.card :ad="$ad" :top_ad="true" />
                            @endforeach

                            {{-- Bump up ads --}}
                            @foreach ($bumpUpAds as $ad)
                                <x-frontend.ad-card.card :ad="$ad" :bump_up="true" />
                            @endforeach


                            {{-- Regular ads & google adsense --}}
                            @foreach ($ads as $ad)
                                @if ($loop->index == 2)
                                    @if (advertisementCode('ad_listing_page_right'))
                                        <div class="h-[400px] max-h-[400px]">
                                            {!! advertisementCode('ad_listing_page_right') !!}
                                        </div>
                                    @endif
                                @elseif($loop->index == 6)
                                    @if (advertisementCode('ad_listing_page_left'))
                                        <div class="h-[400px] max-h-[400px]">
                                            {!! advertisementCode('ad_listing_page_left') !!}
                                        </div>
                                    @endif
                                @else
                                    <x-frontend.ad-card.card :featured="$ad->featured" :ad="$ad" />
                                @endif
                            @endforeach

                        </div>
                    @else
                        <div class="w-full">
                            <div class="max-w-[400px] mx-auto">
                                <img src="{{ asset('frontend/images/no-ads-found.png') }}" alt="no ads founds image"
                                    class="w-full">
                            </div>
                            <div class="text-center  space-y-4">
                                <p class="body-base-500 text-gray-700">
                                    {{ __('opps_no_ads_found_related_to_this_filter') }}
                                </p>
                                <h5 class="heading-05 text-gray-900">{{ __('please_try_other_filters') }}</h5>
                            </div>
                        </div>
                    @endif
                    @if (gettype($ads) == 'object' && count($ads) && $showLoadMore)
                        <div class="mt-8 flex items-center justify-center">
                            <button wire:click="loadMore" wire:loading.attr="disabled"
                                class="btn-load-more dark:bg-gray-900 flex shrink-0 p-[0.5rem_1rem] justify-center items-center rounded-[0.375rem] border border-gray-100 dark:border-gray-600 shadow-[0px_1px_2px_0px_rgba(28, 33, 38, 0.05)] heading-08 text-gray-700 dark:text-gray-300 hover:text-white transition-all duration-100 hover:bg-primary-500 mx-auto">
                                <span wire:loading wire:target="loadMore">
                                    {{ __('loading') }}...
                                </span>
                                <span wire:loading.remove>
                                    <span>{{ __('load_more') }}</span>
                                </span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var allLabel = document.querySelector('.all-selected');
            var featuredRadio = document.getElementById('used');
            var latestRadio = document.getElementById('seletedLatest');
            var urgentRadio = document.getElementById('selectedUrgent');

            function toggleAllLabel() {
                if (featuredRadio.checked || latestRadio.checked || urgentRadio.checked) {
                    allLabel.style.display = 'block';
                    console.log(allLabel.style.display);
                } else {
                    allLabel.style.display = 'none';
                    console.log(allLabel.style.display);
                }
            }

            // Initial check on page load
            toggleAllLabel();

            // Add event listeners to radio buttons
            featuredRadio.addEventListener('change', toggleAllLabel);
            latestRadio.addEventListener('change', toggleAllLabel);
            urgentRadio.addEventListener('change', toggleAllLabel);
        });
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
    <style type="text/css">
        .search-box {
            position: absolute;
            top: calc(100% + 10px);
            width: 100%;
            height: 250px;
            z-index: 9999;
            overflow: hidden;
            overflow-y: scroll;
            background: white;
            padding: 12px 0px;
            border-radius: 8px;
            box-shadow: 0px 2px 6px 0px rgba(112, 122, 125, 0.12);
            -ms-overflow-style: none;
            scrollbar-width: none;
            border: 1px solid var(--gray-100);
        }

        .search-box::-webkit-scrollbar {
            display: none;
        }

        .search-box .clear {
            clear: both;
            margin-top: 20px;
        }

        .search-box ul {
            list-style: none;
            width: 100%;
            position: relative;
            margin: 0;
        }

        .search-box ul a {
            padding: 12px 12px 12px 34px;
            margin-bottom: 1px;
            font-size: 16px;
            line-height: 150%;
            cursor: pointer;
            width: 100%;
            display: flex;
            align-items: center;
            position: relative;
            transition: all 0.4s ease-in-out;
        }

        .search-box ul a::after {
            content: url("data:image/svg+xml,%3Csvg width='18' height='18' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
            position: absolute;
            inset-inline-start: 8px;
            top: 50%;
            transform: translateY(-50%);
        }

        .search-box ul a:hover {
            background: var(--primary-50);
            color: var(--primary-500);
        }

        .search-box input[type=text] {
            padding: 5px;
            width: 250px;
            letter-spacing: 1px;
        }
    </style>
</div>
