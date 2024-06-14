<div
    class="bg-white dark:bg-gray-900 hidden lg:block sticky top-6 w-full sm:max-w-[360px] sm:min-w-[360px] min-w-[330px] max-w-[300px] border border-gray-100 dark:border-gray-600 shadow-[0px_4px_8px_0px_rgba(28,33,38,0.08)] rounded-xl">
    @php
        $user = auth('user')->user();
    @endphp

    <div class="p-6 flex gap-4 items-center border-b border-gray-100 dark:border-gray-600">
        <img class="w-14 h-14 rounded-full object-cover" src="{{ $user->image_url }}" alt="">
        <div>
            <div class="flex gap-1">
                <h2 class="heading-07 mb-0.5 text-gray-900 dark:text-white">{{ $user->name }}</h2>
                @if (auth('user')->user()->document_verified && auth('user')->user()->document_verified->status == 'approved')
                    <span><x-svg.account-verification.verified-badge /></span>
                @endif
            </div>
            <p class="body-md-400 text-gray-600 dark:text-gray-300">{{ $user->email }}</p>
        </div>
    </div>
    <ul class="py-6">
        <li>
            <a href="{{ !request()->routeIs('frontend.dashboard') ? route('frontend.dashboard') : 'javascript:void(0)' }}"
                class="sidebar-menu-link {{ request()->routeIs('frontend.dashboard') ? 'active' : '' }}">
                <x-svg.overview-icon />
                <span>{{ __('overview') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ route('frontend.seller.profile', authUser()->username) }}"
                class="sidebar-menu-link {{ request()->routeIs('frontend.seller-dashboard') ? 'active' : '' }}">
                <x-svg.user-icon width="24" height="24" stroke="currentColor" />
                <span>{{ __('public_profile') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ !request()->routeIs('frontend.post') ? route('frontend.post') : 'javascript:void(0)' }}"
                class="sidebar-menu-link {{ request()->routeIs('frontend.post') ? 'active' : '' }}">
                <x-svg.image-select-icon />
                <span>{{ __('post_listing') }}</span>
            </a>
        </li>

        <li>
            <a href="{{ !request()->routeIs('frontend.my.listing') ? route('frontend.my.listing') : 'javascript:void(0)' }}"
                class="sidebar-menu-link {{ request()->routeIs('frontend.my.listing') ? 'active' : '' }}">
                <x-svg.list-icon width="24" height="24" stroke="currentColor" />
                <span>{{ __('my_ads') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ !request()->routeIs('frontend.resubmission.list') ? route('frontend.resubmission.list') : 'javascript:void(0)' }}"
                class="sidebar-menu-link {{ request()->routeIs('frontend.resubmission.list') ? 'active' : '' }}">
                <x-svg.list-icon width="24" height="24" stroke="currentColor" />
                <span>{{ __('resubmission_request') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ !request()->routeIs('frontend.favorite.list') ? route('frontend.favorite.list') : 'javascript:void(0)' }}"
                class="sidebar-menu-link {{ request()->routeIs('favorite-listing') ? 'active' : '' }}">
                <x-svg.heart-icon fill="none" stroke="currentColor" />
                <span>{{ __('favorite_ads') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ !request()->routeIs('frontend.message') ? route('frontend.message') : 'javascript:void(0)' }}"
                class="sidebar-menu-link {{ request()->routeIs('message') ? 'active' : '' }}">
                <x-svg.message-icon width="24" height="24" stroke="currentColor" />
                <span>{{ __('message') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('frontend.plans-billing') }}"
                class="sidebar-menu-link {{ request()->routeIs('frontend.plans-billing') ? 'active' : '' }}">
                <x-svg.invoice-icon width="24" height="24" stroke="currentColor" />
                <span>{{ __('plans_billing') }}</span>
            </a>
        </li>
        <li>
            <a href="{{route('frontend.wallet')}}" class="sidebar-menu-link {{ request()->routeIs('frontend.wallet') ? 'active' : '' }}">
                <x-svg.heroicons.share />

                @if (authUser()?->affiliate?->affiliate_code != null)
                    <span>{{__('affiliate_system')}}</span>
                @else
                    <span>{{__('become_an_affiliator')}}</span>
                @endif
            </a>
        </li>
        <li>
            <a href="/dashboard/verify-account"
                class="sidebar-menu-link {{ request()->routeIs('frontend.verify.account') ? 'active' : '' }}">
                <x-svg.user-check-icon width="24" height="24" stroke="currentColor" />
                <span>{{ __('verify_account') }}</span>
            </a>
        </li>
        <li>
            <a href="{{ !request()->routeIs('frontend.account-setting') ? route('frontend.account-setting') : 'javascript:void(0)' }}"
                class="sidebar-menu-link {{ request()->routeIs('frontend.account-setting') ? 'active' : '' }}">
                <x-svg.setting-icon />
                <span>{{ __('account_setting') }}</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0"
                onclick="event.preventDefault();document.getElementById('sidebar-logout-form').submit();"
                class="sidebar-menu-link">
                <x-svg.logout-icon />
                <span>{{ __('logout') }}</span>
            </a>
        </li>
        <form id="sidebar-logout-form" action="{{ route('frontend.logout') }}" method="POST" class="hidden invisible">
            @csrf
        </form>

    </ul>
</div>
