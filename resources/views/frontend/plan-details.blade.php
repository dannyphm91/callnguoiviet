@extends('frontend.layouts.app')

@section('title')
    {{ __('plan_details') }} ({{ $plan->label }})
@endsection

@section('meta')
    @php
        $data = metaData('pricing');
    @endphp

    <meta name="title" content="{{ $data->title }}">
    <meta name="description" content="{{ $data->description }}">

    <meta property="og:image" content="{{ $data->image_url }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $data->title }}">
    <meta property="og:url" content="{{ route('frontend.priceplan') }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{ $data->description }}">

    <meta name=twitter:card content={{ $data->image_url }} />
    <meta name=twitter:site content="{{ config('app.name') }}" />
    <meta name=twitter:url content="{{ route('frontend.priceplan') }}" />
    <meta name=twitter:title content="{{ $data->title }}" />
    <meta name=twitter:description content="{{ $data->description }}" />
    <meta name=twitter:image content="{{ $data->image_url }}" />

@endsection

@section('content')
    <!-- breedcrumb section start  -->
    <x-frontend.breadcrumb.breadcrumb :links="[['url' => '#', 'text' => __('Plan Details')], ['url' => '#', 'text' => $plan->label]]" />
    <!-- breedcrumb section end  -->
    <section class="bg-primary-50 dark:bg-gray-800 py-8">
        <div class="container">
            <h2 class="heading-05 dark:text-white mb-6">{{ __('plan_details_and_benefits') }} </h2>
            <div class="bg-white shadow-sm rounded-xl p-8">
                <h2 class="heading-07 dark:text-white mb-8">{{ __('current_plan_benefits') }}</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex items-center body-md-400 text-gray-900 gap-[0.38rem]">
                        @if ($plan->ad_limit === 0)
                            <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-red-500 text-white font-bold flex items-center justify-center">
                                <x-svg.cross-icon />
                            </span>
                            {{ __('listing_post') }} : {{ __('not_included')}}
                        @else
                            <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-primary-500 text-white font-bold flex items-center justify-center">
                                <x-svg.check-icon />
                            </span>
                            {{ __('listing_post_limit') }} : {{ $plan->ad_limit }}
                        @endif
                    </li>

                    <li class="flex items-center body-md-400 text-gray-900 gap-[0.38rem] {{ $plan->featured_limit ? 'active' : '' }}">
                        @if ($plan->featured_limit === 0)
                        <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-red-500 text-white font-bold flex items-center justify-center">
                            <x-svg.cross-icon />
                        </span>
                        {{ __('featured_listing') }} : {{ __('not_included')}}
                        @else
                            <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-primary-500 text-white font-bold flex items-center justify-center">
                                <x-svg.check-icon />
                            </span>
                            {{ __('featured_listing_limit') }} : {{ $plan->featured_limit }} {{ __('for') }} {{ $plan->featured_duration < 1 ? __('lifetime') : $plan->featured_duration }}
                            @if ($plan->featured_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif

                        @endif
                    </li>

                    <li class="flex items-center body-md-400 text-gray-900 gap-[0.38rem] {{ $plan->urgent_limit ? 'active' : '' }}">
                        @if ($plan->urgent_limit === 0)
                        <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-red-500 text-white font-bold flex items-center justify-center">
                            <x-svg.cross-icon />
                        </span>
                        {{ __('urgent_listing') }} : {{ __('not_included')}}
                        @else
                            <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-primary-500 text-white font-bold flex items-center justify-center">
                                <x-svg.check-icon />
                            </span>
                            {{ __('urgent_listing_limit') }} : {{ $plan->urgent_limit }} {{ __('for') }} {{ $plan->urgent_duration < 1 ? __('lifetime') : $plan->urgent_duration }}
                            @if ($plan->urgent_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif

                        @endif
                    </li>

                    <li class="flex items-center body-md-400 text-gray-900 gap-[0.38rem] {{ $plan->highlight_limit ? 'active' : '' }}">
                        @if ($plan->highlight_limit === 0)
                        <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-red-500 text-white font-bold flex items-center justify-center">
                            <x-svg.cross-icon />
                        </span>
                        {{ __('highlight_listing') }} : {{ __('not_included')}}
                        @else
                            <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-primary-500 text-white font-bold flex items-center justify-center">
                                <x-svg.check-icon />
                            </span>
                            {{ __('highlight_listing_limit') }} : {{ $plan->highlight_limit }} {{ __('for') }} {{ $plan->highlight_duration < 1 ? __('lifetime') : $plan->highlight_duration }}
                            @if ($plan->highlight_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif
                        @endif
                    </li>

                    <li class="flex items-center body-md-400 text-gray-900 gap-[0.38rem] {{ $plan->top_limit ? 'active' : '' }}">
                        @if ($plan->top_limit === 0)
                        <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-red-500 text-white font-bold flex items-center justify-center">
                            <x-svg.cross-icon />
                        </span>
                        {{ __('top_listing') }} : {{ __('not_included')}}
                        @else
                            <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-primary-500 text-white font-bold flex items-center justify-center">
                                <x-svg.check-icon />
                            </span>
                            {{ __('top_listing_limit') }} : {{ $plan->top_limit }} {{ __('for') }}
                            {{ $plan->top_duration < 1 ? __('lifetime') : $plan->top_duration }}
                            @if ($plan->top_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif

                        @endif
                    </li>

                    <li class="flex items-center body-md-400 text-gray-900 gap-[0.38rem] {{ $plan->bump_up_limit ? 'active' : '' }}">
                        @if ($plan->bump_up_limit === 0)
                        <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-red-500 text-white font-bold flex items-center justify-center">
                            <x-svg.cross-icon />
                        </span>
                        {{ __('bump_up_listing') }} : {{ __('not_included')}}
                        @else
                            <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-primary-500 text-white font-bold flex items-center justify-center">
                                <x-svg.check-icon />
                            </span>
                            {{ __('bump_up_listing_limit') }} : {{ $plan->bump_up_limit }} {{ __('for') }} {{ $plan->bump_up_duration < 1 ? __('lifetime') : $plan->bump_up_duration }}
                            @if ($plan->bump_up_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif

                        @endif
                    </li>

                    <li class="flex items-center body-md-400 text-gray-900 gap-[0.38rem]">
                        @if (!$plan->badge)
                        <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-red-500 text-white font-bold flex items-center justify-center">
                            <x-svg.cross-icon />
                        </span>
                        {{ __('membership_badge') }} : {{ __('not_included')}}
                        @else
                            <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-primary-500 text-white font-bold flex items-center justify-center">
                                <x-svg.check-icon />
                            </span>
                            {{ __('membership_badge') }}
                        @endif
                    </li>

                    <li class="flex items-center body-md-400 text-gray-900 gap-[0.38rem]">
                        @if (!$plan->premium_member)
                        <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-red-500 text-white font-bold flex items-center justify-center">
                            <x-svg.cross-icon />
                        </span>
                        {{ __('premium_membership') }} : {{ __('not_included')}}
                        @else
                            <span class="h-[1.5rem] w-[1.5rem] rounded-full bg-primary-500 text-white font-bold flex items-center justify-center">
                                <x-svg.check-icon />
                            </span>
                            {{ __('premium_membership') }}
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        @if ($plan->plan_payment_type == 'one_time')
            {{-- One time plan --}}
            <x-frontend.plan.onetime-plan :manualpayments="$manual_payments" :plan="$plan" :midtoken="$mid_token" :walletbalance="$wallet_balance" :currentplan="$current_plan"/>
        @elseif ($plan->plan_payment_type == 'recurring')
            {{-- Recurring plan --}}
            <x-frontend.plan.recurring-plan :plan="$plan" :intent="$intent" :currentplan="$current_plan"/>
        @endif
    </section>
@endsection

@push('css')
    <style>
        .sweet-alert{
            width: 650px !important;
        }

        .sweet-alert p{
            font-size: 18px !important;
            font-weight: 500 !important;
            margin-top: 10px !important;
        }
    </style>
@endpush
