@extends('frontend.layouts.dashboard')
@section('title')
    {{ __('affiliate') }}
@endsection
@section('breadcrumb')
    <x-frontend.breadcrumb.breadcrumb :links="[['text' => 'Dashboard', 'url' => '/'], ['text' => 'Become Affiliate']]" />
@endsection
@section('dashboard-content')
    <div class="space-y-[2rem] lg:space-y-[3rem]">
        <div class="p-[6px] w-full rounded-2xl">
            <div class="bg-white flex flex-wrap flex-col xl:flex-row items-center gap-5 p-[2rem] rounded-lg ">
                <div class="max-w-[22.4rem]">
                    <img src="{{ asset('frontend/images/affiliate-banner.png') }}" alt="{{ __('affiliate img') }}">
                </div>

                <div class="flex-1 space-y-[1rem]">
                    <h6 class="body-md-500 text-gray-900">
                        {{ __('get') }} <span class="caption-01 bg-error-50 text-error-500 py-[0.38rem] px-[0.5rem]">{{ __('points') }}</span>
                        {{ __('for_each_invitation') }}
                    </h6>
                    <div class="space-y-[0.75rem]">
                        <h4 class="heading-05 text-gray-900">
                            {{ __('join_our_affiliate_program') }}
                        </h4>
                        <p class="body-md-400 text-gray-700">
                            {{ __('embrace_the_oppurtunity') }}
                        </p>
                    </div>
                    <div>
                        <a class="btn-primary" href="{{ route('frontend.become.affiliate') }}">
                            {{ __('generate_links') }}
                            <x-frontend.icons.arrow-right />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full space-y-[1.5rem]">
            <h4 class="caption-02 dark:text-white text-gray-900 capitalize text-center w-full">
                {{ __('how_this_work') }}
            </h4>
            <ul
                class="items-center flex justify-center relative flex-wrap flex-col md:flex-row lg:flex-nowrap after:absolute after:hidden lg:after:block after:w-[70%]  after:h-[0.0625rem] after:bg-primary-500 after:top-[20%] after:left-[50%] after:translate-x-[-50%] after:translate-y-[-20%]">
                <li
                    class="w-full relative mb-6 sm:mb-0 p-[1.5rem] group flex flex-col items-center justify-center gap-[1.2rem] min-w-[19.5rem]">
                    <div
                        class="z-10 text-primary-500 group-hover:text-white group-hover:bg-primary-500 transition all duration-200 flex items-center justify-center w-[3rem] h-[3rem] bg-primary-50 rounded-full ring-1 ring-primary-500  shrink-0">
                        <x-svg.heroicons.arrow-right-circle />
                    </div>
                    <div class="text-center space-y-[0.5rem]">
                        <h3 class="heading-07 text-gray-900 dark:text-white">{{ __('apply_to_become_affiliator') }}</h3>
                        <p class="body-sm-400 text-gray-600 dark:text-gray-200">{{ __('this_process_sometimes_takes_some_time') }}</p>
                    </div>
                </li>

                <li
                    class="w-full relative mb-6 sm:mb-0 p-[1.5rem] group flex flex-col items-center justify-center gap-[1.2rem] min-w-[19.5rem] self-start">
                    <div
                        class="z-10 text-primary-500 group-hover:text-white group-hover:bg-primary-500 transition all duration-200 flex items-center justify-center w-[3rem] h-[3rem] bg-primary-50 rounded-full ring-1 ring-primary-500  shrink-0">
                        <x-svg.heroicons.share />
                    </div>
                    <div class="text-center space-y-[0.5rem]">
                        <h3 class="heading-07 text-gray-900 dark:text-white">{{ __('invite_peoples_with_referral_url') }}</h3>
                        <p class="body-sm-400 text-gray-600 dark:text-gray-200">{{ __('invite_your_friends_to_register_on_adlisting') }}</p>
                    </div>
                </li>

                <li
                    class="w-full relative mb-6 sm:mb-0 p-[1.5rem] group flex flex-col items-center justify-center gap-[1.2rem] min-w-[19.5rem] self-start">
                    <div
                        class="z-10 text-primary-500 group-hover:text-white group-hover:bg-primary-500 transition all duration-200 flex items-center justify-center w-[3rem] h-[3rem] bg-primary-50 rounded-full ring-1 ring-primary-500  shrink-0">
                        <x-svg.heroicons.credit-card />
                    </div>
                    <div class="text-center space-y-[0.5rem]">
                        <h3 class="heading-07 text-gray-900 dark:text-white">{{ __('earn_money_and_withdraw_whenever_you_want') }}</h3>
                        <p class="body-sm-400 text-gray-600 dark:text-gray-200">
                            {{ __('you_will_receive_1_usd_for_each_invitation') }}
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

@endsection
