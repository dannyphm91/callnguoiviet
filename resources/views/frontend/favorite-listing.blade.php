@extends('frontend.layouts.dashboard')
@section('title')
    {{ __('favorite_ads') }}
@endsection
@section('dashboard-content')
    <x-frontend.breadcrumb.breadcrumb :links="[['url' => 'dashboard', 'text' => __('dashboard')], ['url' => '#', 'text' => __('favorite_ads')]]" />
    <div class="container mt-[2rem] pb-5">
        @if ($wishlists->count())
            <div class="flex justify-between  items-center">
                <h3 class="heading-03 dark:text-white text-gray-900">{{ __('favorite_listing') }}</h3>
            </div>
            <div class="mt-[1.5rem] grid grid-cols-1  gap-6 min-[480px]:grid-cols-2">
                @foreach ($wishlists as $wishlist)
                    <x-frontend.my-listing.favorite-listing-card :wishlist="$wishlist" />
                @endforeach
            </div>

            @if ($wishlists->total() > $wishlists->count())
                <div class="card-footer ">
                    <div class="d-flex justify-content-center">
                        {{ $wishlists->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @endif
        @else
            <div class="py-32 text-center">
                <h3 class="heading-03 text-gray-900">{{ __('you_have_no_favorite_item') }}</h3>
            </div>
        @endif
    </div>
@endsection
