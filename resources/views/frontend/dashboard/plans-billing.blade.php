@extends('frontend.layouts.dashboard')

@section('title', __('price_and_billing'))

@section('breadcrumb')
    <x-frontend.breadcrumb.breadcrumb :links="[['text' => 'Dashboard'], ['text' => 'Plan & Billing']]" />
@endsection
@section('dashboard-content')
    @if ($current_plan)
        <div class="grid grid-cols-2 gap-4">
            <div class="mt-6">
                <div class="invoice-table">
                    <h4 class="heading-06 dark:text-white mb-5">{{ __('current_plan') }}</h4>
                    <div class="border dark:bg-gray-900 border-primary-50 rounded-md p-5 shadow-sm md:col-span-2">
                        <h2 class="heading-03 mb-3">
                            {{ $current_plan?->label }}
                        </h2>

                        @if ($plan_type == 'recurring')
                            @if ($user_plan->expired_date && !formatDateTime($user_plan->expired_date)->isPast())
                                <p>{{ __('auto_renews_on') }} {{ formatDate($user_plan->expired_date, 'M d, Y') }}</p>
                            @else
                                @if ($current_plan?->price != 0)
                                    <h2 class="heading-07 text-red-500">{{ __('plan_expired_please_subscribe_to_the_plan') }}
                                    </h2>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('frontend.priceplan') }}" class="btn btn-secondary">
                                {{ __('upgrade_plan') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @if ($plan_type == 'recurring')
                <div class="mt-6">
                    <div class="invoice-table">
                        <h4 class="heading-06 mb-5 dark:text-white">{{ __('manage_subscription') }}</h4>

                        <div
                            class="border border-primary-50 dark:border-gray-600 rounded-md p-5 shadow-sm md:col-span-2 dark:bg-gray-900 flex gap-3">
                            <div>
                                <a href="{{ route('frontend.priceplan') }}" class="btn btn-secondary">
                                    {{ __('upgrade_plan') }}
                                </a>
                            </div>
                            @if (authUser()->subscribed('default'))
                                @can('cancel', authUser()->subscription('default'))
                                    <form action="{{ route('subscribe.plan.cancel') }}" method="post">
                                        @csrf
                                        <button class="btn btn-danger" type="submit">
                                            {{ __('cancel_subscription') }}
                                        </button>
                                    </form>
                                @endcan
                                @can('resume', authUser()->subscription('default'))
                                    <form action="{{ route('subscribe.plan.resume') }}" method="post">
                                        @csrf
                                        <button class="btn btn-primary" type="submit">
                                            {{ __('resume_subscription') }}
                                        </button>
                                    </form>
                                @endcan
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="border border-primary-50 rounded-md p-5 shadow-sm md:col-span-2 mt-5">
            <div class="">
                <h4 class="heading-07 mb-4">{{ __('current_plan_benefits') }}:</h4>

                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <li class="flex gap-1.5 items-start">
                        <x-svg.double-check-icon stroke="var(--primary-500)" />
                        <span>{{ __('listing_post_limit') }} : {{ $current_plan?->ad_limit }}</span>
                    </li>
                    <li class="flex gap-1.5 items-start">
                        <x-svg.double-check-icon stroke="var(--primary-500)" />
                        <span>
                            {{ __('featured_listing_limit') }} : {{ $current_plan?->featured_limit }} {{ __('for') }} {{ $current_plan?->featured_duration < 1 ? __('lifetime') : $current_plan?->featured_duration }}
                            @if ($current_plan?->featured_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif
                        </span>
                    </li>
                    <li class="flex gap-1.5 items-start">
                        <x-svg.double-check-icon stroke="var(--primary-500)" />
                        <span>
                            {{ __('urgent_listing_limit') }} : {{ $current_plan?->urgent_limit }} {{ __('for') }} {{ $current_plan?->urgent_duration < 1 ? __('lifetime') : $current_plan?->urgent_duration }}
                            @if ($current_plan?->urgent_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif
                        </span>
                    </li>
                    <li class="flex gap-1.5 items-start">
                        <x-svg.double-check-icon stroke="var(--primary-500)" />
                        <span>
                            {{ __('highlight_listing_limit') }} : {{ $current_plan?->highlight_limit }} {{ __('for') }} {{ $current_plan?->highlight_duration < 1 ? __('lifetime') : $current_plan?->highlight_duration }}
                            @if ($current_plan?->highlight_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif
                        </span>
                    </li>
                    <li class="flex gap-1.5 items-start">
                        <x-svg.double-check-icon stroke="var(--primary-500)" />
                        <span>
                            {{ __('top_listing_limit') }} : {{ $current_plan->top_limit }} {{ __('for') }} {{ $current_plan->top_duration < 1 ? __('lifetime') : $current_plan?->top_duration }}
                            @if ($current_plan->top_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif
                        </span>
                    </li>
                    <li class="flex gap-1.5 items-start">
                        <x-svg.double-check-icon stroke="var(--primary-500)" />
                        <span>
                            {{ __('bump_up_listing_limit') }} : {{ $current_plan?->bump_up_limit }} {{ __('for') }} {{ $current_plan?->bump_up_duration < 1 ? __('lifetime') : $current_plan?->bump_up_duration }}
                            @if ($current_plan?->bump_up_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif
                        </span>
                    </li>

                    @if ($current_plan->badge)
                        <li class="flex gap-1.5 items-start">
                            <x-svg.double-check-icon stroke="var(--primary-500)" />
                            <span>{{ __('membership_badge') }}</span>
                        </li>
                    @endif

                    @if ($current_plan->premium_member)
                        <li class="flex gap-1.5 items-start">
                            <x-svg.double-check-icon stroke="var(--primary-500)" />
                            <span>{{ __('premium_membership') }}</span>
                        </li>
                    @endif
                </ul>

                <div class="bg-primary-50 h-[1px] my-3"></div>

                <div class="pt-2">

                    <h4 class="heading-07 mb-4">{{ __('remaining') }}:</h4>

                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <li class="flex gap-1.5 items-start">
                            <x-svg.double-check-icon stroke="var(--primary-500)" />
                            <span> {{ __('remaining') }} {{ __('listing_limit') }} : {{ $user_plan?->ad_limit }}</span>
                        </li>
                        <li class="flex gap-1.5 items-start">
                            <x-svg.double-check-icon stroke="var(--primary-500)" />
                            <span> {{ __('remaining') }} {{ __('featured_limit') }} : {{ $user_plan?->featured_limit }}</span>
                        </li>
                        <li class="flex gap-1.5 items-start">
                            <x-svg.double-check-icon stroke="var(--primary-500)" />
                            <span> {{ __('remaining') }} {{ __('urgent_limit') }} : {{ $user_plan?->urgent_limit }}</span>
                        </li>
                        <li class="flex gap-1.5 items-start">
                            <x-svg.double-check-icon stroke="var(--primary-500)" />
                            <span> {{ __('remaining') }} {{ __('highlight_limit') }} : {{ $user_plan?->highlight_limit }}</span>
                        </li>
                        <li class="flex gap-1.5 items-start">
                            <x-svg.double-check-icon stroke="var(--primary-500)" />
                            <span> {{ __('remaining') }} {{ __('top_limit') }} : {{ $user_plan?->top_limit }}</span>
                        </li>
                        <li class="flex gap-1.5 items-start">
                            <x-svg.double-check-icon stroke="var(--primary-500)" />
                            <span> {{ __('remaining') }} {{ __('bump_up_limit') }} : {{ $user_plan?->bump_up_limit }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <div class="invoice-table">
                @php
                    $plan_type_text = $plan_type == 'one_time' ? str_replace('_', ' ', $plan_type) : 'subscription';
                    $switch_plan_text = $plan_type == 'one_time' ? 'subscription' : 'one time';
                @endphp
                <h4 class="heading-06 mb-5 dark:text-white">{{ __('manage_plan_system') }}</h4>

                <div class="border border-primary-50 rounded-md p-5 shadow-sm">
                    <div>
                        <p> {!! __('you_are_currently_on_another_plan_system_switch_to_another_plan_system', [
                            'current_plan' => ucfirst($plan_type_text),
                            'switch_plan' => ucfirst($switch_plan_text),
                        ]) !!}</p>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('frontend.priceplan') }}" class="btn btn-secondary">
                            {{ __('switch_other_plan_system', ['plan' => ucfirst($switch_plan_text)]) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="mt-6">
            <div class="invoice-table">
                <h4 class="heading-06 mb-5 dark:text-white">{{ __('current_plan') }}</h4>
                <div class="border border-primary-50 dark:border-gray-600 rounded-md p-5 shadow-sm md:col-span-2 dark:bg-gray-900">
                    <h2 class="heading-07 dark:text-white mb-3">
                        {{ __('you_are_currently_on_free_plan') }}
                    </h2>

                    <a href="{{ route('frontend.priceplan') }}" class="btn btn-secondary">
                        {{ __('upgrade_plan') }}
                    </a>
                </div>
            </div>
        </div>
    @endif



    {{-- <div class="mt-6">
        <div class="invoice-table">
            <h4 class="heading-06 mb-5 dark:text-white">{{ __('payment_information') }}</h4>
            <div class="border border-primary-50 rounded-md p-5 shadow-sm md:col-span-2 dark:bg-white">
                <h2 class="heading-03 mb-3">
                    {{ $subscription_plan ? $current_plan->label : __('free_plan') }}
                </h2>

            </div>
        </div>
    </div> --}}

    <div class="mt-6">
        <div class="invoice-table">
            <h4 class="heading-06 mb-5 dark:text-white">{{ __('recent_invoice') }}</h4>
            <div class="relative overflow-x-auto border border-gray-100 dark:border-gray-600 rounded-md dark:bg-white">
                @if ($transactions && count($transactions))
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 dark:text-gray-50 uppercase bg-primary-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3">{{ __('order_id') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('plan_type') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('payment_provider') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('amount') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr class="bg-white dark:bg-gray-800">
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white/70">
                                        {{ $transaction->order_id }}</td>
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white/70">
                                        {{ $transaction->plan->label }}</td>
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white/70">
                                        {{ ucfirst(str_replace('_', ' ', $transaction->payment_provider)) }}</td>
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white/70">
                                        {{ $transaction->currency_symbol }}{{ $transaction->amount }}
                                        <span
                                            class="text-{{ $transaction->payment_status == 'paid' ? 'success' : 'danger' }}">
                                            {{ ucfirst($transaction->payment_status) }}
                                        </span>
                                    </td>
                                    <td scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white/70">
                                        {{ Carbon\Carbon::parse($transaction->created_at)->format('M d, Y g:i A') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <x-not-found2 message="{{ __('no_recent_invoice_found') }}" />
                @endif
            </div>
        </div>
    </div>
@endsection
