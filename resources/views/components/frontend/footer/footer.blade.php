<footer
    class="bg-gray-50 dark:bg-black border-t border-gray-100 dark:border-gray-400">
    <div class="container py-16">
        <div class="flex flex-wrap gap-6 items-start">
            <div class="widget max-w-[424px] flex-grow">
                <a href="/" class="mb-4 inline-flex">
                    <img id="logo" src="{{ asset($setting->logo_image) }}" alt="">
                </a>
                <p class="mb-4 body-md-400 text-gray-700 dark:text-white max-w-[372px]">
                    {{ __('adlisting_is_a_trusted_directory_listing_companyrelied_upon_by_millions_of_people') }}</p>
                <a href="{{ route('frontend.priceplan') }}" class="btn-primary">
                    <span>{{ __('get_membership') }}</span>
                </a>
            </div>
            <div class="widget flex-grow">
                <h3 class="widget-title heading-06 text-gray-900 dark:text-white mb-3.5">{{ __('quick_links') }}</h3>
                <ul class="flex flex-col gap-3.5">
                    <li><a href="{{ route('frontend.ads') }}" class="footer-link dark:text-gray-100 heading-07 capitalize">{{ __('listing') }}</a></li>
                    <li><a href="{{ route('frontend.promotions') }}" class="footer-link dark:text-gray-100 heading-07 capitalize">{{ __('promotions') }}</a></li>
                    <li><a href="{{ route('frontend.about') }}" class="footer-link dark:text-gray-100 heading-07">{{ __('about_us') }}</a>
                    </li>
                    <li><a href="{{ route('frontend.blog') }}" class="footer-link dark:text-gray-100 heading-07">
                            {{ __('blog') }}</a>
                    </li>
                    <li><a href="{{ route('frontend.priceplan') }}"
                            class="footer-link dark:text-gray-100 heading-07">{{ __('pricing_plan') }}</a></li>
                </ul>
            </div>
            <div class="widget flex-grow">
                <h3 class="widget-title heading-06 text-gray-900 dark:text-white mb-3.5">{{ __('supports') }}</h3>
                <ul class="flex flex-col gap-3.5">
                    <li><a href="{{ route('frontend.contact') }}"
                            class="footer-link dark:text-gray-100 heading-07">{{ __('contact') }}</a></li>
                    <li><a href="{{ route('frontend.faq') }}"
                            class="footer-link dark:text-gray-100 heading-07">{{ __('faqs') }}</a>
                    </li>
                    <li><a href="{{ route('frontend.terms') }}"
                            class="footer-link dark:text-gray-100 heading-07">{{ __('terms_condition') }}</a>
                    </li>
                    <li><a href="{{ route('frontend.privacy') }}"
                            class="footer-link dark:text-gray-100 heading-07">{{ __('privacy_policy') }}</a></li>
                    <li><a href="{{ route('frontend.refund') }}"
                            class="footer-link dark:text-gray-100 heading-07">{{ __('refund_policy') }}</a></li>
                </ul>
            </div>
            <div class="widget flex-grow">
                @if ($mobile_setting->ios_download_url || $mobile_setting->android_download_url)
                    <h3 class="widget-title mb-3 caption-03 text-gray-900 dark:text-white">{{ __('download_our_app') }}
                    </h3>
                    <div class="flex flex-wrap gap-3 items-center mb-6">

                        @if ($mobile_setting->ios_download_url)
                            <a target="_blank" href="{{ asset($mobile_setting->ios_download_url) }}"
                                class="app-store-btn dark:text-white inline-flex gap-3 items-center py-3 px-4 rounded-lg shadow-[0px_4px_6px_-2px_rgba(28,33,38,0.03)] bg-white dark:bg-gray-700">
                                <x-svg.apple-icon />
                                <div>
                                    <p class="body-xs-500 text-gray-500 dark:text-gray-300">{{ __('get_it_now') }}</p>
                                    <p class="body-md-500 text-gray-900 dark:text-white">{{ __('app_store') }}</p>
                                </div>
                            </a>
                        @endif

                        @if ($mobile_setting->android_download_url)
                            <a target="_blank" href="{{ asset($mobile_setting->android_download_url) }}"
                                class="app-store-btn dark:text-white inline-flex gap-3 items-center py-3 px-4 rounded-lg shadow-[0px_4px_6px_-2px_rgba(28,33,38,0.03)] bg-white dark:bg-gray-700">
                                <x-svg.google-play-icon />
                                <div>
                                    <p class="body-xs-500 text-gray-500 dark:text-gray-300">{{ __('get_it_now') }}</p>
                                    <p class="body-md-500 text-gray-900 dark:text-white">{{ __('google_play') }}</p>
                                </div>
                            </a>
                        @endif

                    </div>
                @endif

                <ul class="footer-social flex gap-2.5 items-center">
                    @if ($setting->facebook)
                        <li>
                            <a target="_blank" href="{{ $setting->facebook }}"
                                class="w-10 h-10 rounded-full inline-flex justify-center items-center bg-white">
                                <x-svg.facebook-icon fill="#555B61" />
                            </a>
                        </li>
                    @endif
                    @if ($setting->twitter)
                        <li>
                            <a target="_blank" href="{{ $setting->twitter }}"
                                class="w-10 h-10 rounded-full inline-flex justify-center items-center bg-white">
                                <x-svg.twitter-icon fill="#555B61" />
                            </a>
                        </li>
                    @endif
                    @if ($setting->instagram)
                        <li>
                            <a target="_blank" href="{{ $setting->instagram }}"
                                class="w-10 h-10 rounded-full inline-flex justify-center items-center bg-white">
                                <x-svg.instagram-icon fill="#555B61" />
                            </a>
                        </li>
                    @endif
                    @if ($setting->youtube)
                        <li>
                            <a target="_blank" href="{{ $setting->youtube }}"
                                class="w-10 h-10 rounded-full inline-flex justify-center items-center bg-white">
                                <x-svg.youtube-icon fill="#555B61" />
                            </a>
                        </li>
                    @endif
                    @if ($setting->linkdin)
                        <li>
                            <a target="_blank" href="{{ $setting->linkdin }}"
                                class="w-10 h-10 rounded-full inline-flex justify-center items-center bg-white">
                                <x-svg.linkedin-icon fill="#555B61" />
                            </a>
                        </li>
                    @endif
                    @if ($setting->whatsapp)
                        <li>
                            <a target="_blank" href="{{ $setting->whatsapp }}"
                                class="w-10 h-10 rounded-full inline-flex justify-center items-center bg-white">
                                <x-svg.whatsapp-icon fill="#555B61" />
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>
        <div class="mt-12">
            <p class="text-center body-md-400 text-gray-700 dark:text-gray-100">
                @php
                    $string = preg_replace('/<\/?p>/i', '', cms('footer_text'));
                @endphp
                {!! $string !!}
            </p>
        </div>
    </div>
</footer>
