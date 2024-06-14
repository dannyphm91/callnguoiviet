<div class="responsive-menu lg:hidden p-6 z-[9999] fixed top-0 ltr:left-0 rtl:right-0 max-w-[300px] w-full h-full overflow-y-auto bg-white transition-all duration-300 rtl:translate-x-full ltr:-translate-x-full invisible"
    :class="mobileMenu ? 'active' : ''">
    <div class="flex flex-col gap-3">
        <div class="flex justify-end items-center">

            <button @click="mobileMenu = false">
                <x-svg.cross-icon />
            </button>
        </div>
        {{-- <div>
            <form action="{{ route('frontend.ads') }}" method="GET" class="w-full space-y-2">
                <div>
                    <label for="text"
                        class="w-full  focus-within:ring-1 focus-within:ring-primary-500  flex items-center border border-gray-100 search overflow-hidden rounded-lg pl-2">

                        <x-svg.search-icon />

                        <input id=text type="text" placeholder="Search" value="{{ request('headerSearch') }}"
                            name="headerSearch" class=" focus:ring-0 border-0 w-full bg-transparent">
                    </label>
                </div>

                <div>
                    <label for="location"
                        class="w-full  focus-within:ring-1 focus-within:ring-primary-500  flex items-center border border-gray-100 search overflow-hidden rounded-lg pl-2">

                        <x-svg.search-location-icon stroke="var(--primary-500)" />

                        <input id="location" type="text" value="{{ request('headerLocation') }}"
                            name="headerLocation" placeholder="Location"
                            class=" focus:ring-0 border-0 w-full bg-transparent">
                    </label>
                </div>

                <div>
                    <button type="submit"
                        class="w-full ltr:right-0 rtl:left-0 py-2.5 bg-gray-700 text-white heading-07 rounded-lg px-4 hover:bg-primary-700">{{ __('search') }}</button>
                </div>

            </form>
        </div>
        <div class="bg-gray-100 h-[1px] my-3"></div> --}}
        <div class="space-y-3">
            <h3 class="heading-07 text-gray-900">{{ __('category') }}</h3>
            <ul class="flex flex-col gap-3">
                @foreach (loadCategoriesSubcategories() as $category)
                    <li>
                        <a href="{{ route('frontend.ads.category', $category['slug']) }}"
                            class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                            {{ $category['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-gray-100 h-[1px] my-3"></div>
        <h3 class="heading-07 text-gray-900">{{ __('pages') }}</h3>
        <ul class="flex flex-col gap-3">
            {{-- <li>
                <a href="#"
                    class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">Create
                    Business Account</a>
            </li> --}}
            <li>
                <a href="{{ route('frontend.priceplan') }}"
                    class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                    {{ __('price_plan') }}
                </a>
            </li>
        </ul>
        {{-- @if (auth('user')->check())
            <div class="bg-gray-100 h-[1px] my-3"></div>
            <h3 class="heading-07 text-gray-900">{{ __('dashboard') }}</h3>
            <ul class="flex flex-col gap-3">
                <li>
                    <a href="{{ route('frontend.dashboard') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                        <span>{{ __('overview') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('frontend.seller.profile', authUser()->username) }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                        <span>{{ __('public_profile') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('frontend.post') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                        <span>{{ __('post_listing') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('frontend.my.listing') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                        <span>{{ __('my_ads') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.my.listing') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                        <span>{{ __('favorite_ads') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.message') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                        <span>{{ __('message') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.priceplan') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                        <span>{{ __('plans_billing') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.verify.account') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                        <span>{{ __('verify_account') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.account-setting') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                        <span>{{ __('account_setting') }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0"
                        onclick="event.preventDefault();document.getElementById('menubar-logout-form').submit();"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                        <span>{{ __('logout') }}</span>
                    </a>
                </li>
                <form id="menubar-logout-form" action="{{ route('frontend.logout') }}" method="POST"
                    class="hidden invisible">
                    @csrf
                </form>
            </ul>
        @endif --}}
    </div>
</div>
<div @click="mobileMenu = false"
    class="mobile-overlay fixed top-0 left-0 h-full w-full bg-black/50 z-[999] transition-all duration-300 invisible lg:hidden"
    :class="mobileMenu ? 'active' : ''"></div>
