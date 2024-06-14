@extends('frontend.postad.index')

@section('title', __('step3'))

@section('post-ad-content')
    <div x-data="{ whatsapp: false }">
        <form action="{{ route('frontend.post.step3.store') }}" method="POST">
            @csrf
            <div class="sm:p-8 p-4 flex flex-col gap-8">
                <div class="flex flex-col gap-4">
                    <div>
                        <div class="w-full flex flex-wrap gap-4 justify-between items-center mb-1.5">
                            <div>
                                <label for="phone" class="tc-label mb-0">
                                    {{ __('phone_number') }}
                                    <span class="text-red-600">*</span>
                                </label>
                            </div>
                            <div>
                                <div class="tc-checkbox">
                                    <input @change="whatsapp = !whatsapp" type="checkbox" name="" id="whatsapp">
                                    <label for="whatsapp">
                                        {{ __('i_have_different_phone_number_for_whatsapp') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <input required type="text" placeholder="{{ __('phone') }}"
                                class="tc-input @error('phone') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                                name="phone" value="{{ old('phone', $ad?->phone) }}" id="phone">

                            @error('phone')
                                <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div x-show="whatsapp" x-cloak>
                        <x-forms.flabel name="whatsapp_number" for="whatsapp_number" />
                        <input type="text" placeholder="{{ __('whatsapp_number') }}" class="tc-input"
                            :name="whatsapp ? 'whatsapp' : ''" value="{{ old('whatsapp', $ad?->whatsapp) }}">
                    </div>
                    <div>
                        <label for="email" class="tc-label">{{ __('email_address') }}</label>
                        <input type="email" name="email" id="email" class="tc-input"
                            value="{{ old('email', $ad?->email ?? auth()->user()->email) }}"
                            placeholder="{{ __('email_address') }}">
                    </div>
                </div>

                <!--Promotions Selecting Option -->
                <div class="promotions-wrapper">

                    <div class="flex items-center mb-2">
                        <h6 class="heading-06">{{ __('promote_listing') }}</h6>
                        <p class="text-sm">
                            (<a href="{{ route('frontend.promotions') }}" class="pl-1 underline text-blue-500" target="_blank">{{ __('know_more_about_promotion') }}</a>):
                        </p>
                    </div>

                    <!-- Promotion Item Start -->
                    <div class="promotion-item mt-3 mb-3">
                        <input name="featured" type="hidden" value="0">
                        @if ($user_plan_data->featured_limit > 0)
                            <label for="featured" class="cursor-pointer flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-gray-50 w-full">
                                <input @checked(old('featured', $ad?->featured ?? '') == 1) type="checkbox" class="hidden" name="featured" id="featured" value="1">
                                <div class="flex align-center">
                                    <img class="h-14" src="{{ asset('frontend/images/promotions-img/featured-promote.svg') }}"
                                    alt="">
                                    <div class="text-left grow ml-3">
                                        <h3 class="heading-07">{{ __('featured_listing') }}</h3>
                                        <p class="leading-6">
                                            {{ __('select_this_promotion_to_make_listing_featured') }}
                                            {{ __('for') }}
                                            {{ $plan->featured_duration < 1 ? __('lifetime') : $plan->featured_duration }}
                                            @if ($plan->featured_duration == 1)
                                                {{ __('day') }}.
                                            @else
                                                {{ __('days') }}.
                                            @endif
                                        </p>
                                        <p class="leading-6">{{ $user_plan_data->featured_limit }} {{ __('featured_listing') }} {{ __('remaining') }}.</p>
                                    </div>
                                </div>
                            </label>
                            @else
                            <label for="featured" class="cursor-pointer flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-red-50 w-full">
                                <input disabled @checked(old('featured', $ad?->featured ?? '') == 1) type="checkbox" class="hidden" name="featured" id="featured" value="0">
                                <div class="flex align-center">
                                    <img class="h-14" src="{{ asset('frontend/images/promotions-img/featured-promote.svg') }}"
                                    alt="">
                                    <div class="text-left grow ml-3">
                                        <h3 class="heading-07 !text-red-500">
                                            {{ __('featured_limit') }} {{ __('crossed') }},
                                            <a href="{{ route('frontend.plans-billing') }}" class="underline text-blue-500">{{ __('please_upgrade_plan') }}</a>
                                        </h3>
                                        <h3 class="heading-07">{{ __('featured_listing') }}</h3>
                                        <p class="leading-6">{{ __('select_this_promotion_to_make_listing_featured') }}.</p>
                                    </div>
                                </div>
                            </label>
                        @endif
                    </div>
                    <!-- Promotion Item End -->

                    <!-- Promotion Item Start -->
                    <div class="promotion-item mt-3 mb-3">
                        <input name="urgent" type="hidden" value="0">
                        @if ($user_plan_data->urgent_limit > 0)
                            <label for="urgent" class="cursor-pointer flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-gray-50 w-full">
                                <input @checked(old('urgent', $ad?->urgent ?? '') == 1) type="checkbox" class="hidden" name="urgent" id="urgent" value="1">
                                <div class="flex align-center">
                                    <img class="h-14" src="{{ asset('frontend/images/promotions-img/urgent-promote.svg') }}"
                                    alt="">
                                    <div class="text-left grow ml-3">
                                        <h3 class="heading-07">{{ __('urgent_listing') }}</h3>
                                        <p class="leading-6"">{{ __('select_this_promotion_to_make_listing_urgent') }}
                                            {{ __('for') }}
                                            {{ $plan->urgent_duration < 1 ? __('lifetime') : $plan->urgent_duration }}
                                            @if ($plan->urgent_duration == 1)
                                                {{ __('day') }}.
                                            @else
                                                {{ __('days') }}.
                                            @endif
                                        </p>
                                        <p class="leading-6">{{ $user_plan_data->urgent_limit }} {{ __('urgent_listing') }} {{ __('remaining') }}.</p>
                                    </div>
                                </div>
                            </label>
                            @else
                            <label for="urgent" class="cursor-pointer flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-red-50 w-full">
                                <input disabled @checked(old('urgent', $ad?->urgent ?? '') == 1) type="checkbox" class="hidden" name="urgent" id="urgent" value="0">
                                <div class="flex align-center">
                                    <img class="h-14" src="{{ asset('frontend/images/promotions-img/urgent-promote.svg') }}"
                                    alt="">
                                    <div class="text-left grow ml-3">
                                        <h3 class="heading-07 !text-red-500">
                                            {{ __('urgent_limit') }} {{ __('crossed') }},
                                            <a href="{{ route('frontend.plans-billing') }}" class="underline text-blue-500">{{ __('please_upgrade_plan') }}</a>
                                        </h3>
                                        <h3 class="heading-07">{{ __('urgent_listing') }}</h3>
                                        <p class="leading-6">{{ __('select_this_promotion_to_make_listing_urgent') }}.</p>
                                    </div>
                                </div>
                            </label>
                        @endif
                    </div>
                    <!-- Promotion Item End -->

                    <!-- Promotion Item Start -->
                    <div class="promotion-item mt-3 mb-3">
                        <input name="highlight" type="hidden" value="0">
                        @if ($user_plan_data->highlight_limit > 0)
                            <label for="highlight" class="cursor-pointer flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-gray-50 w-full">
                                <input @checked(old('highlight', $ad?->highlight ?? '') == 1) type="checkbox" class="hidden" name="highlight" id="highlight" value="1">
                                <div class="flex align-center">
                                    <img class="h-14" src="{{ asset('frontend/images/promotions-img/highlight-promote.svg') }}"
                                    alt="">
                                    <div class="text-left grow ml-3">
                                        <h3 class="heading-07">{{ __('highlight_listing') }}</h3>
                                        <p class="leading-6">
                                            {{ __('select_this_promotion_to_make_listing_highlight') }}
                                            {{ __('for') }}
                                            {{ $plan->highlight_duration < 1 ? __('lifetime') : $plan->highlight_duration }}
                                            @if ($plan->highlight_duration == 1)
                                                {{ __('day') }}.
                                            @else
                                                {{ __('days') }}.
                                            @endif
                                        </p>
                                        <p class="leading-6">{{ $user_plan_data->highlight_limit }} {{ __('highlight_listing') }} {{ __('remaining') }}.</p>
                                    </div>
                                </div>
                            </label>
                            @else
                            <label for="highlight" class="cursor-pointer flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-red-50 w-full">
                                <input disabled @checked(old('highlight', $ad?->highlight ?? '') == 1) type="checkbox" class="hidden" name="featured" id="featured" value="0">
                                <div class="flex align-center">
                                    <img class="h-14" src="{{ asset('frontend/images/promotions-img/highlight-promote.svg') }}"
                                    alt="">
                                    <div class="text-left grow ml-3">
                                        <h3 class="heading-07 !text-red-500">
                                            {{ __('highlight_limit') }} {{ __('crossed') }},
                                            <a href="{{ route('frontend.plans-billing') }}" class="underline text-blue-500">{{ __('please_upgrade_plan') }}</a>
                                        </h3>
                                        <h3 class="heading-07">{{ __('highlight_listing') }}</h3>
                                        <p class="leading-6">{{ __('select_this_promotion_to_make_listing_highlight') }}.</p>
                                    </div>
                                </div>
                            </label>
                        @endif
                    </div>
                    <!-- Promotion Item End -->

                    <!-- Promotion Item Start -->
                    <div class="promotion-item mt-3 mb-3">
                        <input name="top" type="hidden" value="0">
                        @if ($user_plan_data->top_limit > 0)
                            <label for="top" class="cursor-pointer flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-gray-50 w-full">
                                <input @checked(old('top', $ad?->top ?? '') == 1) type="checkbox" class="hidden" name="top" id="top" value="1">
                                <div class="flex align-center">
                                    <img class="h-14" src="{{ asset('frontend/images/promotions-img/top-promote.svg') }}"
                                    alt="">
                                    <div class="text-left grow ml-3">
                                        <h3 class="heading-07">{{ __('top_listing') }}</h3>
                                        <p class="leading-6">{{ __('select_this_promotion_to_make_listing_top') }}
                                            {{ __('for') }}
                                            {{ $plan->top_duration < 1 ? __('lifetime') : $plan->top_duration }}
                                            @if ($plan->top_duration == 1)
                                                {{ __('day') }}.
                                            @else
                                                {{ __('days') }}.
                                            @endif
                                        </p>
                                        <p class="leading-6">{{ $user_plan_data->top_limit }} {{ __('top_listing') }} {{ __('remaining') }}.</p>
                                    </div>
                                </div>
                            </label>
                            @else
                            <label for="top" class="cursor-pointer flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-red-50 w-full">
                                <input disabled @checked(old('top', $ad?->top ?? '') == 1) type="checkbox" class="hidden" name="top" id="top" value="0">
                                <div class="flex align-center">
                                    <img class="h-14" src="{{ asset('frontend/images/promotions-img/top-promote.svg') }}"
                                    alt="">
                                    <div class="text-left grow ml-3">
                                        <h3 class="heading-07 !text-red-500">
                                            {{ __('top_limit') }} {{ __('crossed') }},
                                            <a href="{{ route('frontend.plans-billing') }}" class="underline text-blue-500">{{ __('please_upgrade_plan') }}</a>
                                        </h3>
                                        <h3 class="heading-07">{{ __('top_listing') }}</h3>
                                        <p class="leading-6">{{ __('select_this_promotion_to_make_listing_top') }}.</p>
                                    </div>
                                </div>
                            </label>
                        @endif
                    </div>
                    <!-- Promotion Item End -->

                    <!-- Promotion Item Start -->
                    <div class="promotion-item mt-3 mb-3">
                        <input name="bump_up" type="hidden" value="0">
                        @if ($user_plan_data->bump_up_limit > 0)
                            <label for="bump_up" class="cursor-pointer flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-gray-50 w-full">
                                <input @checked(old('bump_up', $ad?->bump_up ?? '') == 1) type="checkbox" class="hidden" name="bump_up" id="bump_up" value="1">
                                <div class="flex align-center">
                                    <img class="h-14" src="{{ asset('frontend/images/promotions-img/bumpup-promote.svg') }}"
                                    alt="">
                                    <div class="text-left grow ml-3">
                                        <h3 class="heading-07">{{ __('bump_up_listing') }}</h3>
                                        <p class="leading-6">
                                            {{ __('select_this_promotion_to_make_listing_bump_up') }}
                                            {{ __('for') }}
                                            {{ $plan->bump_up_duration < 1 ? __('lifetime') : $plan->bump_up_duration }}
                                            @if ($plan->bump_up_duration == 1)
                                                {{ __('day') }}.
                                            @else
                                                {{ __('days') }}.
                                            @endif
                                        </p>
                                        <p class="leading-6">{{ $user_plan_data->bump_up_limit }} {{ __('bump_up_listing') }} {{ __('remaining') }}.</p>
                                    </div>
                                </div>
                            </label>
                            @else
                            <label for="bump_up" class="cursor-pointer flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-red-50 w-full">
                                <input disabled @checked(old('bump_up', $ad?->bump_up ?? '') == 1) type="checkbox" class="hidden" name="bump_up" id="bump_up" value="0">
                                <div class="flex align-center">
                                    <img class="h-14" src="{{ asset('frontend/images/promotions-img/bumpup-promote.svg') }}"
                                    alt="">
                                    <div class="text-left grow ml-3">
                                        <h3 class="heading-07 !text-red-500">
                                            {{ __('bump_up_limit') }} {{ __('crossed') }},
                                            <a href="{{ route('frontend.plans-billing') }}" class="underline text-blue-500">{{ __('please_upgrade_plan') }}</a>
                                        </h3>
                                        <h3 class="heading-07">{{ __('bump_up_listing') }}</h3>
                                        <p class="leading-6">{{ __('select_this_promotion_to_make_listing_bump_up') }}.</p>
                                    </div>
                                </div>
                            </label>
                        @endif
                    </div>
                    <!-- Promotion Item End -->

                </div>
                <!--Promotions Selecting Option -->

            </div>
            <div class="post-footer">
                <input type="submit" name="draft" class="btn-secondary cursor-pointer py-3 px-5"
                    value="{{ __('save_on_draft') }}" />
                <div>
                    <a href="{{ route('frontend.post.step2.back') }}"
                        onclick="return confirm('{{ __('are_you_sure_to_go_back') }}')"
                        class="py-3 px-5">{{ __('back') }}</a>
                    <button type="submit" class="btn-primary py-3 px-5">{{ __('post_listing') }}</button>
                </div>
        </form>
    </div>
@endsection

@push('css')
    <style>
        .promote-ad {
            min-width: 150px;
            text-align: center;
        }
        .promote-ad:has(input:checked) {
            border-color: var(--primary-500);
            background: var(--primary-50);
        }
    </style>
@endpush
