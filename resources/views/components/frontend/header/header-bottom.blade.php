@php
    $locale = app()->getLocale();
@endphp
<div class="header-bottom hidden lg:!block bg-primary-800 dark:bg-gray-800">
    <div class="container">

        <div class="flex gap-6 items-center">
            <div class="cat-menu text-white/80 overflow-visible">
                <button
                    class="inline-flex gap-2 items-center py-3 heading-07 transition-all duration-300 hover:text-white">
                    <x-svg.all-category-icon />
                    <span class="whitespace-nowrap">{{ __('all_category') }}</span>
                </button>
                <div class="cat-submenu flex flex-col gap-3">
                    <h3 class="heading-07 text-gray-900 dark:text-gray-100"><a href="/ads">{{ __('all_category') }}</a></h3>
                    <ul class="flex flex-col gap-3">
                        @foreach (loadCategoriesSubcategories() as $category)
                            <li>
                                <a href="{{ route('frontend.ads.category', $category['slug']) }}"
                                    class="cat-submenu-link block body-md-400 text-gray-700 dark:text-gray-300 hover:text-primary-500 transition-all duration-300">
                                    <span
                                        class="relative">{{ $category['translations']['category'][$locale] ?? $category['name'] }}</span>
                                </a>
                                @if ($category['subcategories'] && count($category['subcategories']))
                                    <div class="cat-sub-submenu flex flex-col gap-3">
                                        <h3 class="heading-07 text-gray-900"></h3>
                                        <ul class="flex flex-col gap-3">
                                            @foreach ($category['subcategories'] as $subcategory)
                                                <li>
                                                    <a href="{{ route('frontend.ads.sub.category', ['slug' => $category['slug'], 'subslug' => $subcategory['slug']]) }}"
                                                        class="body-md-400 text-gray-700 dark:text-gray-300 hover:text-primary-500 transition-all duration-300">
                                                        {{ $subcategory['translations'][$locale] ?? $subcategory['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="swiper category-slider relative text-white/80">
                <div class="swiper-wrapper overflow-hidden flex items-center">
                    @foreach (loadCategoriesSubcategories() as $category)
                        <div class="swiper-slide whitespace-nowrap max-w-max inline-flex py-[13px]">
                            <a href="{{ route('frontend.ads.category', $category['slug']) }}"
                                class="heading-07 transition-all duration-300 hover:text-white">
                                {{ $category['name'] }}
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="slider-navigation__wrap text-left">
                    <div
                        class="category-slider_prev cursor-pointer inline-flex items-center bg-white w-[22px] h-[22px] rounded-full p-[5px]">
                        <x-svg.right-icon stroke="#1768E0" class="rtl:rotate-180" />
                    </div>
                </div>
                <div class="slider-navigation__wrap text-left">
                    <div
                        class="category-slider_next cursor-pointer inline-flex items-center bg-white w-[22px] h-[22px] rounded-full p-[5px]">
                        <x-svg.right-icon stroke="#1768E0" class="rtl:rotate-180" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
