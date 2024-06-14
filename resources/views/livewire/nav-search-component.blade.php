<div class="flex-grow flex justify-center" x-data="{ 'open': @entangle('location_search_modal').defer }">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">
    <div class="w-full max-w-[488px] xl:max-w-[625px]">
        <div x-data="{ isTyped: false }" class="relative">
            <form action="{{ route('frontend.ads') }}" method="GET"
                class="relative {{ $landing == 'home1' ? 'hidden lg:flex': 'flex flex-col gap-3 sm:gap-0 sm:flex-row' }} flex-grow w-full overflow-hidden flex-nowrap header-form group">
                <label for="text" class="w-full search overflow-hidden {{ $landing == 'home1' ? 'rtl:rounded-r-lg ltr:rounded-l-lg' : 'rounded-lg sm:ltr:rounded-r-none sm:rtl:rounded-l-none sm:rtl:rounded-r-lg sm:ltr:rounded-l-lg' }}">

                    <x-svg.search-icon stroke="var(--primary-500)" />

                    <input id="text" type="text" placeholder="Search"
                        x-on:input.debounce.500ms="isTyped = ($event.target.value != '')" autocomplete="off"
                        wire:model.debounce.500ms="search_ad_val" class="group-hover:bg-gray-50" autocomplete="off">
                </label>
                <label for="location" class="w-full bg-white group-hover:bg-gray-50 cursor-pointer overflow-hidden {{ $landing == 'home1' ? 'ltr:rounded-r-lg rtl:rounded-l-lg' : 'rounded-lg sm:ltr:rounded-l-none sm:rtl:rounded-r-none ltr:rounded-r-lg rtl:rounded-l-lg' }} location">

                    <x-svg.search-location-icon stroke="var(--primary-500)" />
                    <span @click="open = true, $wire.openModal()" x-transection
                        class="group-hover:bg-gray-50 bg-white w-full block text-gray-500"
                        text="location">{{ $search ? Str::limit($search, 20) : __('location') }}</span>
                    @if (@$location_search_active_country)
                        <input id="country" type="text" value="{{ @$location_search_active_country }}"
                            name="country" placeholder="country" class="hidden">
                    @endif
                    @if (@$location_search_active_state)
                        <input id="state" type="text" value="{{ @$location_search_active_state }}" name="state"
                            placeholder="state" class="hidden">
                    @endif
                    @if (@$location_search_active_city)
                        <input id="city" type="text" value="{{ @$location_search_active_city }}" name="city"
                            placeholder="city" class="hidden">
                    @endif
                </label>
                <button type="submit" class=" {{ $landing == 'home1' ? 'absolute': '' }} top-0 ltr:right-0 rtl:left-0 py-2.5 bg-gray-700 text-white heading-07 rounded-lg px-4 hover:bg-primary-700">{{ __('search') }}</button>
            </form>
            <div x-show="isTyped" x-cloak @click.outside="isTyped = false">
                @if (count($filter_ads) > 0)
                    <div class="half-search-box {{ $landing == 'home3' ? 'full' : '' }}" style="display: block">
                        <ul>
                            @foreach ($filter_ads as $ads)
                                @php
                                    $url = url('/') . '/ad/details/' . $ads->slug;
                                @endphp

                                <a href="{{ $url }}">
                                    <li>
                                        {{ Illuminate\Support\Str::limit($ads->title, 50) }}
                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="half-search-box" style="display: none">
                    </div>
                @endif
            </div>
        </div>
        <!-- search location -->
        <div x-show="open" style="display: none">
            <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[60] w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white dark:bg-gray-700 dark:border dark:border-gray-400 rounded-lg shadow pb-6" @click.outside="open = false">
                    @if ($location_search_active_country == '')
                        <h2 class="text-gray-900 dark:text-white heading-05 px-6 pt-4">{{ __('Location') }}</h2>
                        <form class="px-6 pb-2 pt-2">
                            <div>
                                <div class="relative mt-2 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-svg.search-icon stroke="var(--primary-500)" />
                                    </div>
                                    <input wire:keyup="search('Country')" wire:model="location_search_country_input"
                                        id="search-input" type="text" placeholder="Search Country" name="location"
                                        value="" autocomplete="off"
                                        class="block w-full rounded-md border-0 py-3 pl-10 dark:bg-gray-500 dark:placeholder:text-gray-300 hover:bg-primary-50 transition-all duration-300 text-gray-900 dark:text-white ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </form>
                        <div class="city-list h-80 px-6 pb-6 overflow-y-auto overflow-x-auto me-5">
                            <ul wire:loading.remove>
                                @foreach ($location_search_countries as $country)
                                    <li wire:click='getStates({{ $country->id }}, "{{ $country->name }}")'
                                        class="cursor-pointer flex justify-between py-3 border-b border-gray-100 transition-all duration-300 text-gray-600 dark:text-gray-300 hover:text-primary-500 heading-07">
                                        <span class="inline-flex gap-2">
                                            <i class="flag-icon {{ $country->icon }}"></i>
                                            {{ $country->name }}
                                        </span>
                                        <i class="fa fa-chevron-right"></i>
                                    </li>
                                @endforeach
                            </ul>
                            {{-- See All Countries --}}
                            @if ($see_all_country_btn)
                                <div class="flex justify-center items-center mt-10">
                                    <div wire:loading.remove class="flex gap-x-2 items-center">
                                        <img class="h-3" src="{{ asset('frontend/icons/down.svg') }}">
                                        <p wire:click="seeAllCountry" class="text-slate-500 cursor-pointer">
                                            {{ __('see_all_countries') }}</p>
                                    </div>
                                    <div class="flex items-center justify-center">
                                        <div wire:loading wire:target="seeAllCountry" role="status">
                                            <svg aria-hidden="true"
                                                class="w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                    fill="currentFill" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div wire:loading.flex wire:target="openModal" class="justify-center items-center h-64">
                                <svg aria-hidden="true"
                                    class="w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                            </div>
                        </div>
                    @endif
                    @if ($location_search_active_country != '' && $location_search_active_state == '')
                        <div class="flex justify-between items-center px-6 pt-6 pb-3">
                            <div class="flex gap-2 items-center text-gray-900 heading-07">
                                <h2><a href="javascript:void(0)"
                                        wire:click="gotoCountries()">{{ __('location') }}</a>
                                </h2>
                                <img class="h-3" src="{{ asset('frontend/icons/right.svg') }}" alt=">">
                                <h2 class="text-primary-500">{{ $location_search_active_country }}</h2>
                            </div>
                            <button class="flex gap-2 items-center" wire:click="back('country')">
                                <img class="h-3" src="{{ asset('frontend/icons/left.svg') }}" alt="<">
                                <h2>{{ __('go_back') }}</h2>
                            </button>
                        </div>
                        <form class="px-6 pb-3">
                            <div>
                                <div class="relative mt-2 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-svg.search-icon stroke="var(--primary-500)" />
                                    </div>
                                    <input wire:keyup="search('State')" wire:model="location_search_state_input"
                                        id="search-input" type="text" placeholder="Search State" name="location"
                                        value="" autocomplete="off"
                                        class="block w-full rounded-md border-0 py-3 pl-10 hover:bg-primary-50 transition-all duration-300 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </form>
                        <div class="city-list h-80 px-6 pb-6 overflow-y-auto overflow-x-auto me-5">
                            <ul class="flex flex-col justify-center">
                                @forelse ($location_search_states as $state)
                                    <li wire:click='getCities({{ $state->id }}, "{{ $state->name }}")'
                                        class="{{ $location_search_active_state == $state->name ? 'text-primary-500' : '' }} cursor-pointer flex justify-between py-3 border-b border-gray-100 transition-all duration-300 text-gray-600 hover:text-primary-500 heading-07">
                                        {{ $state->name }}
                                    </li>
                                @empty
                                    <li class="w-full self-center">
                                        <div class="max-w-[100px] mx-auto">
                                            <img src="{{ asset('frontend/images/404.png') }}"
                                                alt="no ads founds image" class="w-full">
                                        </div>
                                        <div class="text-center  space-y-4">
                                            <p class="body-base-500 text-gray-700">
                                                {{ __('Opps. No state found related to this filter') }}
                                            </p>
                                            <h5 class="heading-05 text-gray-900">{{ __('Please try other filters.') }}
                                            </h5>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>

                            {{-- Loading On Click --}}
                            <div class="flex justify-center items-center">
                                <div wire:loading wire:target="getCities" role="status">
                                    <div class="flex items-center justify-center">
                                        <svg aria-hidden="true"
                                            class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="currentColor" />
                                            <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentFill" />
                                        </svg>
                                        <p class="ps-3 text-slate-500">{{ __('loading...') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($location_search_active_state != '')
                        <div class="flex justify-between items-center px-6 pt-6 pb-3">
                            <div class="flex gap-2 items-center text-gray-900 heading-07">
                                <h2><a href="javascript:void(0)"
                                        wire:click="gotoCountries()">{{ __('location') }}</a></h2>
                                <img class="h-3" src="{{ asset('frontend/icons/right.svg') }}" alt=">">
                                <h2 class="text-primary-500"><a href="javascript:void(0)"
                                        wire:click="back('state')">{{ $location_search_active_country }}</a></h2>
                                <img class="h-3" src="{{ asset('frontend/icons/right.svg') }}" alt=">">
                                <h2 class="text-primary-500">{{ $location_search_active_state }}</h2>
                            </div>
                            <button class="flex gap-2 items-center" wire:click="back('state')">
                                <img class="h-3" src="{{ asset('frontend/icons/left.svg') }}" alt="<">
                                <h2>{{ __('go_back') }}</h2>
                            </button>
                        </div>
                        <form class="px-6 pb-3">
                            <div>
                                <div class="relative mt-2 rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <x-svg.search-icon stroke="var(--primary-500)" />
                                    </div>
                                    <input wire:keyup="search('City')" wire:model="location_search_city_input"
                                        id="search-input" type="text" placeholder="Search City" name="location"
                                        value="" autocomplete="off"
                                        class="block w-full rounded-md border-0 py-3 pl-10 hover:bg-primary-50 transition-all duration-300 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </form>
                        <div class="city-list h-80 px-6 pb-6 overflow-y-auto overflow-x-auto me-5">
                            <ul>
                                @forelse ($location_search_cities as $city)
                                    <li wire:click="setCity({{ $city->id }}, '{{ $city->name }}')"
                                        class="{{ $location_search_active_city == $city->name ? 'text-primary-500' : '' }} cursor-pointer flex justify-between py-3 border-b border-gray-100 transition-all duration-300 text-gray-600 hover:text-primary-500 heading-07">
                                        {{ $city->name }}
                                    </li>
                                @empty
                                    <li class="w-full self-center">
                                        <div class="max-w-[100px] mx-auto">
                                            <img src="https://adlisting.test/frontend/images/no-ads-found.png"
                                                alt="no ads founds image" class="w-full">
                                        </div>
                                        <div class="text-center  space-y-4">
                                            <p class="body-base-500 text-gray-700">
                                                {{ __('Opps. No city found related to this filter') }}
                                            </p>
                                            <h5 class="heading-05 text-gray-900">{{ __('Please try other filters.') }}
                                            </h5>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>

                            {{-- Loading On Click --}}
                            <div class="flex justify-center items-center">
                                <div wire:loading wire:target="setCity" role="status">
                                    <div class="flex items-center justify-center">
                                        <svg aria-hidden="true"
                                            class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                fill="currentColor" />
                                            <path
                                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                fill="currentFill" />
                                        </svg>
                                        <p class="ps-3 text-slate-500">{{ __('loading...') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <button @click="open = false"
                    class="absolute -top-4 -right-4 bg-white hover:bg-primary-100 transition-all duration-300 p-3 rounded-full border border-primary-100">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18M6 6L18 18" stroke="#161719" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <div class="fixed top-0 left-0 bg-black/50 z-20 w-full h-full">
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .half-search-box {
        position: absolute;
        top: calc(100% + 10px);
        width: 50%;
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

    .half-search-box.full {
        width: 100%;
    }

    .half-search-box::-webkit-scrollbar {
        display: none;
    }

    .half-search-box .clear {
        clear: both;
        margin-top: 20px;
    }

    .half-search-box ul {
        list-style: none;
        width: 100%;
        position: relative;
        margin: 0;
    }

    .half-search-box ul a {
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

    .half-search-box ul a::after {
        content: url("data:image/svg+xml,%3Csvg width='18' height='18' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M21 21L16.65 16.65M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
        position: absolute;
        inset-inline-start: 8px;
        top: 50%;
        transform: translateY(-50%);
    }

    .half-search-box ul a:hover {
        background: var(--primary-50);
        color: var(--primary-500);
    }

    .half-search-box input[type=text] {
        padding: 5px;
        width: 250px;
        letter-spacing: 1px;
    }
</style>
