@props(['plan'])

<div class="relative price_plan_{{ $plan->plan_payment_type }}">
    @if ($plan->recommended)
        <span
            class="absolute left-[50%] translate-x-[-50%] top-[-0.825rem]  uppercase bg-primary-50 rounded-full py-[0.38rem] px-[0.75rem] cation-04 text-primary-500">{{ __('recommended') }}</span>
    @endif
    <div
        class="rounded-[0.75rem] border hover:border-primary-400 transition duration-200 ease-linear group {{ $plan->recommended ? 'border-primary-400' : 'border-primary-100' }}  shadow-[0px_8px_8px_-4px_rgba(28,33,38,0.03),0px_20px_24px_-4px_rgba(28,_33,_38,_0.08)] overflow-hidden">

        <div class="border-b border-b-gray-100 py-[1.5rem] text-center space-y-[1rem] dark:bg-white">
            <div>
                <h5 class="heading-06 text-gray-900 ">{{ $plan->label }}</h5>
            </div>
            <div>
                <p class="flex items-end gap-1 justify-center">
                    @if ($plan->label == 'Free')
                        <span class="text-error-500 heading-03">
                            {{ changeCurrency($plan->price) }}0.00
                        </span>
                    @else
                        <span class="text-error-500 heading-03">
                            {{ changeCurrency($plan->price) }}
                        </span>
                    @endif
                    @if ($plan->plan_payment_type == 'recurring')
                        @if ($plan->interval == 'custom_date')
                            <small class="body-md-400 text-gray-700">/{{ $plan->custom_interval_days }}
                                {{ __('days') }}</small>
                        @else
                            <small class="body-md-400 text-gray-700">/
                                @if ($plan->interval == 'yearly')
                                    {{ __('yearly') }}
                                @endif
                                @if ($plan->interval == 'monthly')
                                    {{ __('monthly') }}
                                @endif
                            </small>
                        @endif
                    @endif
                </p>
            </div>
        </div>
        <ul class="p-[1.5rem] space-y-[0.75rem] dark:bg-white">
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
                    {{ __('top_listing_limit') }} : {{ $plan->top_limit }} {{ __('for') }} {{ $plan->top_duration < 1 ? __('lifetime') : $plan->top_duration }}
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
        <div class="p-[1rem] bg-primary-50 rounded-bl-md -z-10">

            @if (auth('user')->check())
                @if ($plan->price == 0)
                    <form action="{{ route('purchase.free.plan') }}" method="POST">
                        @csrf
                        <input type="hidden" class="d-none tw-hidden" name="plan" value="{{ $plan->id }}" readonly>

                        <button type="submit" class="bg-gray-500 {{ $plan->recommended ? 'bg-primary-500 text-white hover:bg-primary-700' : 'bg-transparent border border-primary-500 text-primary-500 hover:text-white hover:bg-primary-500 group-hover:bg-primary-500 group-hover:text-white' }} py-[0.75rem] px-[1.25rem] flex items-center justify-center rounded-[0.5rem]  heading-07 w-full transition duration-200 ease-linear ">
                            {{ __('get_started') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('frontend.priceplanDetails', $plan->label) }}"
                        class="bg-gray-500 {{ $plan->recommended ? 'bg-primary-500 text-white hover:bg-primary-700' : 'bg-transparent border border-primary-500 text-primary-500 hover:text-white hover:bg-primary-500 group-hover:bg-primary-500 group-hover:text-white' }} py-[0.75rem] px-[1.25rem] flex items-center justify-center rounded-[0.5rem]  heading-07 w-full transition duration-200 ease-linear ">
                        {{ __('get_started') }}
                    </a>
                @endif

            @else
                <a href="{{ route('users.login') }}"
                    class="bg-gray-500 {{ $plan->recommended ? 'bg-primary-500 text-white hover:bg-primary-700' : 'bg-transparent border border-primary-500 text-primary-500 hover:text-white hover:bg-primary-500 group-hover:bg-primary-500 group-hover:text-white' }} py-[0.75rem] px-[1.25rem] flex items-center justify-center rounded-[0.5rem]  heading-07 w-full transition duration-200 ease-linear">
                    {{ __('get_started') }}
                </a>
            @endif

        </div>
    </div>
</div>
