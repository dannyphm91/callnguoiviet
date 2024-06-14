@extends('frontend.layouts.app')

@section('title', __('promotions'))

@section('content')

    <div>
        <x-frontend.breadcrumb.breadcrumb :links="[['url' => '#', 'text' => __('promotions')]]" />

        <!-- Promotions page Section start  -->
        <section class="py-16">
            <div class="container">
                <div class="flex flex-col md:flex-row gap-6 md:items-center">
                    <div class="md:w-2/5 flex justify-center items-center border border-gray-100 dark:border-gray-600 rounded-xl shadow-lg p-6 flex-grow">
                        @if ($cms->promotion_banner_img)
                            <img class="w-full rounded" src="{{ asset(url($cms->promotion_banner_img)) }}" alt="" class="max-w-[400px] md:min-w-[400px] min-w-[300px] min-h-[240px]">
                        @else
                            <img class="w-full rounded" src="{{ asset('frontend/images/promotions-img/promotion-banner.jpg') }}" alt="" class="max-w-[400px] md:min-w-[400px] min-w-[300px] min-h-[240px]">
                        @endif
                    </div>
                    <div class="md:w-3/5 flex flex-col gap-5 md:ps-12">
                        <h3 class="heading-04 text-primary-500">
                            {{ $promotionTitle ? $promotionTitle : $cms->promotion_banner_title ?? __('no_promotion_title_found') }}
                        </h3>
                        <p class="body-base-400 leading-6 text-gray-600 dark:text-gray-300">
                            {!! $promotionText ? $promotionText : $cms->promotion_banner_text ?? __('no_promotion_content_found') !!}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="sticky top-0 bg-primary-500 text-white">
            <div class="container">
                <div class="md:grid grid-cols-5 flex overflow-x-auto">
                    <a href="#featured"
                        class="promoted-item flex flex-col min-w-max gap-4 justify-center items-center p-5 hover:bg-primary-50 hover:text-gray-900 transition-all duration-300 cursor-pointer">
                        <h3>
                            {{ $featuredTitle ? $featuredTitle : $cms->featured_title ?? __('featured_listing') }}
                        </h3>
                    </a>
                    <a href="#urgent"
                        class="promoted-item flex flex-col min-w-max gap-4 justify-center items-center p-5 hover:bg-primary-50 hover:text-gray-900 transition-all duration-300 cursor-pointer">
                        <h3>
                            {{ $urgentTitle ? $urgentTitle : $cms->urgent_title ?? __('urgent_listing') }}
                        </h3>
                    </a>
                    <a href="#highlighted"
                        class="promoted-item flex flex-col min-w-max gap-4 justify-center items-center p-5 hover:bg-primary-50 hover:text-gray-900 transition-all duration-300 cursor-pointer">
                        <h3>
                            {{ $highlightTitle ? $highlightTitle : $cms->highlight_title ?? __('highlight_listing') }}
                        </h3>
                    </a>
                    <a href="#topad"
                        class="promoted-item flex flex-col min-w-max gap-4 justify-center items-center p-5 hover:bg-primary-50 hover:text-gray-900 transition-all duration-300 cursor-pointer">
                        <h3>
                            {{ $topTitle ? $topTitle : $cms->top_title ?? __('top_listing') }}
                        </h3>
                    </a>
                    <a href="#bumpup"
                        class="promoted-item flex flex-col min-w-max gap-4 justify-center items-center p-5 hover:bg-primary-50 hover:text-gray-900 transition-all duration-300 cursor-pointer">
                        <h3>
                            {{ $bumpUpTitle ? $bumpUpTitle : $cms->bump_up_title ?? __('bump_up_listing') }}
                        </h3>
                    </a>
                </div>
            </div>
        </section>

        <!-- featured section -->
        <section id="featured" class="py-16 dark:bg-gray-900">
            <div class="container">
                <div class="flex md:flex-row md:items-center flex-col gap-6">
                    <div class="md:w-3/5 flex flex-col gap-3 items-start md:pe-12">
                        <span class="inline-block bg-gray-500 px-6 py-2 heading-07 text-white mb-8">
                            {{ $featuredTitle ? $featuredTitle : $cms->featured_title ?? __('featured_listing') }}
                        </span>
                        <div>
                            {!! $featuredText ? $featuredText : $cms->featured_text ?? __('no_featured_content_found') !!}
                        </div>
                    </div>
                    <div class="md:w-2/5 flex-grow">
                        @if ($cms->featured_img)
                            <img class="max-w-full" src="{{ asset(url($cms->featured_img)) }}" alt="" class="max-w-[400px] md:min-w-[400px] min-w-[300px] min-h-[240px]">
                        @else
                            <img class="max-w-full" src="{{ asset('frontend/images/promotions-img/featured.jpg') }}" alt="" class="max-w-[400px] md:min-w-[400px] min-w-[300px] min-h-[240px]">
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- urgent section -->
        <section id="urgent" class="py-16 bg-primary-50 dark:bg-gray-800">
            <div class="container">
                <div class="flex md:flex-row md:items-center flex-col gap-6">
                    <div class="md:w-2/5 flex-grow">
                        @if ($cms->urgent_img)
                            <img class="max-w-full rounded" src="{{ asset(url($cms->urgent_img)) }}" alt="" class="max-w-[400px] md:min-w-[400px] min-w-[300px] min-h-[240px]">
                        @else
                            <img class="max-w-full rounded" src="{{ asset('frontend/images/promotions-img/urgent.jpg') }}" alt="" class="max-w-[400px] md:min-w-[400px] min-w-[300px] min-h-[240px]">
                        @endif
                    </div>
                    <div class="md:w-3/5 flex flex-col gap-3 items-start md:ps-12">
                        <span class="inline-block bg-gray-500 px-6 py-2 heading-07 text-white mb-8">
                            {{ $urgentTitle ? $urgentTitle : $cms->urgent_title ?? __('urgent_listing') }}
                        </span>
                        <div class="dark:text-white">
                            {!! $urgentText ? $urgentText : $cms->urgent_text ?? __('no_urgent_content_found') !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- highlighted section -->
        <section id="highlighted" class="py-16 dark:bg-gray-900">
            <div class="container">
                <div class="flex md:flex-row md:items-center flex-col gap-6">
                    <div class="md:w-3/5 flex flex-col gap-3 items-start md:ps-12">
                        <span class="inline-block bg-gray-500 px-6 py-2 heading-07 text-white mb-8">
                            {{ $highlightTitle ? $highlightTitle : $cms->highlight_title ?? __('highlight_listing') }}
                        </span>
                        <div class="dark:text-white">
                            {!! $highlightText ? $highlightText : $cms->highlight_text ?? __('no_highlight_content_found') !!}
                        </div>
                    </div>
                    <div class="md:w-2/5 flex-grow">
                        @if ($cms->highlight_img)
                            <img class="max-w-full rounded" src="{{ asset(url($cms->highlight_img)) }}" alt="" class="max-w-[400px] md:min-w-[400px] min-w-[300px] min-h-[240px]">
                        @else
                            <img class="max-w-full rounded" src="{{ asset('frontend/images/promotions-img/highlight.jpg') }}" alt="" class="max-w-[400px] md:min-w-[400px] min-w-[300px] min-h-[240px]">
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- top-ad section -->
        <section id="topad" class="py-16 bg-primary-50 dark:bg-gray-800">
            <div class="container">
                <div class="flex md:flex-row md:items-center flex-col gap-6">
                    <div class="md:w-2/5 flex-grow">
                        @if ($cms->top_img)
                            <img class="max-w-full rounded" src="{{ asset(url($cms->top_img)) }}" alt="" class="max-w-[400px] md:min-w-[400px] min-w-[300px] min-h-[240px]">
                        @else
                            <img class="max-w-full rounded" src="{{ asset('frontend/images/promotions-img/top.jpg') }}" alt="" class="max-w-[400px] md:min-w-[400px] min-w-[300px] min-h-[240px]">
                        @endif
                    </div>
                    <div class="md:w-3/5 flex flex-col gap-3 items-start md:ps-24">
                        <span class="inline-block bg-gray-500 px-6 py-2 heading-07 text-white mb-8">
                            {{ $topTitle ? $topTitle : $cms->top_title ?? __('top_listing') }}
                        </span>
                        <div class="dark:text-white">
                            {!! $topText ? $topText : $cms->top_text ?? __('no_top_content_found') !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- bump-up section -->
        <section id="bumpup" class="py-16 dark:bg-gray-900">
            <div class="container">
                <div class="flex md:flex-row md:items-center flex-col gap-6">
                    <div class="md:w-3/5 flex flex-col gap-3 items-start md:pe-12">
                        <span class="inline-block bg-gray-500 px-6 py-2 heading-07 text-white mb-8">
                            {{ $bumpUpTitle ? $bumpUpTitle : $cms->bump_up_title ?? __('bump_up_listing') }}
                        </span>
                        <div class="dark:text-white">
                            {!! $bumpUpText ? $bumpUpText : $cms->bump_up_text ?? __('no_bumpup_content_found') !!}
                        </div>
                    </div>
                    <div class="md:w-2/5 flex-grow">
                        @if ($cms->bump_up_img)
                            <img class="max-w-full rounded" src="{{ asset(url($cms->bump_up_img)) }}" alt="" class="max-w-[400px] md:min-w-[400px] min-w-[300px] min-h-[240px]">
                        @else
                            <img class="max-w-full rounded" src="{{ asset('frontend/images/promotions-img/bump-up.jpg') }}" alt="" class="max-w-[400px] md:min-w-[400px] min-w-[300px] min-h-[240px]">
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- Promotions page Section end  -->

        <section class="py-16 bg-primary-50 dark:bg-gray-800">
            <div class="container">
                <h2 class="text-center heading-03 mb-12">{{ __('get_started') }}</h2>
                <div class="flex flex-col sm:flex-row">
                    <div
                        class="sm:border-r-2 sm:border-b-0 border-b-2 border-gray-100 dark:border-gray-600 flex flex-col justify-center items-center gap-6 md:p-12 p-6 text-center">
                        <img src="{{ asset('frontend/images/promotions-img/promote.png') }}" alt="">
                        <h2 class="heading-03 text-gray-900 dark:text-white">{{ __('promote_listing') }}</h2>
                        <p class="text-base text-gray-600 dark:text-gray-300">{{ __('promote_my_listing_text') }}</p>
                        <a href="{{ route('frontend.my.listing') }}" class="btn-primary">{{ __('my_listing') }}</a>
                    </div>
                    <div class="flex flex-col justify-center items-center gap-6 md:p-12 p-6 text-center">
                        <img src="{{ asset('frontend/images/promotions-img/post-ad.png') }}" alt="">
                        <h2 class="heading-03 text-gray-900 dark:text-white">{{ __('post_listing') }}</h2>
                        <p class="text-base text-gray-600 dark:text-gray-300">{{ __('post_new_listing_text') }}</p>
                        <a href="{{ route('frontend.post') }}" class="btn-primary">{{ __('post_listing') }}</a>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
@push('css')
<style>
    .promoted-item.active {
        background: var(--primary-50);
        color: var(--gray-900);
    }
</style>

@endpush
@push('js')
    <script>
        // Detect active section and update hash menu
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('.promoted-item');

            sections.forEach(section => {
                console.log(section);
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;

                if (
                    window.scrollY >= sectionTop &&
                    window.scrollY < sectionTop + sectionHeight
                ) {
                    // Add 'active' class to the corresponding hash menu link
                    navLinks.forEach(link => {
                        console.log(link)
                        if (link.getAttribute('href') === `#${section.id}`) {
                            link.classList.add('active');
                        } else {
                            link.classList.remove('active');
                        }
                    });
                }
            });
        });
    </script>
@endpush
