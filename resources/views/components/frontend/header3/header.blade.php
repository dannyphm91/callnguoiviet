<header x-data="{ mobileMenu: false }" class="bg-primary-600 dark:bg-primary-900">
    <div class="container">
        <div class="flex gap-3 justify-between items-center py-2 border-b border-primary-500">
            <div class="flex gap-2 items-center">
                @if ($setting->currency_changing && count($headerCurrencies))
                    @php
                        $currency_count = count($headerCurrencies) && count($headerCurrencies) > 1;
                        $current_currency_code = currentCurrencyCode();
                        $current_currency_symbol = currentCurrencySymbol();
                    @endphp
                    <span class="relative" x-data="{ currencyDropdown: false }" @click.outside="currencyDropdown = false">
                        <button @click="currencyDropdown = !currencyDropdown"
                            class="py-1.5 px-3 bg-gray-50 dark:bg-gray-900 dark:text-white rounded-[5px] inline-flex gap-1 items-center md:heading-07"
                            :class="currencyDropdown ? '' : ''" type="button">
                            <span>
                                {{ $current_currency_code }}
                            </span>
                            <x-svg.arrow-down-icon />
                        </button>

                        @if ($currency_count)
                            <div class="currDropdown !top-[calc(100%+8px)] !start-0" x-show="currencyDropdown"
                                x-transition x-cloak @click.outside="currencyDropdown=false">
                                <ul
                                    class="bg-white dark:bg-gray-800 flex flex-col py-2 rounded-md border border-gray-100 dark:border-gray-600 drop-shadow-[drop-shadow(0px_8px_8px_rgba(28,33,38,0.03))_drop-shadow(0px_20px_24px_rgba(28,33,38,0.08))] min-w-[12rem] relative">
                                    @foreach ($headerCurrencies as $currency)
                                        <li>
                                            <a href="{{ route('changeCurrency', $currency->code) }}"
                                                class="hover:bg-primary-50 hover:dark:bg-gray-600 py-1 px-4 transition-all duration-300 flex text-gray-700 dark:text-gray-300 body-md-400 {{ $current_currency_code === $currency->code ? 'bg-primary-50 dark:bg-gray-600' : '' }}">
                                                {{ $currency->code }} ({{ $currency->symbol }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </span>
                @endif

                @if ($language_enable && $setting->language_changing)
                    <span class="relative" x-data="{ langDropdown: false }" @click.outside="langDropdown = false">
                        <button @click="langDropdown = !langDropdown"
                            class="py-1.5 px-3 bg-gray-50 dark:bg-gray-900 dark:text-white rounded-[5px] inline-flex gap-1 items-center md:heading-07"
                            :class="langDropdown ? '' : ''" type="button">
                            <span>
                                {{ currentLanguage() ? currentLanguage()->name : 'Default' }}
                            </span>
                            <x-svg.arrow-down-icon />
                        </button>
                        <!-- Dropdown menu -->
                        <div class="langDropdown !top-[calc(100%+8px)] !start-0" x-show="langDropdown" x-transition
                            x-cloak @click.outside="langDropdown=false">
                            <ul
                                class="bg-white dark:bg-gray-800 flex flex-col py-2 rounded-md border border-gray-100 dark:border-gray-600 drop-shadow-[drop-shadow(0px_8px_8px_rgba(28,33,38,0.03))_drop-shadow(0px_20px_24px_rgba(28,33,38,0.08))] min-w-[12rem] relative after:absolute after:border after:border-r-transparent after:border-b-transparent">
                                @foreach ($languages as $lang)
                                    <li>
                                        <a href="{{ route('changeLanguage', $lang->code) }}"
                                            class="hover:bg-primary-50 hover:dark:bg-gray-600 py-1 px-4 transition-all duration-300 flex text-gray-700 dark:text-gray-300 body-md-400 {{ currentLanguage()->name == $lang->name ? 'bg-primary-50 dark:bg-gray-600' : '' }}">
                                            {{ $lang->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </span>
                @endif
            </div>
            <div class="flex gap-2 items-center">
                <button id="darkModeToggle" class="bg-white dark:bg-gray-900 text-primary-500 dark:text-primary-50 border border-gray-100 dark:border-gray-600 p-1 rounded-full">
                    <span id="icon">
                        <!-- Custom SVG for Light Mode -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        </svg>
                    </span>
                </button>
                <button class="lg:hidden" @click="mobileMenu = true">
                    <x-svg.menu-icon stroke="white" />
                </button>
            </div>
        </div>
        <div class="py-3 md:pt-6 md:pb-8 flex justify-between items-center">
            <div class="flex gap-2 md:gap-4 items-center">
                <a href="/" class="sm:max-w-[200px] min-[380px]:max-w-[120px] max-w-[100px]">
                    <img src="{{ asset($setting->white_logo_url) }}" alt="">
                </a>
                <button type="button" data-modal-target="locationModal" data-modal-toggle="locationModal"
                    class="bg-primary-500 py-1 md:px-3 px-1.5 rounded-[40px] hidden sm:inline-flex gap-1.5 items-center text-xs md:heading-07 transition-all duration-300 text-white/80 hover:text-white">
                    <x-svg.search-location-icon width="20" height="20" />
                    @if (selected_country())
                        <span>{{ selected_country()->name }}</span>
                    @else
                        <span>{{ __('all_country') }}</span>
                    @endif
                </button>
            </div>

            <div class="flex gap-2.5 sm:gap-6 items-center">
                <ul class="flex gap-6 items-center">
                    <li class="hidden lg:block">
                        <a href="{{ route('frontend.ads') }}"
                            class="py-3 text-white/70 inline-flex gap-2 items-center hover:text-white">
                            <x-svg.list-bullet />
                            <span>{{ __('all_listings') }}</span>
                        </a>
                    </li>
                    <li class="hidden lg:block">
                        <a href="{{ route('frontend.favorite.list') }}"
                            class="py-3 text-white/70 inline-flex gap-2 items-center hover:text-white">
                            <x-svg.outline-heart />
                            <span>{{ __('favorite_listing') }}</span>
                        </a>
                    </li>
                    <div class=" flex-none inline-flex gap-1 sm:gap-3 md:gap-4  items-center">
                        @if (auth('user')->check())
                            {{-- <x-frontend.header.notification-panel /> --}}
                            <x-frontend.header.message-panel />
                            <span class="relative cursor-pointer" x-data="{ userDropdown: false }" @click.outside="userDropdown = false">
                                <img @click="userDropdown = !userDropdown"
                                    class="w-6 sm:w-10 h-6 sm:h-10 rounded-full object-cover"
                                    src="{{ authUser()->image_url }}" />
                                <div class="absolute z-50 ltr:right-0 rtl:left-0 top-11 mt-1 min-w-[120px]" x-cloak
                                    x-show="userDropdown" x-transition>
                                    <ul
                                        class="min-w-max bg-white flex flex-col py-2 rounded-md border border-gray-100 drop-shadow-[drop-shadow(0px_8px_8px_rgba(28,33,38,0.03))_drop-shadow(0px_20px_24px_rgba(28,33,38,0.08))] relative after:absolute after:border after:border-r-transparent after:border-b-transparent after:border-gray-200 after:rounded ltr:after:right-3 rtl:after:left-3 after:bg-white after:top-[-7.8px] after:h-4 after:w-4 after:transform after:rotate-[45deg] after:content-['']">
                                        <li>
                                            <a href="{{ route('frontend.dashboard') }}"
                                                class="hover:bg-primary-50 py-2 px-6 transition-all duration-300 flex text-gray-700 body-sm-400 items-center gap-3">
                                                <x-svg.overview-icon width="20" height="20" />{{ __('dashboard') }}</a>
                                        </li>

                                        <li>
                                        <a href="{{ !request()->routeIs('frontend.my.listing') ? route('frontend.my.listing') : 'javascript:void(0)' }}"
                                            class="hover:bg-primary-50 py-2 px-6 transition-all duration-300 flex text-gray-700 body-sm-400 items-center gap-3 {{ request()->routeIs('frontend.favorite.list') ? 'active' : '' }}">
                                            <x-svg.list-icon width="20" height="20" stroke="currentColor" />
                                            <span>{{ __('my_ads') }}</span>
                                        </a>
                                        </li>
                                        <li>
                                        <a href="{{ !request()->routeIs('frontend.favorite.list') ? route('frontend.favorite.list') : 'javascript:void(0)' }}"
                                            class="hover:bg-primary-50 py-2 px-6 transition-all duration-300 flex text-gray-700 body-sm-400 items-center gap-3 {{ request()->routeIs('favorite-listing') ? 'active' : '' }}">
                                            <x-svg.heart-icon width="20" height="20" fill="none" stroke="currentColor" />
                                            <span>{{ __('favorite_ads') }}</span>
                                        </a>
                                        </li>
                                        <li>
                                        <a href="{{ route('frontend.plans-billing') }}"
                                            class="hover:bg-primary-50 py-2 px-6 transition-all duration-300 flex text-gray-700 body-sm-400 items-center gap-3 {{ request()->routeIs('frontend.plans-billing') ? 'active' : '' }}">
                                            <x-svg.invoice-icon width="20" height="20" stroke="currentColor" />
                                            <span>{{ __('plans_billing') }}</span>
                                        </a>
                                        </li>
                                        <li>
                                        <a href="{{route('frontend.wallet')}}"
                                            class="hover:bg-primary-50 py-2 px-6 transition-all duration-300 flex text-gray-700 body-sm-400 items-center gap-3 {{ request()->routeIs('frontend.wallet') ? 'active' : '' }}">
                                            <x-svg.heroicons.share width="20" height="20" stroke="currentColor"/>

                                            @if (authUser()?->affiliate?->affiliate_code != null)
                                                <span>{{__('affiliate_system')}}</span>
                                            @else
                                                <span>{{__('become_an_affiliator')}}</span>
                                            @endif
                                        </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('frontend.account-setting') }}"
                                                class="hover:bg-primary-50 py-2 px-6 transition-all duration-300 flex text-gray-700 body-sm-400 items-center gap-3">
                                                <x-svg.setting-icon width="20" height="20" />
                                                {{ __('settings') }}
                                            </a>
                                        </li>
                                        <li>
                                        <a href="javascript:void(0)"
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                            class="hover:bg-primary-50 py-2 px-6 transition-all duration-300 flex text-gray-700 body-sm-400 items-center gap-3">
                                            <x-svg.logout-icon class="w-5 h-5 me-2" width="20" height="20" />
                                            {{ __('logout') }}
                                        </a>

                                        </li>
                                        <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST"
                                            class="hidden invisible">
                                            @csrf
                                        </form>
                                    </ul>
                                </div>
                            </span>
                        @else
                            <a href="/login"
                                class="inline-flex gap-1.5 items-center transition-all duration-300 text-white hover:text-primary-50 md:heading-07 heading-08">
                                <x-svg.user-icon stroke="#fff" />
                                <span>{{ __('login') }}</span>
                            </a>
                        @endif

                </ul>
                <a href="{{ route('frontend.post') }}"
                    class="md:py-3 py-1.5 md:px-5 px-2 inline-flex gap-1 text-xs md:text-sm md:gap-2 items-center bg-white dark:bg-gray-900 text-primary-500 dark:text-primary-300 hover:bg-primary-50 hover:text-primary-600 transition-all duration-300 rounded-lg">
                    <x-svg.solid-plus-circle class="w-4 h-4 sm:w-6 sm:h-6" />
                    <span>{{ __('post') }}</span>
                </a>
            </div>
        </div>
        <div class="pb-10">
            <h2 class="heading-05 text-center text-white mb-4">{{ activeAds() }} {{ __('active_ads') }}</h2>
            <livewire:nav-search-component landing="home3" />
        </div>
    </div>
    <!-- City List Modal Start -->
    <div id="locationModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden bg-black/50 fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full mx-4">
            <!-- Modal content -->
            <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow pb-6">

                <h2 class="text-gray-900 heading-07 px-6 pt-6 pb-3">{{ __('select_your_country') }}</h2>
                <form class="px-6 pb-3">
                    <div>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <x-svg.search-icon stroke="var(--primary-500)" />
                            </div>
                            <input id="search-input" type="text" placeholder="Search Country" name="location"
                                value="" autocomplete="off"
                                class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>
                </form>
                <div class="city-list h-80 px-6 pb-6 overflow-y-auto no-scrollbar overflow-x-auto">
                    <ul>
                        <li>
                            <a class="flex gap-2 px-3 py-2 hover:bg-primary-50 transition-all duration-300 text-gray-600 dark:text-gray-200 body-base-400"
                                href="{{ route('frontend.set.country', ['country' => 'all_country']) }}">
                                <i class="fa-solid fa-globe"></i>
                                {{ __('all_country') }}
                            </a>
                        </li>
                        @foreach ($headerCountries as $country)
                            <li id="lang-dropdown-item">
                                <a class="flex gap-2 px-3 py-2 hover:bg-primary-50 transition-all duration-300 text-gray-600 dark:text-gray-200 body-base-400"
                                    href="{{ route('frontend.set.country', ['country' => $country->id]) }}">
                                    <i class="flag-icon {{ $country->icon }}"></i>
                                    {{ $country->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <!-- City List Modal End -->

    <!-- responsive header -->
    <div class="responsive-menu lg:hidden p-6 z-[9999] fixed top-0 ltr:left-0 rtl:right-0 max-w-[300px] w-full h-full overflow-y-auto bg-white transition-all duration-300"
        :class="mobileMenu ? 'translate-x-0 visible' : '-translate-x-full rtl:translate-x-full invisible'">
        <div class="flex flex-col gap-3">
            <div class="flex justify-end items-center">

                <button @click="mobileMenu = false">
                    <x-svg.cross-icon />
                </button>
            </div>
            <h3 class="heading-07 text-gray-900">{{ __('pages') }}</h3>
            <ul class="flex flex-col gap-3">
                <li>
                    <a href="/"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">Home</a>
                </li>
                <li>
                    <a href="{{ route('frontend.ads') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">View
                        Ads</a>
                </li>
                <li>
                    <a href="{{ route('frontend.blog') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">Blogs</a>
                </li>
                <li>
                    <a href="{{ route('frontend.priceplan') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">Pricing
                        Plan</a>
                </li>
                <li>
                    <a href="{{ route('frontend.contact') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">Contact</a>
                </li>
            </ul>
        </div>
    </div>
    <div @click="mobileMenu = false"
        class="mobile-overlay fixed top-0 left-0 h-full w-full bg-black/50 z-[999] transition-all duration-300 lg:hidden"
        :class="mobileMenu ? 'visible' : 'invisible'"></div>
</header>
