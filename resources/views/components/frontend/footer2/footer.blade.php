<footer class="bg-black border-t border-gray-100 dark:border-gray-900">
    <div class="container py-12">
        <div class="flex justify-between flex-wrap gap-6 items-center pb-8">
            <div class="widget max-w-[424px] flex-grow">
                <a href="/" class="mb-4 inline-flex">
                    <img src="{{ asset($setting->white_logo_url) }}" alt="">
                </a>
                <ul class="flex flex-wrap gap-4">
                    <li><a href="{{ route('frontend.ads') }}" class="heading-07 text-gray-400 hover:text-white">{{ __('listing') }}</a>
                    </li>
                    <li><a href="{{ route('frontend.about') }}" class="heading-07 text-gray-400 hover:text-white">{{ __('about_us') }}</a>
                    </li>
                    <li><a href="{{ route('frontend.blog') }}" class="heading-07 text-gray-400 hover:text-white"> {{ __('blog') }}</a>
                    </li>
                    <li><a href="{{ route('frontend.priceplan') }}" class="heading-07 text-gray-400 hover:text-white">{{ __('pricing_plan') }}</a></li>
                </ul>
            </div>
            <div class="widget">
                @if ($mobile_setting->ios_download_url || $mobile_setting->android_download_url)
                    <div class="flex flex-wrap gap-3 items-center">

                        @if ($mobile_setting->ios_download_url)
                            <a target="_blank" href="{{ asset($mobile_setting->ios_download_url) }}"
                                class="app-store-btn !border-gray-700 inline-flex gap-3 items-center py-3 px-4 rounded-lg shadow-[0px_4px_6px_-2px_rgba(28,33,38,0.03)] bg-gray-800">
                                <x-svg.apple-icon fill="white" />
                                <div>
                                    <p class="body-xs-500 text-gray-500">{{ __('get_it_now') }}</p>
                                    <p class="body-md-500 text-white">{{ __('app_store') }}</p>
                                </div>
                            </a>
                        @endif

                        @if ($mobile_setting->android_download_url)
                            <a target="_blank" href="{{ asset($mobile_setting->android_download_url) }}"
                                class="app-store-btn !border-gray-700 inline-flex gap-3 items-center py-3 px-4 rounded-lg shadow-[0px_4px_6px_-2px_rgba(28,33,38,0.03)] bg-gray-800">
                                <x-svg.google-play-icon fill="white" />
                                <div>
                                    <p class="body-xs-500 text-gray-500">{{ __('get_it_now') }}</p>
                                    <p class="body-md-500 text-white">{{ __('google_play') }}</p>
                                </div>
                            </a>
                        @endif

                    </div>
                @endif
            </div>
        </div>
        <div class="flex flex-wrap gap-4 justify-between items-center py-8 border-t border-gray-800">
            <p class="text-center body-md-400 text-gray-700 dark:text-gray-200">
                @php
                    $string = preg_replace('/<\/?p>/i', '', cms('footer_text'));
                @endphp
                {!! $string !!}
            </p>
            <ul class="footer-social flex gap-2.5 items-center">
                @if ($setting->facebook)
                    <li>
                        <a target="_blank" href="{{ $setting->facebook }}"
                            class="w-10 h-10 rounded-full text-gray-400 hover:text-white inline-flex justify-center items-center bg-gray-900 hover:!bg-primary-500 border border-gray-800">
                            <x-svg.facebook-icon fill="currentColor" />
                        </a>
                    </li>
                @endif
                @if ($setting->twitter)
                    <li>
                        <a target="_blank" href="{{ $setting->twitter }}"
                            class="w-10 h-10 rounded-full text-gray-400 hover:text-white inline-flex justify-center items-center bg-gray-900 hover:!bg-primary-500 border border-gray-800">
                            <x-svg.twitter-icon fill="currentColor" />
                        </a>
                    </li>
                @endif
                @if ($setting->instagram)
                    <li>
                        <a target="_blank" href="{{ $setting->instagram }}"
                            class="w-10 h-10 rounded-full text-gray-400 hover:text-white inline-flex justify-center items-center bg-gray-900 hover:!bg-primary-500 border border-gray-800">
                            <x-svg.instagram-icon fill="currentColor" />
                        </a>
                    </li>
                @endif
                @if ($setting->youtube)
                    <li>
                        <a target="_blank" href="{{ $setting->youtube }}"
                            class="w-10 h-10 rounded-full text-gray-400 hover:text-white inline-flex justify-center items-center bg-gray-900 hover:!bg-primary-500 border border-gray-800">
                            <x-svg.youtube-icon fill="currentColor" />
                        </a>
                    </li>
                @endif
                @if ($setting->linkdin)
                    <li>
                        <a target="_blank" href="{{ $setting->linkdin }}"
                            class="w-10 h-10 rounded-full text-gray-400 hover:text-white inline-flex justify-center items-center bg-gray-900 hover:!bg-primary-500 border border-gray-800">
                            <x-svg.linkedin-icon fill="currentColor" />
                        </a>
                    </li>
                @endif
                @if ($setting->whatsapp)
                    <li>
                        <a target="_blank" href="{{ $setting->whatsapp }}"
                            class="w-10 h-10 rounded-full text-gray-400 hover:text-white inline-flex justify-center items-center bg-gray-900 hover:!bg-primary-500 border border-gray-800">
                            <x-svg.whatsapp-icon fill="currentColor" />
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</footer>
