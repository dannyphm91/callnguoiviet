<div class="relative lg:pe-[80px] w-full rounded-lg p-4 shadow-[0px_2px_4px_0px_rgba(28,33,38,0.03)] flex flex-col lg:flex-row  transition-all duration-100  gap-6 border border-gray-100 dark:border-gray-600 hover:listing-card-gradient"
    x-data="{ promoteModal: false }">
    <div class="flex flex-col lg:flex-row flex-grow lg:items-center gap-4">
        <a href="{{ route('frontend.addetails', $ad->slug) }}" class="w-full rounded-md overflow-hidden lg:max-w-[6rem]">
            <img src="{{ $ad->thumbnail }}" alt="listing img" class="w-full lg:h-auto h-[200px] object-contain" />
        </a>
        <div class="sapce-y-2 lg:w-[400px] sm:mt-0 flex flex-col">
            <span class="body-sm-500 text-primary-500 dark:text-primary-300">
                {{ $ad->category->name }}
            </span>

            <a href="{{ route('frontend.addetails', $ad->slug) }}">
                <p class="heading-07 text-gray-900 dark:text-white line-clamp-1 pt-3 lg:pt-0">
                    {{ $ad->title }}
                </p>
            </a>
            <div class="body-sm-400 text-gray-700 dark:text-gray-300 flex items-center gap-x-1 mt-1 line-clamp-1">
                <x-frontend.icons.locate />
                {{ $ad->district ? $ad->district . ', ' : '' }}
                {{ $ad->region ? $ad->region . ', ' : '' }}
                {{ $ad->country ?? '' }}
            </div>
            <div class="flex flex-wrap gap-2 mt-2">

                @if ($ad->featured && now() >= $ad->featured_at && now() <= $ad->featured_till)
                    <span class="text-xs bg-primary-100 dark:bg-gray-500 px-2 py-0.5 rounded">
                        {{ __('featured') }}
                    </span>
                @endif

                @if ($ad->urgent && now() >= $ad->urgent_at && now() <= $ad->urgent_till)
                    <span class="text-xs bg-primary-100 dark:bg-gray-500 px-2 py-0.5 rounded">
                        {{ __('urgent') }}
                    </span>
                @endif

                @if ($ad->highlight && now() >= $ad->highlight_at && now() <= $ad->highlight_till)
                    <span class="text-xs bg-primary-100 dark:bg-gray-500 px-2 py-0.5 rounded">
                        {{ __('highlight') }}
                    </span>
                @endif

                @if ($ad->top && now() >= $ad->top_at && now() <= $ad->top_till)
                    <span class="text-xs bg-primary-100 px-2 py-0.5 rounded">
                        {{ __('top') }}
                    </span>
                @endif

                @if ($ad->bump_up && now() >= $ad->bump_up_at && now() <= $ad->bump_up_till)
                    <span class="text-xs bg-primary-100 dark:bg-gray-500 px-2 py-0.5 rounded">
                        {{ __('bump_up') }}
                    </span>
                @endif

            </div>
        </div>
    </div>
    <div class="flex-grow flex flex-col lg:flex-row gap-5 justify-between">
        <div class="flex flex-wrap gap-x-6 lg:gap-x-12 gap-y-2.5 flex-grow justify-between items-center">
            <div class="space-y-2 self-center">
                <h5 class="heading-05 text-error-500 dark:text-error-700">{{ currentCurrencySymbol() }}{{ $ad->price }}</h5>
            </div>

            <div class="space-y-2 flex flex-col items-center justify-center">
                @if ($ad->status == 'active')
                    <x-frontend.my-listing.active-badge />
                @elseif($ad->resubmission == '1')
                    <x-frontend.my-listing.resubmission-badge />
                @else
                    <x-frontend.my-listing.status :status="$ad->status" />
                @endif
            </div>
            <div class="body-md-400 whitespace-nowrap justify-end text-gray-700 dark:text-gray-300 flex flex-grow items-center">
                {{ $ad->created_at->diffForHumans() }}
            </div>
        </div>
        <div class="absolute z-10 lg:end-5 end-6 lg:top-1/2 lg:-translate-y-1/2 top-[224px]">
            <div class="relative group" x-data="{ showMenu: false }" x-init @click.outside="showMenu = false">
                <button type="button" @click="showMenu = !showMenu"
                    class="flex items-center justify-center ms-auto text-white bg-gray-100 lg:bg-transparent rounded-full w-9 h-9 lg:hover:bg-gray-100 ">
                    <x-svg.horizontal-dots />
                </button>
                <div class="absolute !z-[9999] top-9 right-0" x-cloak x-show="showMenu" x-transition>
                    <ul
                        class=" bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-600 min-w-[15rem] sm:min-w-[18.3rem] py-3 rounded-lg shadow-[0px_4px_6px_-2px_rgba(16,24,40,0.03),0px_12px_16px_-4px_rgba(16,24,40,0.08)]">
                        <li>
                            <a href="{{ route('frontend.addetails', $ad->slug) }}"
                                class="btn gap-x-[0.5rem] body-md-400 text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:dark:text-gray-100 hover:bg-primary-50 hover:dark:bg-gray-700 transition-all duration-150 flex items-center px-4 py-[0.62rem]">
                                <x-frontend.icons.eye />
                                <span class="text-sm font-medium">{{ __('view_listing_details') }}</span>
                            </a>
                        </li>
                        @if ($ad->status == 'active')
                            <li>
                                <form action="{{ route('frontend.myad.status', $ad->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button
                                        onclick="return confirm('{{ __('are_you_sure_you_want_to_sold_this_item') }}?');"
                                        type="submit"
                                        class="gap-x-[0.5rem] w-full body-md-400 text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:dark:text-gray-100 hover:bg-primary-50 hover:dark:bg-gray-700 transition-all duration-150 flex items-center px-4 py-[0.62rem]">
                                        <x-frontend.icons.cross />
                                        <span class="text-sm font-medium">{{ __('mark_as_sold') }}</span>
                                    </button>
                                </form>
                            </li>
                        @endif
                        @if ($ad->status == 'sold')
                            <li>
                                <form action="{{ route('frontend.myad.status', $ad->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button
                                        onclick="return confirm('{{ __('are_you_sure_you_want_to_active_this_item') }}?');"
                                        type="submit"
                                        class="gap-x-[0.5rem] w-full body-md-400 text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:dark:text-gray-100 hover:bg-primary-50 hover:dark:bg-gray-700 transition-all duration-150 flex items-center px-4 py-[0.62rem]">
                                        <x-frontend.icons.check />
                                        <span class="text-sm font-medium">{{ __('mark_as_active') }}</span>
                                    </button>
                                </form>
                            </li>
                        @endif

                        <li>
                            <button @click="showMenu = false" data-modal-target="promote-modal" data-modal-toggle="promote-modal"
                                class="gap-x-[0.5rem] w-full body-md-400 text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:dark:text-gray-100 hover:bg-primary-50 hover:dark:bg-gray-700 transition-all duration-150 flex items-center px-4 py-[0.62rem]">
                                <x-svg.promote />
                                <span class="text-sm font-medium">{{ __('promote_listing') }}</span>
                            </button>
                        </li>
                        <li>
                            <a href="{{ route('frontend.post.edit', $ad->slug) }}"
                                class="btn gap-x-[0.5rem] body-md-400 text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:dark:text-gray-100 hover:bg-primary-50 hover:dark:bg-gray-700 transition-all duration-150 flex items-center px-4 py-[0.62rem]">
                                <x-frontend.icons.edit />
                                <span class="text-sm font-medium">{{ __('edit') }}</span>
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('frontend.post.delete', $ad->slug) }}">
                                @csrf
                                @method('DELETE')
                                <button
                                    onclick="return confirm('{{ __('are_you_sure_you_want_to_delete_this_item') }}?');"
                                    type="submit"
                                    class="gap-x-[0.5rem] w-full body-md-400 text-gray-700 dark:text-gray-300 hover:text-gray-900 hover:dark:text-gray-100 hover:bg-primary-50 hover:dark:bg-gray-700 transition-all duration-150 flex items-center px-4 py-[0.62rem]">
                                    <x-frontend.icons.trash />
                                    <span class="text-sm font-medium">{{ __('delete') }}</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Promote Listing Modal Start -->
        <div id="promote-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div @click.outside="promoteModal = false"
                class="bg-white p-6 rounded-lg relative w-full max-h-[96vh] my-12 overflow-y-auto max-w-2xl"
                x-data="{ selectPromote: '' }">
                <div class="flex flex-wrap gap-6 justify-between items-center mb-6">
                    <h2 class="heading-05">{{ __('choose_promotion_type') }}</h2>
                    <button data-modal-hide="promote-modal" type="button"
                        class="p-1.5 bg-white hover:bg-primary-50 border border-gray-100 rounded-full">
                        <x-frontend.icons.close />
                    </button>
                </div>

                <form method="POST" action="{{ route('frontend.promote-listing', $ad->slug) }}">
                    @csrf
                    <div class="promotions-wrapper">

                        <!-- Promotion Item Start -->
                        <div class="promotion-item mt-3 mb-3">
                            <input name="featured" type="hidden" value="0">
                            @if ($userPlan->featured_limit > 0)
                                <label for="featured"
                                    class="flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-gray-50 w-full">
                                    <input @checked($ad?->featured == 1) type="checkbox" class="hidden" name="featured"
                                        id="featured" value="1">
                                    <div class="flex align-center">
                                        <img class="h-14"
                                            src="{{ asset('frontend/images/promotions-img/featured-promote.svg') }}"
                                            alt="">
                                        <div class="text-left grow ml-3">
                                            <h3 class="heading-07">{{ __('featured_listing') }}</h3>
                                            <p class="">
                                                {{ __('select_this_promotion_to_make_listing_featured') }}
                                                {{ __('for') }}
                                                {{ $plan->featured_duration < 1 ? __('lifetime') : $plan->featured_duration }}
                                                @if ($plan->featured_duration == 1)
                                                    {{ __('day') }}
                                                @else
                                                    {{ __('days') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            @else
                                <label for="featured"
                                    class="flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-red-50 w-full">
                                    <input disabled @checked(old('featured', $ad?->featured ?? '') == 1) type="checkbox" class="hidden"
                                        name="featured" id="featured" value="0">
                                    <div class="flex align-center">
                                        <img class="h-14"
                                            src="{{ asset('frontend/images/promotions-img/featured-promote.svg') }}"
                                            alt="">
                                        <div class="text-left grow ml-3">
                                            <h3 class="heading-07 !text-red-500">
                                                {{ __('featured_limit') }} {{ __('crossed') }},
                                                <a href="{{ route('frontend.plans-billing') }}"
                                                    class="underline text-blue-500">{{ __('please_upgrade_plan') }}</a>
                                            </h3>
                                            <h3 class="heading-07">{{ __('featured_listing') }}</h3>
                                            <p class="">
                                                {{ __('select_this_promotion_to_make_listing_featured') }}</p>
                                        </div>
                                    </div>
                                </label>
                            @endif
                        </div>
                        <!-- Promotion Item End -->

                        <!-- Promotion Item Start -->
                        <div class="promotion-item mt-3 mb-3">
                            <input name="urgent" type="hidden" value="0">
                            @if ($userPlan->urgent_limit > 0)
                                <label for="urgent"
                                    class="flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-gray-50 w-full">
                                    <input @checked($ad?->urgent == 1) type="checkbox" class="hidden" name="urgent"
                                        id="urgent" value="1">
                                    <div class="flex align-center">
                                        <img class="h-14"
                                            src="{{ asset('frontend/images/promotions-img/urgent-promote.svg') }}"
                                            alt="">
                                        <div class="text-left grow ml-3">
                                            <h3 class="heading-07">{{ __('urgent_listing') }}</h3>
                                            <p class="">{{ __('select_this_promotion_to_make_listing_urgent') }}
                                                {{ __('for') }}
                                                {{ $plan->urgent_duration < 1 ? __('lifetime') : $plan->urgent_duration }}
                                                @if ($plan->urgent_duration == 1)
                                                    {{ __('day') }}
                                                @else
                                                    {{ __('days') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            @else
                                <label for="urgent"
                                    class="flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-red-50 w-full">
                                    <input disabled @checked(old('urgent', $ad?->urgent ?? '') == 1) type="checkbox" class="hidden"
                                        name="urgent" id="urgent" value="0">
                                    <div class="flex align-center">
                                        <img class="h-14"
                                            src="{{ asset('frontend/images/promotions-img/urgent-promote.svg') }}"
                                            alt="">
                                        <div class="text-left grow ml-3">
                                            <h3 class="heading-07 !text-red-500">
                                                {{ __('urgent_limit') }} {{ __('crossed') }},
                                                <a href="{{ route('frontend.plans-billing') }}"
                                                    class="underline text-blue-500">{{ __('please_upgrade_plan') }}</a>
                                            </h3>
                                            <h3 class="heading-07">{{ __('urgent_listing') }}</h3>
                                            <p class="">{{ __('select_this_promotion_to_make_listing_urgent') }}
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            @endif
                        </div>
                        <!-- Promotion Item End -->

                        <!-- Promotion Item Start -->
                        <div class="promotion-item mt-3 mb-3">
                            <input name="highlight" type="hidden" value="0">
                            @if ($userPlan->highlight_limit > 0)
                                <label for="highlight"
                                    class="flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-gray-50 w-full">
                                    <input @checked($ad?->highlight == 1) type="checkbox" class="hidden"
                                        name="highlight" id="highlight" value="1">
                                    <div class="flex align-center">
                                        <img class="h-14"
                                            src="{{ asset('frontend/images/promotions-img/highlight-promote.svg') }}"
                                            alt="">
                                        <div class="text-left grow ml-3">
                                            <h3 class="heading-07">{{ __('highlight_listing') }}</h3>
                                            <p class="">
                                                {{ __('select_this_promotion_to_make_listing_highlight') }}
                                                {{ __('for') }}
                                                {{ $plan->highlight_duration < 1 ? __('lifetime') : $plan->urgent_duration }}
                                                @if ($plan->highlight_duration == 1)
                                                    {{ __('day') }}
                                                @else
                                                    {{ __('days') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            @else
                                <label for="highlight"
                                    class="flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-red-50 w-full">
                                    <input disabled @checked(old('highlight', $ad?->highlight ?? '') == 1) type="checkbox" class="hidden"
                                        name="featured" id="featured" value="0">
                                    <div class="flex align-center">
                                        <img class="h-14"
                                            src="{{ asset('frontend/images/promotions-img/highlight-promote.svg') }}"
                                            alt="">
                                        <div class="text-left grow ml-3">
                                            <h3 class="heading-07 !text-red-500">
                                                {{ __('highlight_limit') }} {{ __('crossed') }},
                                                <a href="{{ route('frontend.plans-billing') }}"
                                                    class="underline text-blue-500">{{ __('please_upgrade_plan') }}</a>
                                            </h3>
                                            <h3 class="heading-07">{{ __('highlight_listing') }}</h3>
                                            <p class="">
                                                {{ __('select_this_promotion_to_make_listing_highlight') }}</p>
                                        </div>
                                    </div>
                                </label>
                            @endif
                        </div>
                        <!-- Promotion Item End -->

                        <!-- Promotion Item Start -->
                        <div class="promotion-item mt-3 mb-3">
                            <input name="top" type="hidden" value="0">
                            @if ($userPlan->top_limit > 0)
                                <label for="top"
                                    class="flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-gray-50 w-full">
                                    <input @checked($ad?->top == 1) type="checkbox" class="hidden" name="top"
                                        id="top" value="1">
                                    <div class="flex align-center">
                                        <img class="h-14"
                                            src="{{ asset('frontend/images/promotions-img/top-promote.svg') }}"
                                            alt="">
                                        <div class="text-left grow ml-3">
                                            <h3 class="heading-07">{{ __('top_listing') }}</h3>
                                            <p class="">{{ __('select_this_promotion_to_make_listing_top') }}
                                                {{ __('for') }}
                                                {{ $plan->top_duration < 1 ? __('lifetime') : $plan->top_duration }}
                                                @if ($plan->top_duration == 1)
                                                    {{ __('day') }}
                                                @else
                                                    {{ __('days') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            @else
                                <label for="top"
                                    class="flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-red-50 w-full">
                                    <input disabled @checked(old('top', $ad?->top ?? '') == 1) type="checkbox" class="hidden"
                                        name="top" id="top" value="0">
                                    <div class="flex align-center">
                                        <img class="h-14"
                                            src="{{ asset('frontend/images/promotions-img/top-promote.svg') }}"
                                            alt="">
                                        <div class="text-left grow ml-3">
                                            <h3 class="heading-07 !text-red-500">
                                                {{ __('top_limit') }} {{ __('crossed') }},
                                                <a href="{{ route('frontend.plans-billing') }}"
                                                    class="underline text-blue-500">{{ __('please_upgrade_plan') }}</a>
                                            </h3>
                                            <h3 class="heading-07">{{ __('top_listing') }}</h3>
                                            <p class="">{{ __('select_this_promotion_to_make_listing_top') }}
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            @endif
                        </div>
                        <!-- Promotion Item End -->

                        <!-- Promotion Item Start -->
                        <div class="promotion-item mt-3 mb-3">
                            <input name="bump_up" type="hidden" value="0">
                            @if ($userPlan->bump_up_limit > 0)
                                <label for="bump_up"
                                    class="flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-gray-50 w-full">
                                    <input @checked($ad?->bump_up == 1) type="checkbox" class="hidden" name="bump_up"
                                        id="bump_up" value="1">
                                    <div class="flex align-center">
                                        <img class="h-14"
                                            src="{{ asset('frontend/images/promotions-img/bumpup-promote.svg') }}"
                                            alt="">
                                        <div class="text-left grow ml-3">
                                            <h3 class="heading-07">{{ __('bump_up_listing') }}</h3>
                                            <p class="">
                                                {{ __('select_this_promotion_to_make_listing_bump_up') }}
                                                {{ __('for') }}
                                                {{ $plan->bump_up_duration < 1 ? __('lifetime') : $plan->bump_up_duration }}
                                                @if ($plan->bump_up_duration == 1)
                                                    {{ __('day') }}
                                                @else
                                                    {{ __('days') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </label>
                            @else
                                <label for="bump_up"
                                    class="flex promote-ad border-2 border-transparent px-4 py-3 rounded-md bg-red-50 w-full">
                                    <input disabled @checked(old('bump_up', $ad?->bump_up ?? '') == 1) type="checkbox" class="hidden"
                                        name="bump_up" id="bump_up" value="0">
                                    <div class="flex align-center">
                                        <img class="h-14"
                                            src="{{ asset('frontend/images/promotions-img/bumpup-promote.svg') }}"
                                            alt="">
                                        <div class="text-left grow ml-3">
                                            <h3 class="heading-07 !text-red-500">
                                                {{ __('bump_up_limit') }} {{ __('crossed') }},
                                                <a href="{{ route('frontend.plans-billing') }}"
                                                    class="underline text-blue-500">{{ __('please_upgrade_plan') }}</a>
                                            </h3>
                                            <h3 class="heading-07">{{ __('bump_up_listing') }}</h3>
                                            <p class="">
                                                {{ __('select_this_promotion_to_make_listing_bump_up') }}</p>
                                        </div>
                                    </div>
                                </label>
                            @endif
                        </div>
                        <!-- Promotion Item End -->

                    </div>

                    <div class="mt-4 flex justify-end gap-3 items-center">
                        <button type="submit" class="btn-primary capitalize">{{ __('promote_now') }}</button>
                        <button type="button" class="btn-secondary" data-modal-hide="promote-modal" type="button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Promote Listing Modal Start -->

    </div>
</div>

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
