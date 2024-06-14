<header x-data="{ mobileMenu: false }" class="dark:bg-black">
    <div class="container">
        <div class="flex gap-3 justify-between items-center py-2 border-b border-gray-50 lg:hidden">
            <button @click="mobileMenu = true">
                <x-svg.menu-icon stroke="currentColor" class="text-black dark:text-white" />
            </button>
            <div class="flex gap-2 items-center">
                @if ($setting->currency_changing && count($headerCurrencies))
                    @php
                        $currency_count = count($headerCurrencies) && count($headerCurrencies) > 1;
                        $current_currency_code = currentCurrencyCode();
                        $current_currency_symbol = currentCurrencySymbol();
                    @endphp
                    <span class="relative" x-data="{ currencyDropdown: false }" @click.outside="currencyDropdown = false">
                        <button @click="currencyDropdown = !currencyDropdown"
                            class="py-1.5 px-3 bg-gray-50 dark:bg-gray-300 rounded-[5px] inline-flex gap-1 items-center md:heading-07"
                            :class="currencyDropdown ? '' : ''" type="button">
                            <span>
                                {{ $current_currency_code }}
                            </span>
                            <x-svg.arrow-down-icon />
                        </button>

                        @if ($currency_count)
                            <div class="currDropdown !top-[calc(100%+8px)]" x-show="currencyDropdown" x-transition x-cloak
                                @click.outside="currencyDropdown=false">
                                <ul
                                    class="bg-white dark:bg-gray-300 flex flex-col py-2 rounded-md border border-gray-100 dark:border-gray-600 drop-shadow-[drop-shadow(0px_8px_8px_rgba(28,33,38,0.03))_drop-shadow(0px_20px_24px_rgba(28,33,38,0.08))] min-w-[12rem] relative">
                                    @foreach ($headerCurrencies as $currency)
                                        <li>
                                            <a href="{{ route('changeCurrency', $currency->code) }}"
                                                class="hover:bg-primary-50 hover:dark:bg-gray-600 py-1 px-4 transition-all duration-300 flex text-gray-700 dark:text-gray-900 body-md-400 {{ $current_currency_code === $currency->code ? 'bg-primary-50 dark:bg-gray-600' : '' }}">
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
                            class="py-1.5 px-3 bg-gray-50 dark:bg-gray-300 rounded-[5px] inline-flex gap-1 items-center md:heading-07"
                            :class="langDropdown ? '' : ''" type="button">
                            <span>
                                {{ currentLanguage() ? currentLanguage()->name : 'Default' }}
                            </span>
                            <x-svg.arrow-down-icon />
                        </button>
                        <!-- Dropdown menu -->
                        <div class="langDropdown !top-[calc(100%+8px)]" x-show="langDropdown" x-transition x-cloak
                            @click.outside="langDropdown=false">
                            <ul
                                class="bg-white dark:bg-gray-300 flex flex-col py-2 rounded-md border border-gray-100 dark:border-gray-300 drop-shadow-[drop-shadow(0px_8px_8px_rgba(28,33,38,0.03))_drop-shadow(0px_20px_24px_rgba(28,33,38,0.08))] min-w-[12rem] relative">
                                @foreach ($languages as $lang)
                                    <li>
                                        <a href="{{ route('changeLanguage', $lang->code) }}"
                                            class="hover:bg-primary-50 dark:hover:bg-gray-700 py-1 px-4 transition-all duration-300 flex text-gray-700 dark:text-gray-100 body-md-400 {{ currentLanguage()->name == $lang->name ? 'bg-primary-50 dark:bg-gray-700' : '' }}">
                                            {{ $lang->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </span>
                @endif
            </div>
        </div>
        <div class="py-4 flex justify-between items-center">
            <div class="flex gap-3 items-center">
                <a href="/" class="inline-flex">
                    <img class="sm:max-w-[200px] max-[380px]:max-w-[120px] max-w-[100px]" id="logo"
                        src="{{ asset($setting->white_logo_url) }}" alt="">
                </a>
                <div class="hidden lg:block">
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
                                <div class="currDropdown" x-show="currencyDropdown" x-transition x-cloak
                                    @click.outside="currencyDropdown=false">
                                    <ul
                                        class="bg-white dark:bg-gray-800 flex flex-col py-2 rounded-md border border-gray-100 dark:border-gray-400 drop-shadow-[drop-shadow(0px_8px_8px_rgba(28,33,38,0.03))_drop-shadow(0px_20px_24px_rgba(28,33,38,0.08))] min-w-[12rem] relative">
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
                                class="py-1.5 px-3 bg-gray-50 dark:bg-gray-900 dark:text-white rounded-[5px] inline-flex gap-1 items-center heading-07"
                                :class="langDropdown ? '' : ''" type="button">
                                <span>
                                    {{ currentLanguage() ? currentLanguage()->name : 'Default' }}
                                </span>
                                <x-svg.arrow-down-icon />
                            </button>
                            <!-- Dropdown menu -->
                            <div class="langDropdown " x-show="langDropdown" x-transition x-cloak
                                @click.outside="langDropdown=false">
                                <ul
                                    class="bg-white dark:bg-gray-800 flex flex-col py-2 rounded-md border border-gray-100 dark:border-gray-400 drop-shadow-[drop-shadow(0px_8px_8px_rgba(28,33,38,0.03))_drop-shadow(0px_20px_24px_rgba(28,33,38,0.08))] min-w-[12rem] relative">
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
            </div>
            <div class="flex gap-6 items-center">
                <ul class="hidden lg:flex lg:gap-4 xl:gap-6 items-center heading-07 text-gray-600">
                    <li>
                        <a href="/" class="hover:text-gray-900 dark:text-gray-300 hover:dark:text-white">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.ads') }}" class="hover:text-gray-900 dark:text-gray-300 hover:dark:text-white">View Ads</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.blog') }}" class="hover:text-gray-900 dark:text-gray-300 hover:dark:text-white">Blogs</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.priceplan') }}" class="hover:text-gray-900 dark:text-gray-300 hover:dark:text-white">Pricing Plan</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.contact') }}" class="hover:text-gray-900 dark:text-gray-300 hover:dark:text-white">Contact</a>
                    </li>
                </ul>
                <div class="flex items-center gap-2">
                    <button id="darkModeToggle"
                        class="bg-white dark:bg-gray-300 text-primary-500 dark:text-primary-700 border border-gray-100 dark:border-gray-700 p-1 rounded-full">
                        <span id="icon">
                            <!-- Custom SVG for Light Mode -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                            </svg>
                        </span>
                    </button>
                    @if (auth('user')->check())
                        {{-- <x-frontend.header.notification-panel /> --}}
                        <div class="relative inline-flex" x-data="{ messagePanel: false }" @click.outside="messagePanel = false">
                            <a href="{{ route('frontend.message') }}"
                                class="transition-all duration-300 text-gray-700 dark:text-gray-100 hover:text-gray-900">
                                <x-frontend.icons.chat />
                            </a>
                        </div>
                        <span class="relative cursor-pointer" x-data="{ userDropdown: false }"
                            @click.outside="userDropdown = false">
                            <img @click="userDropdown = !userDropdown"
                                class="w-6 sm:w-10 h-6 sm:h-10 rounded-full object-cover"
                                src="{{ authUser()->image_url }}" />
                            <div class="absolute z-50 ltr:right-0 rtl:left-0 top-11 mt-1 min-w-[120px]" x-cloak
                                x-show="userDropdown" x-transition>
                                <ul
                                    class="bg-white flex flex-col py-2 rounded-md border border-gray-100 drop-shadow-[drop-shadow(0px_8px_8px_rgba(28,33,38,0.03))_drop-shadow(0px_20px_24px_rgba(28,33,38,0.08))] min-w-[12rem] relative ">
                                    <li>
                                        <a href="{{ route('frontend.dashboard') }}"
                                            class="hover:bg-primary-50 py-1 px-4 transition-all duration-300 flex text-gray-700 body-md-400">{{ __('dashboard') }}</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('frontend.account-setting') }}"
                                            class="hover:bg-primary-50 py-1 px-4 transition-all duration-300 flex text-gray-700 body-md-400">
                                            {{ __('settings') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0"
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                            class="hover:bg-primary-50 py-1 px-4 transition-all duration-300 flex text-gray-700 body-md-400">{{ __('logout') }}
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
                        <a href="/login" class="btn-white dark:!text-white max-[640px]:px-2 max-[640px]:py-1">
                            Login
                        </a>
                    @endif
                    <a href="{{ route('frontend.post') }}" class="btn-primary max-[400px]:hidden">
                        <x-svg.solid-plus-circle />
                        <span>Post Ad</span>
                    </a>
                </div>
            </div>
        </div>
    </div>


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
