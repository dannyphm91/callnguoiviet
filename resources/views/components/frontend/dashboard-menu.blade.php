<div class="responsive-menu lg:hidden p-6 z-[9999] fixed top-0 ltr:left-0 rtl:right-0 w-full min-w-[300px] max-w-[300px] h-full overflow-y-auto bg-white transition-all duration-300 rtl:translate-x-full ltr:-translate-x-full invisible"
    :class="dashboardMenu ? 'active' : ''">
    <div class="flex flex-col gap-3">
        <div class="flex justify-end items-center">

            <button @click="dashboardMenu = false">
                <x-svg.cross-icon />
            </button>
        </div>
        @if (auth('user')->check())
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
                    <a href="{{ route('frontend.resubmission.list') }}"
                        class="body-md-400 text-gray-700 hover:text-primary-500 transition-all duration-300">
                        <span>{{ __('resubmission_request') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.favorite.list') }}"
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
                    <a href="{{ route('frontend.plans-billing') }}"
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
        @endif
    </div>
</div>
<div @click="dashboardMenu = false"
    class="mobile-overlay fixed top-0 left-0 h-full w-full bg-black/50 z-[999] transition-all duration-300 invisible lg:hidden"
    :class="dashboardMenu ? 'active' : ''"></div>
