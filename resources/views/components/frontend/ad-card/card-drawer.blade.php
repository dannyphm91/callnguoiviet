@props([
    'ad' => null,
])

<div id="ad-details_offcanvas_{{ $ad->id }}"
    class="fixed top-0 right-0 z-40 h-screen px-4 pb-6 overflow-y-auto duration-500 transition-all translate-x-full bg-white w-full 2xl:max-w-[60%] lg:max-w-[80%] max-w-[96%] dark:bg-gray-800"
    tabindex="-1" aria-labelledby="drawer-right-label">
    <div class="flex py-5 justify-between items-center">
        <button class="text-primary-500 p-1" type="button" data-drawer-hide="ad-details_offcanvas_{{ $ad->id }}"
            aria-controls="ad-details_offcanvas_{{ $ad->id }}" class="">
            <x-svg.arrow-left />
        </button>
        <a href="{{ route('frontend.addetails', $ad?->slug) }}"
            class="text-primary-500 dark:text-primary-300 hover:text-primary-600 transition-all duration-300 text-base font-semibold inline-flex gap-3 items-center">
            <span class="underline">{{ __('open_details_in_a_new_window') }}</span>
            <x-svg.external-link />
        </a>
    </div>
    <div>
        <div class="flex flex-col xl:flex-row gap-6 overflow-hidden">
            <div class="details-wrap w-full">
                <x-frontend.ad-card.details.header :ad="$ad" />
                <div class="flex flex-col lg:flex-row gap-5">
                    <div class="w-full flex-grow lg:max-w-[70%] max-w-full overflow-hidden">
                        <x-frontend.ad-card.details.slider2 :ad="$ad" />
                        <x-frontend.ad-card.details.info :ad="$ad" :product_custom_field_groups="[]" />
                    </div>
                    <div class="flex flex-col lg:max-w-[30%] gap-6">
                        <x-frontend.ad-card.details.sidebar-top :ad="$ad" :hidereport="true" />
                        <div class="border border-gray-100 rounded-l-lg">
                            <div class="px-5 pt-5 pb-3 flex flex-col gap-2">
                                <h3 class="body-lg-500 text-gray-900 dark:text-white">{{ __('location') }}</h3>
                                <p class="body-md-400 text-gray-700">
                                    {{ $ad->district ? $ad->district . ', ' : '' }}
                                    {{ $ad->region ? $ad->region . ', ' : '' }}
                                    {{ $ad->country ?? '' }}
                                </p>
                            </div>
                            {{-- <div id="map" class="min-h-[248px]"></div> --}}
                        </div>
                    </div>
                </div>
                <x-frontend.ad-card.details.footer />
            </div>
        </div>
    </div>
</div>
