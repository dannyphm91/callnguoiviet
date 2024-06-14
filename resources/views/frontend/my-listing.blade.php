@extends('frontend.layouts.dashboard')
@section('title')
    {{ __('my_listing') }}
@endsection
@section('dashboard-content')
    <x-frontend.breadcrumb.breadcrumb :links="[['url' => 'dashboard', 'text' => __('dashboard')], ['url' => '#', 'text' => __('my_listing')]]" />
    <div class="container mt-[2rem] pb-5">

        @if ($ads->count())
            <div class="flex justify-between  items-center">
                <h3 class="heading-03 dark:text-white text-gray-900">{{ __('my_listing') }}</h3>
                <a href="{{ route('frontend.post') }}"
                    class="inline-flex justify-center items-center gap-2 py-3 px-5 rounded-md transition-all duration-300 bg-primary-500 hover:bg-primary-600 text-white heading-07">
                    <small
                        class="w-[1.5rem] h-[1.5rem] rounded-full bg-white  text-primary-500 flex items-center justify-center">
                        <x-frontend.icons.plus />
                    </small>
                    <span>{{ __('post_new_listing') }}</span>
                </a>
            </div>
            <div class="mt-6 lg:flex grid min-[900px]:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6 flex-col">
                @foreach ($ads as $ad)
                    <x-frontend.my-listing.listing-card :ad="$ad" :userPlan="$user_plan_data" :plan="$plan"/>
                @endforeach
            </div>
            @if ($ads->total() > $ads->count())
                <div class="card-footer ">
                    <div class="d-flex justify-content-center">
                        {{ $ads->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @endif
        @else
            <div class="py-32 text-center">
                <h3 class="heading-03 text-gray-900">{{ __('you_have_no_ads_item') }}</h3>
            </div>
        @endif


    </div>
@endsection

<style>
    @media screen and (max-width: 767px) {
        .mobile-hidden {
            display: none !important;
        }
    }
    .promote-ad {
        min-width: 150px;
        text-align: center;
    }
    .promote-ad:has(input:checked) {
        border-color: var(--primary-500);
        background: var(--primary-50);
    }
</style>
