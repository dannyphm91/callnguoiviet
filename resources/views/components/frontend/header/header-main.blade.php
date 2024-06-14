<style>
    .header-main {
        background-color: {{ $setting->frontend_primary_color }} !important;
    }

    .header-bottom {
        background-color: {{ $setting->frontend_secondary_color }} !important;

    }

    footer {
        background-color: {{ $setting->frontend_secondary_color }} !important;

    }

    .header-top {
        background-color: {{ $setting->frontend_secondary_color }} !important;
    }

    .btn-primary {
        background-color: {{ $setting->frontend_primary_color }} !important;

    }
</style>
<div class="header-main py-3 md:py-4 bg-primary-500 dark:bg-primary-800" x-data="{ openModal: false, openCity: false, location: '' }">
    <div class="container">
        <div class="flex gap-2 justify-between items-center">
            <a href="{{ route('frontend.index') }}">
                <img class="lg:max-w-[220px] max-w-[114px] w-full" src="{{ $setting->white_logo_url }}" alt="">
            </a>
            {{-- @livewire('nav-search-component') --}}
            <livewire:nav-search-component landing="home1" />

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
                                        <x-svg.heart-icon width="20" height="20" fill="none"
                                            stroke="currentColor" />
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
                                    <a href="{{ route('frontend.wallet') }}"
                                        class="hover:bg-primary-50 py-2 px-6 transition-all duration-300 flex text-gray-700 body-sm-400 items-center gap-3 {{ request()->routeIs('frontend.wallet') ? 'active' : '' }}">
                                        <x-svg.heroicons.share width="20" height="20" stroke="currentColor" />

                                        @if (authUser()?->affiliate?->affiliate_code != null)
                                            <span>{{ __('affiliate_system') }}</span>
                                        @else
                                            <span>{{ __('become_an_affiliator') }}</span>
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
                <a href="{{ route('frontend.post') }}"
                    class="inline-flex sm:gap-2 gap-1 items-center transition-all duration-300 bg-white hover:bg-primary-50 py-1 md:py-2 lg:py-3 px-1.5 md:px-3 lg:px-5 rounded-md  heading-08 text-primary-500 hover:text-primary-700">
                    <x-svg.plus-circle-icon />
                    <span>{{ __('post_listing') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
