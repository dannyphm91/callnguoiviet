
@if (auth('user')->check())
    <button wire:click="addToWishlist"
        class="inline-flex gap-1 items-center transition-all duration-300 heading-08 text-primary-500 dark:text-primary-300 hover:text-primary-700">
        @if ($isWishlisted)
            <x-svg.heart-icon stroke="currentColor" fill="currentColor" />
            <span class="whitespace-nowrap">{{ __('remove_from_wishlist') }}</span>
        @else
            <x-svg.heart-icon stroke="currentColor" />
            <span class="whitespace-nowrap">{{ __('add_to_wishlist') }}</span>
        @endif
    </button>
@else
    <a href="{{ route('users.login') }}"
        class="login_required inline-flex gap-1 items-center transition-all duration-300 heading-08 text-primary-500 dark:text-primary-300 hover:text-primary-700">
        <x-svg.heart-icon />
        <span class="whitespace-nowrap">{{ __('add_to_wishlist') }}</span>
    </a>
@endif



