<aside id="sidebar" class="main-sidebar sidebar-dark-primary elevation-4">
    {{-- style="background-color: {{ $setting->dark_mode ? '' : $setting->sidebar_color }}"> --}}
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ $setting->favicon_image_url }}" alt="{{ __('Logo') }}" class="elevation-3">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-nav-wrapper">
            <!-- Sidebar Menu -->
            <nav class="sidebar-main-nav mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @if ($user->can('dashboard.view'))
                        <x-admin.sidebar-list :linkActive="Route::is('admin.dashboard') ? true : false" route="admin.dashboard" icon="fas fa-tachometer-alt">
                            {{ __('dashboard') }}
                        </x-admin.sidebar-list>
                    @endif

                    <!-- Order Management Start -->
                    <li class="nav-header">{{ __('order_management') }}</li>
                    @if (userCan('order.view'))
                        <li class="nav-item">
                            <a href="{{ route('order.index') }}"
                                class="nav-link {{ Route::is('order.*') ? ' active' : '' }}">
                                <i class="nav-icon fas fa-money-bill"></i>
                                <p>{{ __('order') }}</p>
                            </a>
                        </li>
                    @endif
                    @if (Module::collections()->has('Customer') && userCan('customer.view'))
                        <li class="nav-item">
                            <a href="{{ route('module.customer.index') }}"
                                class="{{ $document_verification_requests > 0 ? 'position-relative' : '' }} nav-link {{ Route::is('module.customer.*') ? ' active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>{{ __('customer') }}</p>
                                @if ($document_verification_requests > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $document_verification_requests }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endif
                    @if (Module::collections()->has('Plan') && userCan('plan.view') && $priceplan_enable)
                        <x-sidebar-list :linkActive="Route::is('module.plan.index') || Route::is('module.plan.create') ? true : false" route="module.plan.index" icon="fas fa-credit-card">
                            {{ __('pricing_plan') }}
                        </x-sidebar-list>
                    @endif
                    <x-sidebar-list :linkActive="Route::is('report.index') ? true : false" route="report.index" icon="fas fa-file">
                        {{ __('seller_report') }}
                    </x-sidebar-list>
                    <!-- Order Management End -->

                    <!-- Ads Management Start -->
                    <li class="nav-header">{{ __('ads_management') }}</li>
                    <x-sidebar-dropdown :linkActive="Route::is('module.ad.*') ? true : false" :subLinkActive="Route::is('module.ad.*') ? true : false" icon="fas fa-store">
                        @slot('title')
                            {{ __('ads') }}
                        @endslot

                        <ul class="nav nav-treeview">
                            @if (Module::collections()->has('Ad') && userCan('ad.view'))
                                <x-sidebar-list :linkActive="Route::is('module.ad.index') && !request('filter_by') && !request('pending_ad') && !request('expired_ad') ? true : false" route="module.ad.index" icon="fas fa-circle">
                                    {{ __('all_listings') }}
                                </x-sidebar-list>
                            @endif

                            @if (Module::collections()->has('Ad') && userCan('ad.view'))
                                <li class="nav-item">
                                    <a href="{{ route('module.ad.index',['filter_by' => 'active']) }}" class="nav-link {{ request('filter_by')== 'active'  ? 'active' : '' }}" >
                                        <i class="nav-icon fas fa-circle"></i>
                                        <p>{{ __('active_ads') }} </p>
                                    </a>
                                </li>
                            @endif

                            @if (Module::collections()->has('Ad') && userCan('ad.view'))
                            <li class="nav-item">
                                <a href="{{ route('module.ad.index',['filter_by' => 'pending']) }}" class="nav-link {{ request('filter_by')== 'pending'  ? 'active' : '' }}" >
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>{{ __('pending_ads') }} </p>
                                </a>
                            </li>
                            @endif

                            @if (Module::collections()->has('Ad') && userCan('ad.view'))
                            <li class="nav-item">
                                <a href="{{ route('module.ad.index',['filter_by' => 'sold']) }}" class="nav-link {{ request('filter_by')== 'sold'  ? 'active' : '' }}" >
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>{{ __('sold_ads') }} </p>
                                </a>
                            </li>
                            @endif

                            @if (Module::collections()->has('Ad') && userCan('ad.view'))
                                <x-sidebar-list :linkActive="Route::is('module.ad.resubmitted-ads') ? true : false" route="module.ad.resubmitted-ads" icon="fas fa-circle">
                                    {{ __('resubmitted_listing') }}
                                </x-sidebar-list>
                            @endif

                        </ul>
                    </x-sidebar-dropdown>

                    @if (Module::collections()->has('Category') && (userCan('category.view') || userCan('subcategory.view')))
                        <x-admin.sidebar-list :linkActive="Route::is('module.category.*') || Route::is('module.subcategory.*') ? true : false" route="module.category.index" icon="fas fa-th">
                            {{ __('category') }}
                        </x-admin.sidebar-list>
                    @endif
                    @if (Module::collections()->has('CustomField') && userCan('custom-field.view'))
                        <x-admin.sidebar-list :linkActive="Route::is('module.custom.field.*') ? true : false" route="module.custom.field.index" icon="fas fa-edit">
                            {{ __('custom_field') }}
                        </x-admin.sidebar-list>
                    @endif
                    @if (Module::collections()->has('Location'))
                        @if (userCan('city.view') || userCan('town.view'))
                            <x-sidebar-dropdown :linkActive="Route::is('module.city.*') || Route::is('module.town.*') ? true : false" :subLinkActive="Route::is('module.city.*') || Route::is('module.town.*') ? true : false" icon="fas fa-location-arrow">
                                @slot('title')
                                    {{ __('location') }}
                                @endslot

                                @if (userCan('city.view'))
                                    <ul class="nav nav-treeview">
                                        <x-sidebar-list :linkActive="Route::is('module.city.*') ? true : false" route="module.city.index"
                                            icon="fas fa-circle">
                                            {{ __('city') }}
                                        </x-sidebar-list>
                                    </ul>
                                @endif
                                @if (userCan('town.view'))
                                    <ul class="nav nav-treeview">
                                        <x-sidebar-list :linkActive="Route::is('module.town.*') ? true : false" route="module.town.index"
                                            icon="fas fa-circle">
                                            {{ __('town') }}
                                        </x-sidebar-list>
                                    </ul>
                                @endif

                            </x-sidebar-dropdown>
                        @endif
                    @endif
                    @if (Module::collections()->has('Brand') && userCan('brand.view'))
                        <x-admin.sidebar-list :linkActive="Route::is('module.brand.*') ? true : false" route="module.brand.index" icon="fas fa-award">
                            {{ __('brand') }}
                        </x-admin.sidebar-list>
                    @endif

                    @if (userCan('ad_report_category.view'))
                        <x-sidebar-list :linkActive="Route::is('ad-report-category.index') ? true : false" route="ad-report-category.index" icon="far fa-list-alt">
                            {{ __('ad_report_category') }}
                        </x-sidebar-list>
                    @endif

                    <x-sidebar-list :linkActive="Route::is('report-ad') ? true : false" route="report-ad" icon="fas fa-list">
                        {{ __('ad_report_list') }}
                    </x-sidebar-list>
                    <!-- Ads Management End -->

                    <x-sidebar-dropdown :linkActive="(Route::is('redeem-points.*') || Route::is('affiliate.*') || Route::is('affiliate-settings.*')) ? true : false" :subLinkActive="Route::is('redeem-points.*') ? true : false" icon="fa fa-handshake">
                        @slot('title')
                            {{ __('affiliate_system') }}
                        @endslot

                        <ul class="nav nav-treeview">
                            <x-sidebar-list :linkActive="Route::is('redeem-points.*') ? true : false" route="redeem-points.index" icon="fas fa-circle">
                                {{ __('redeem_points') }}
                            </x-sidebar-list>
                        </ul>

                        <ul class="nav nav-treeview">
                            <x-sidebar-list :linkActive="Route::is('affiliate.balance.request') ? true : false" route="affiliate.balance.request" icon="fas fa-circle">
                                {{ __('balance_request') }}
                            </x-sidebar-list>
                        </ul>
                       
                        <ul class="nav nav-treeview">
                            <x-sidebar-list :linkActive="Route::is('affiliate.partners') ? true : false" route="affiliate.partners" icon="fas fa-circle">
                                {{ __('affiliate_partners') }}
                            </x-sidebar-list>
                        </ul>

                        <ul class="nav nav-treeview">
                            <x-sidebar-list :linkActive="Route::is('affiliate-settings.*') ? true : false" route="affiliate-settings.index" icon="fas fa-circle">
                                {{ __('affiliate_settings') }}
                            </x-sidebar-list>
                        </ul>
                    </x-sidebar-dropdown>

                   

                    {{-- @if (Module::collections()->has('Map') && userCan('map.view'))
                        <x-admin.sidebar-list :linkActive="Route::is('module.map.*') ? true : false" route="module.map.index" icon="fas fa-map-marker-alt">
                            {{ __('map') }}
                        </x-admin.sidebar-list>
                    @endif --}}

                    <!-- CMS Settings Start -->
                    <li class="nav-header">{{ __('cms_settings') }}</li>

                    <x-admin.sidebar-list :linkActive="Route::is('settings.cms') ? true : false" route="settings.cms" icon="fas fa-paragraph">
                        {{ __('cms') }}
                    </x-admin.sidebar-list>

                    {{-- Newsletter Subscription --}}
                    @if (Module::collections()->has('Newsletter') && $newsletter_enable)
                        @if (userCan('newsletter.view') || userCan('newsletter.mailsend'))
                            <x-admin.sidebar-list :linkActive="Route::is('module.newsletter.*') ? true : false" route="module.newsletter.index"
                                icon="fas fa-envelope-open">
                                {{ __('newsletter') }}
                            </x-admin.sidebar-list>
                        @endif
                    @endif

                    <!-- Blog and Tag -->
                    @if (Module::collections()->has('Blog') && userCan('post.view') && $blog_enable)
                        <x-admin.sidebar-list :linkActive="Route::is('module.post.*') || Route::is('module.postcategory.*') ? true : false" route="module.post.index" icon="fas fa-blog">
                            {{ __('blog') }}
                        </x-admin.sidebar-list>
                    @endif
                    <!-- Blog and Tag End -->

                    @if (Module::collections()->has('Testimonial') && userCan('testimonial.view') && $testimonial_enable)
                        <x-admin.sidebar-list :linkActive="Route::is('module.testimonial.*') ? true : false" route="module.testimonial.index" icon="fas fa-comment">
                            {{ __('testimonial') }}
                        </x-admin.sidebar-list>
                    @endif
                    @if (userCan('faq.view') && $faq_enable)
                        <x-admin.sidebar-list :linkActive="Route::is('module.faq.*') ? true : false" route="module.faq.index" icon="fas fa-question">
                            {{ __('faq') }}
                        </x-admin.sidebar-list>
                    @endif
                    @if ($setting->ads_admin_approval)
                        <form action="{{ route('module.ad.index') }}" method="GET" id="pending_ads_form">
                            <input name="filter_by" type="text" value="pending" hidden>
                            <input name="sort_by" type="text" value="latest" hidden>
                        </form>
                        <button onclick="$('#pending_ads_form').submit();" type="button"
                            class="btn btn-primary mt-4 mx-3 text-white mb-3">
                            {{ __('pending_ads') }}
                        </button>
                    @endif
                    <!-- CMS Settings End -->

                    <!-- Settings Menu Items Start -->

                    {{-- Website Setting --}}
                    <li class="nav-header">{{ __('website_setting') }}</li>
                    <x-admin.sidebar-list :linkActive="Route::is('settings.system') ? true : false" route="settings.system" icon="fas fa-hashtag">
                        {{ __('preferences') }}
                    </x-admin.sidebar-list>
                    <x-admin.sidebar-list :linkActive="Route::is('settings.cookies') ? true : false" route="settings.cookies" icon="fas fa-cookie-bite">
                        {{ __('cookies_alert') }}
                    </x-admin.sidebar-list>
                    <x-admin.sidebar-list :linkActive="Route::is('settings.seo.*') ? true : false" route="settings.seo.index" icon="fas fa-award">
                        {{ __('seo') }} {{ __('settings') }}
                    </x-admin.sidebar-list>
                    <x-admin.sidebar-list :linkActive="Route::is('settings.custom') ? true : false" route="settings.custom" icon="fas fa-tools">
                        {{ __('custom_css_and_JS') }}
                    </x-admin.sidebar-list>

                    {{-- System Setting --}}
                    <li class="nav-header">{{ __('general_settings') }}</li>
                    <x-admin.sidebar-list :linkActive="Route::is('settings.general') || Route::is('settings.general.*') ? true : false" route="settings.general" icon="fas fa-cog">
                        {{ __('site_settings') }}
                    </x-admin.sidebar-list>

                    <x-admin.sidebar-list :linkActive="Route::is('settings.theme') ? true : false" route="settings.theme" icon="fas fa-swatchbook">
                        {{ __('theme_settings') }}
                    </x-admin.sidebar-list>

                    @if ($user->can('admin.view'))
                        <x-admin.sidebar-list :linkActive="Route::is('user.*') || Route::is('role.*') ? true : false" route="user.index" icon="fas fa-users">
                            {{ __('user_role_manage') }}
                        </x-admin.sidebar-list>
                    @endif

                    <x-admin.sidebar-list :linkActive="Route::is('settings.email') ? true : false" route="settings.email" icon="fas fa-envelope">
                        {{ __('SMTP') }}
                    </x-admin.sidebar-list>

                    <x-sidebar-dropdown :linkActive="Route::is('settings.payment') || Route::is('settings.payment.*') ? true : false" :subLinkActive="Route::is('settings.payment') || Route::is('settings.payment.*') ? true : false" icon="fas fa-credit-card">
                        @slot('title')
                            {{ __('payment_gateway') }}
                        @endslot

                        <ul class="nav nav-treeview">
                            <x-sidebar-list :linkActive="Route::is('settings.payment') ? true : false" route="settings.payment" icon="fas fa-circle">
                                {{ __('online_payment') }}
                            </x-sidebar-list>
                        </ul>
                        <ul class="nav nav-treeview">
                            <x-sidebar-list :linkActive="Route::is('settings.payment.manual') ? true : false" route="settings.payment.manual" icon="fas fa-circle">
                                {{ __('offline_payment') }}
                            </x-sidebar-list>
                        </ul>
                    </x-sidebar-dropdown>

                    <x-admin.sidebar-list :linkActive="Route::is('settings.social.login') ? true : false" route="settings.social.login" icon="fab fa-facebook">
                        {{ __('social_login') }}
                    </x-admin.sidebar-list>

                    <x-admin.sidebar-list :linkActive="Route::is('settings.module') ? true : false" route="settings.module" icon="fas fa-cog">
                        {{ __('module') }}
                    </x-admin.sidebar-list>
                    <x-admin.sidebar-list :linkActive="Route::is('advertisement.index') ? true : false" route="advertisement.index" icon="fas fa-ad">
                        {{ __('place_ads') }}
                    </x-admin.sidebar-list>

                    <!-- International Start -->
                    <li class="nav-header">{{ __('international') }}</li>
                        @if ($language_enable)
                        @if (Auth::user()->can('setting.view') || Auth::user()->can('setting.update'))
                            <x-admin.sidebar-list :linkActive="Route::is('language.*') ? true : false" route="language.index" icon="fas fa-globe-asia">
                                {{ __('language') }}
                            </x-admin.sidebar-list>
                        @endif
                    @endif

                    <x-admin.sidebar-list :linkActive="Route::is('module.currency.*') ? true : false" route="module.currency.index" icon="fas fa-dollar-sign">
                        {{ __('currency') }}
                    </x-admin.sidebar-list>

                    <x-sidebar-dropdown :linkActive="Route::is('settings.payment') || Route::is('settings.payment.*') ? true : false" :subLinkActive="Route::is('settings.payment') || Route::is('settings.payment.*') ? true : false" icon="fas fa-credit-card">
                        @slot('title')
                            {{ __('location') }}
                        @endslot

                        <ul class="nav nav-treeview">
                            <x-sidebar-list :linkActive="Route::is('settings.location.country.country') ? true : false" route="settings.location.country.country" icon="fas fa-circle">
                                {{ __('country') }}
                            </x-sidebar-list>
                        </ul>
                        <ul class="nav nav-treeview">
                            <x-sidebar-list :linkActive="Route::is('settings.location.state.state') ? true : false" route="settings.location.state.state" icon="fas fa-circle">
                                {{ __('state') }}
                            </x-sidebar-list>
                        </ul>
                        <ul class="nav nav-treeview">
                            <x-sidebar-list :linkActive="Route::is('settings.location.city') ? true : false" route="settings.location.city" icon="fas fa-circle">
                                {{ __('city_lga') }}
                            </x-sidebar-list>
                        </ul>
                    </x-sidebar-dropdown>

                    <li class="nav-header">{{ __('system_setting') }}</li>

                    <x-admin.sidebar-list :linkActive="Route::is('settings.upgrade') ? true : false" route="settings.upgrade" icon="fas fa-upload">
                        {{ __('upgrade_guide') }}
                    </x-admin.sidebar-list>
                    <li class="nav-item">
                        <a href="/log-viewer" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Log Viewer</p>
                        </a>
                    </li>

                    {{-- Mobile App Setting --}}
                    @if (Module::collections()->has('MobileApp'))
                        <li class="nav-header">{{ __('mobile_app_settings') }}</li>
                        <x-admin.sidebar-list :linkActive="Route::is('mobile-config.*') ? true : false" route="mobile-config.index" icon="fas fa-mobile">
                            {{ __('mobile_app_config') }}
                        </x-admin.sidebar-list>
                    @endif

                    <li class="nav-header">{{ __('support_center') }}</li>

                    <li class="nav-item">
                        <a href="https://www.templatecookie.com/get-support" class="nav-link" target="_blank">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>{{ __('complaints') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://codecanyon.net/downloads" class="nav-link" target="_blank">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>{{ __('feedbacks') }}</p>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- Sidebar Menu -->
            <nav class="mt-2 nav-footer" style="border-top: 1px solid gray; padding-top: 20px;">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a target="_blank" href="/" class="nav-link"
                            style="background-color: #007bff; color: #fff;">
                            <i class="nav-icon fas fa-globe"></i>
                            <p>{{ __('visit_website') }}</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="javascript:void(0" class="nav-link"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>{{ __('logout') }} </p>
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                            class="d-none invisible">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
