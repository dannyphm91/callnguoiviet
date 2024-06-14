@props(['ad' => null])

<div
    class="details-header flex sm:flex-row flex-col sm:gap-4 gap-2 justify-between items-start sm:px-6 px-3 sm:pt-6 pt-3 pb-3 sm:pb-5">
    <div class="flex flex-col sm:gap-3 gap-2">
        <h3 class="heading-05 text-gray-900 dark:text-white">
            {{ $ad?->title ?? '' }}
        </h3>
        <div class="flex gap-4 flex-wrap">
            <div class="flex gap-2 items-center text-primary-500 dark:text-primary-300 body-md-500">
                <x-frontend.icons.solid-tag class="w-5 h-5" />
                <span>
                    <a href="{{ route('frontend.ads.category', $ad?->category?->slug ?? '') }}">{{ $ad?->category?->name ?? '' }}</a>

                    @if (isset($ad->subcategory))
                        / <a
                            href="{{ route('frontend.ads.sub.category', ['slug' => $ad->category->slug ?? '', 'subslug' => $ad->subcategory->slug ?? '']) }}">
                            {{ $ad->subcategory->name ?? '' }}
                        </a>
                    @endif
                </span>
            </div>
            <div class="flex gap-2 items-center text-gray-700 dark:text-gray-300 body-sm-400">
                <x-frontend.icons.outline-clock class="w-5 h-5" />
                <span>
                    {{ formatTime($ad?->created_at, 'M d, Y h:i A') }}
                </span>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap gap-4">
        @if(auth()->id() == $ad->user_id)
            <div class="inline-flex">
                <a href="{{ route('frontend.post.edit', $ad->slug) }}"
                    class="inline-flex gap-1 items-center transition-all duration-300 heading-08 text-primary-500 dark:text-primary-300 hover:text-primary-700">
                    <x-svg.edit-icon stroke="#007aff" fill="#007aff" />
                    <span class="whitespace-nowrap">{{ __('edit') }}</span>
                </a>
            </div>
        @endif

        {{-- <livewire:wishlist-button :ad="$ad" /> --}}
    </div>
</div>

