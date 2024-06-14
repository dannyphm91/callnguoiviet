<div class="bg-white rounded-lg p-3">
    <div class="relative">
        <div x-data="{ isTyped: false }" @click.outside="isTyped = false">
            <form action="{{ route('frontend.ads') }}" method="GET" class=bg-white rounded-lg p-3">
                <div class="flex sm:flex-row flex-col gap-3 items-center">
                    <label for="text" class="w-full relative">
                        <i class="absolute left-3 top-1/2 -translate-y-1/2">
                            <x-svg.search-icon stroke="var(--primary-500)" />
                        </i>
                        <input id="text" type="text" placeholder="Search" class="tc-input !w-full ps-12"
                            x-on:input.debounce.500ms="isTyped = ($event.target.value != '')" autocomplete="off"
                            wire:model.debounce.500ms="search_ad_val" class="group-hover:bg-gray-50" autocomplete="off">
                        <div x-show="isTyped" x-cloak>
                            @if (count($filter_ads) > 0)

                                <div class="search-box" style="display: block">
                                    <ul>
                                        @foreach ($filter_ads as $ads)
                                            @php
                                                $url = url('/') . '/ad/details/' . $ads->slug;
                                            @endphp

                                            <a href="{{ $url }}">
                                                <li>
                                                    {{ Illuminate\Support\Str::limit($ads->title, 70) }}
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
                    </label>
                    <label for="location" class="w-full relative">

                        <i class="absolute left-3 top-1/2 -translate-y-1/2">
                            <x-svg.search-location-icon stroke="var(--primary-500)" />
                        </i>
                        <input wire:model="location_mobile" wire:click="OpenModalMobile" type="text" placeholder="Location" class="tc-input !w-full ps-12" readonly>
                        @if (@$location_search_active_country)
                            <input id="country" type="text" value="{{ @$location_search_active_country }}"
                                name="country" placeholder="country" class="hidden">
                        @endif
                        @if (@$location_search_active_state)
                            <input id="state" type="text" value="{{ @$location_search_active_state }}"
                                name="state" placeholder="state" class="hidden">
                        @endif
                        @if (@$location_search_active_city)
                            <input id="city" type="text" value="{{ @$location_search_active_city }}"
                                name="city" placeholder="city" class="hidden">
                        @endif
                    </label>
                </div>
                <button type="submit"
                    class="mt-3 text-white bg-primary-800 heading-07 rounded-lg px-4 py-2 hover:bg-primary-700">{{ __('search') }}</button>
            </form>
        </div>
    </div>
</div>
<style type="text/css">
    .search-box {
        position: absolute;
        top: calc(100% + 10px);
        width: 100% !important;
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
