@props(['wishlist'])
<div
    class=" border dark:bg-gray-900 border-gray-100 dark:border-gray-600 rounded-lg shadow-[0px_2px_4px_0px_rgba(28,33,38,0.06)] overflow-hidden flex flex-wrap lg:flex-nowrap">
    <div class="w-full max-h-[13.9rem]">
        <a href="{{ route('frontend.addetails', $wishlist->slug) }}" class="h-full w-full">
            <img src="{{ $wishlist->thumbnail }}" alt="listing img" class="w-full h-full " />
        </a>
    </div>

    <div class="px-4 py-5 w-full flex flex-col ">
        <div>
            <h6 class="text-error-500 heading-06">{{ currentCurrencySymbol() }}{{ $wishlist->price }}</h6>
            <a href="{{ route('frontend.addetails', $wishlist->slug) }}">
                <p class="body-md-500 text-gray-900 dark:text-white line-clamp-1">{{ $wishlist->title }}</p>
            </a>
        </div>

        <div class="mt-2 space-y-2 block ">
            <span class="flex items-center gap-x-[0.38rem] body-sm-400 text-gray-700 dark:text-gray-300">
                <x-svg.heroicons.location class="w-5 h-5" />
                {{ $wishlist->district ? $wishlist->district . ', ' : '' }}
                {{ $wishlist->region ? $wishlist->region . ', ' : '' }}
                {{ $wishlist->country ?? '' }}
            </span>
            <span class="flex items-center gap-x-[0.38rem] body-sm-400 text-gray-700 dark:text-gray-300">
                <x-svg.heroicons.stack class="w-5 h-5" />
                {{ $wishlist->category->name }}
            </span>
        </div>
        <div class="flex justify-between w-full mt-5" x-init x-data="{ loved: true }">
            <div class="space-y-2">
                <x-frontend.my-listing.active-badge :status="$wishlist->status" />
                <small class="block body-xs-400 text-gray-500 dark:text-gray-200">
                    {{ $wishlist->created_at->diffForHumans() }}
                </small>
            </div>
            <div class="p-2 h-[2.5rem] w-[2.5rem] rounded-full border border-gray-100 dark:border-gray-600 self-end" role="button"
                @click="loved=!loved">
                <form action="{{ route('frontend.add.wishlist') }}" method="POST">
                    @csrf
                    @if (auth('user')->check())
                        <input type="hidden" name="ad_id" value="{{ $wishlist->id }}">
                        <input type="hidden" name="user_id" value="{{ auth('user')->user()->id }}">
                    @endif
                    <button type="submit" class="btn btn--bg btn--fav">
                        <span class="icon">
                            <x-frontend.icons.heart-red />
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
