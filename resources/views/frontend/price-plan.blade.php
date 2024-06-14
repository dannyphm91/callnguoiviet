@extends('frontend.layouts.app')

@section('title', __('price_plan'))

@section('content')
    <x-frontend.breadcrumb.breadcrumb :links="[['url' => '#', 'text' => __('price_plan')]]" />
    <div class="relative dark:bg-gray-800" x-data="{ hello: 'world' }">
        <div aria-hidden="true" class="absolute -top-48 start-0 -z-[1] hidden xl:flex">
            <div class="bg-purple-200 opacity-30 blur-3xl w-[1036px] h-[600px] "></div>
            <div class="bg-slate-200 opacity-90 blur-3xl w-[577px] h-[300px] transform translate-y-32 ">
            </div>
        </div>
        <div class="container lg:py-10 py-6 lg:mt-10 mt-4 space-y-[2rem]">
            <div
                class="lg:py-[4rem] flex flex-col lg:flex-row justify-between gap-x-[8.5rem] gap-y-5 lg:gap-y-0 items-center w-full">
                <div class=" space-y-[1.25rem] w-full lg:max-w-[33.5rem] lg:order-1 order-2">
                    <h1 class="heading-01 text-gray-900 dark:text-white">{{ __('get_membership') }}</h1>
                    <p class="body-md-400 text-gray-700 dark:text-gray-100">{{ __('get_membership_description') }}</p>
                    <a href="#price_plan_selection" class="btn-primary">{{ __('get_membership') }}</a>
                </div>
                <div class="space-y-[1.25rem] w-full lg:max-w-[33.5rem] lg:order-1 order-2">
                        <h1 class="heading-01 text-gray-900 dark:text-white">{{ __('pay_per_ads') }}</h1>
                        <p class="body-md-400 text-gray-700 dark:text-gray-100">{{ __('pay_per_ads_description') }}</p>
                        <a href="{{ route('frontend.payper.ads.post') }}" class="btn-primary">{{ __('pay_per_ads_post') }}</a>
                </div>
            </div>

            <div
                class="mt-[4rem] bg-[linear-gradient(117deg,#E8F0FC_0%,#F3E8FC_83.67%)] p-[2rem] md:p-[4rem] rounded-[2rem]">
                <h2 class="heading-01 text-gray-900 text-center">{{ __('benefits_and_feature_membership') }}</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-[1.5rem] mt-[2.25rem]">

                    @foreach ($price_plan_services as $price_plan_service)
                        <div
                            class="bg-white rounded-xl py-[2rem] px-6 flex flex-col md:flex-row items-start gap-x-[1.5rem]">
                            <div>
                                <img src="{{ asset($price_plan_service->service_icon) }}" alt="post img" class=" w-full" />
                            </div>
                            <div class="space-y-[0.63rem] text-left flex-1">
                                <h6 class="heading-06 text-gray-900">{{ $price_plan_service->title }}</h6>
                                <p class="body-md-400 text-gray-700">{{ $price_plan_service->description }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <div id="price_plan_selection" class="max-w-[85rem] px-4 pt-10 sm:px-6 lg:px-8 lg:pt-14 mx-auto">
            <!-- Title -->
            <div class="max-w-2xl mx-auto text-center mb-10">
                <h2
                    class="text-3xl leading-tight font-bold md:text-4xl md:leading-tight lg:text-5xl lg:leading-tight bg-clip-text bg-gradient-to-r from-primary-500 to-fuchsia-700 text-transparent">
                    {{ __('simple_transparent_pricing') }}</h2>
                <p class="mt-2 lg:text-lg text-gray-800 ">
                    {{ __('whatever_your_status_our_offers_evolve_according_to_your_needs') }}</p>
            </div>

            <div class="flex justify-center items-center">
                <label for="pricing-switch" class="min-w-[3.5rem] text-sm dark:text-gray-100 text-gray-600 me-3 ">
                    {{ __('one_time') }}
                </label>

                <input onclick="changePlanType()" type="checkbox" id="pricing-switch" class="relative w-[3.25rem] h-7 p-px bg-primary-50 border-transparent text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-0 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-primary-500 checked:border-primary-500 before:inline-block before:w-6 before:h-6 before:bg-white checked:before:bg-white before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200">

                <label for="pricing-switch" class="min-w-[3.5rem] text-sm dark:text-gray-100 text-gray-600 ms-3 ">
                    {{ __('recurring') }}
                </label>
            </div>
            <!-- End Switch -->

            <!-- Grid -->
            <div class="mt-6 md:mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6 lg:gap-3 xl:gap-6 lg:items-center">
                @foreach ($plans as $plan)
                    <x-frontend.plan.single-plan :plan="$plan" />
                @endforeach
            </div>
            <!-- End Grid -->

            <!-- Title -->
            <div class="w-2/3 sm:w-1/2 lg:w-1/3 mx-auto text-center mt-10 md:mt-14 mb-6 lg:mt-24">
                <h2 class="text-gray-600 dark:text-gray-100">
                    {{ __('trusted_by_open_source_enterprise_and_more_than_99,000_of_you') }} </h2>
            </div>
            <!-- End Title -->

            <!-- Clients -->
            <div class="swiper brand-slider">
                <div class="swiper-wrapper">
                    @foreach ($aboutSliders as $aboutSlider)
                        <div class="swiper-slide inline-flex max-w-max">
                            <img class="w-[120px] h-[45px] object-contain grayscale dark:grayscale-0"
                                src="{{ $aboutSlider->ImageUrl }}" alt="brand-icon" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div
            class="absolute top-1/2 start-1/2 -z-[1] transform -translate-y-1/2 -translate-x-1/2 w-[340px] h-[340px] border border-dashed border-violet-200 rounded-full hidden lg:block">
        </div>
        <div
            class="absolute top-1/2 start-1/2 -z-[1] transform -translate-y-1/2 -translate-x-1/2 w-[575px] h-[575px] border border-dashed border-violet-200 rounded-full opacity-80 hidden lg:block">
        </div>
        <div
            class="absolute top-1/2 start-1/2 -z-[1] transform -translate-y-1/2 -translate-x-1/2 w-[840px] h-[840px] border border-dashed border-violet-200 rounded-full opacity-60 hidden lg:block">
        </div>
        <div
            class="absolute top-1/2 start-1/2 -z-[1] transform -translate-y-1/2 -translate-x-1/2 w-[1080px] h-[1080px] border border-dashed border-violet-200 rounded-full opacity-40 hidden lg:block">
        </div>


        <div class="container mt-10 space-y-[2rem]">
            <section class="price_plan_one_time space-y-[3rem] py-5">
                <div class="text-center space-y-2">
                    <h4 class="heading-03 text-gray-900 dark:text-white">{{ __('payment_methods') }}</h4>
                    <p class="body-base-500 text-gray-700 dark:text-gray-100">
                        {{ __('we_offer_the_most_popular_payment_methods_you_can_afford') }}
                    </p>
                </div>
                <div class="flex items-center flex-wrap gap-4 justify-center">
                    @if (config('templatecookie.razorpay_active'))
                        <div
                            class="bg-gray-50 h-[140px] w-[140px] rounded-lg p-5 flex items-center justify-center border border-transparent hover:border-gray-100 transition-all duration-200 ease-linear shadow-gray-100">
                            <img src="{{ asset('frontend/images/razorpay.png') }}" alt="google pay logo" class="w-full">
                        </div>
                    @endif
                    @if (config('templatecookie.paystack_active'))
                        <div
                            class="bg-gray-50 h-[140px] w-[140px] rounded-lg p-5 flex items-center justify-center border border-transparent hover:border-gray-100 transition-all duration-200 ease-linear shadow-gray-100">
                            <img src="{{ asset('frontend/images/paystack.png') }}" alt="google pay logo" class="w-full">
                        </div>
                    @endif
                    @if (config('templatecookie.paypal_active'))
                        <div
                            class="bg-gray-50 h-[140px] w-[140px] rounded-lg p-5 flex items-center justify-center border border-transparent hover:border-gray-100 transition-all duration-200 ease-linear shadow-gray-100">
                            <img src="{{ asset('frontend/images/paypal-3.png') }}" alt="google pay logo" class="w-full">
                        </div>
                    @endif
                    @if (config('templatecookie.stripe_active'))
                        <div
                            class="bg-gray-50 h-[140px] w-[140px] rounded-lg p-5 flex items-center justify-center border border-transparent hover:border-gray-100 transition-all duration-200 ease-linear shadow-gray-100">
                            <img src="{{ asset('frontend/images/stripe-4.png') }}" alt="google pay logo" class="w-full">
                        </div>
                    @endif
                    @if (config('templatecookie.midtrans_active'))
                        <div
                            class="bg-gray-50 h-[140px] w-[140px] rounded-lg p-5 flex items-center justify-center border border-transparent hover:border-gray-100 transition-all duration-200 ease-linear shadow-gray-100">
                            <img src="{{ asset('frontend/images/midtrans.png') }}" alt="google pay logo" class="w-full">
                        </div>
                    @endif
                </div>
            </section>

            <section>
                <div class="container">
                    <!-- ====== FAQ Section Start -->
                    <section x-data="{
                        @foreach ($priceFaqs as $index => $priceFaq)
                        openFaq{{ $index }}: false, @endforeach
                    }">
                        <div
                            class="relative z-20 overflow-hidden bg-white dark:bg-dark pt-20 pb-12 lg:pt-[80px] lg:pb-[90px]">
                            <div class="container mx-auto">
                                <div class="flex flex-wrap -mx-4">
                                    <div class="w-full px-4">
                                        <div class="mx-auto mb-[60px] max-w-[520px] text-center lg:mb-20">
                                            <span class="block mb-2 text-lg font-semibold text-primary-500">
                                                {{ __('faq') }}
                                            </span>
                                            <h2 class="text-gray-900 mb-4 text-3xl font-bold sm:text-[40px]/[48px]">
                                                {{ __('any_questions_look_here') }}
                                            </h2>
                                            <p class="text-base text-body-color dark:text-dark-6">
                                                {{ __('any_questions_look_here') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-wrap -mx-4">
                                    @foreach ($priceFaqs as $index => $priceFaq)
                                        @if ($index % 2 == 0)
                                            <div class="w-full px-4 lg:w-1/2">
                                                <div
                                                    class="w-full p-4 mb-8 bg-white rounded-lg shadow-[0px_20px_95px_0px_rgba(201,203,204,0.30)] dark:shadow-[0px_20px_95px_0px_rgba(0,0,0,0.30)] dark:bg-dark-2 sm:p-8 lg:px-6 xl:px-8">
                                                    <button class="flex w-full text-left faq-btn"
                                                        @click="openFaq{{ $index }} = !openFaq{{ $index }}">
                                                        <div
                                                            class="bg-primary/5 dark:bg-white/5 text-primary-500 mr-5 flex h-10 w-full max-w-[40px] items-center justify-center rounded-lg">
                                                            <svg :class="openFaq3 && 'rotate-180'" width="22"
                                                                height="22" viewBox="0 0 22 22" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M11 15.675C10.7937 15.675 10.6219 15.6062 10.45 15.4687L2.54374 7.69998C2.23436 7.3906 2.23436 6.90935 2.54374 6.59998C2.85311 6.2906 3.33436 6.2906 3.64374 6.59998L11 13.7844L18.3562 6.53123C18.6656 6.22185 19.1469 6.22185 19.4562 6.53123C19.7656 6.8406 19.7656 7.32185 19.4562 7.63123L11.55 15.4C11.3781 15.5719 11.2062 15.675 11 15.675Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </div>
                                                        <div class="w-full">
                                                            <h4 class="mt-1 text-lg font-semibold text-gray-900">
                                                                {{ $priceFaq->question }}
                                                            </h4>
                                                        </div>
                                                    </button>
                                                    <div x-show="openFaq{{ $index }}"
                                                        class="faq-content pl-[62px]">
                                                        <p
                                                            class="py-3 text-base leading-relaxed text-body-color dark:text-dark-6">
                                                            {{ $priceFaq->answer }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="w-full px-4 lg:w-1/2">
                                                <div
                                                    class="w-full p-4 mb-8 bg-white rounded-lg shadow-[0px_20px_95px_0px_rgba(201,203,204,0.30)] dark:shadow-[0px_20px_95px_0px_rgba(0,0,0,0.30)] dark:bg-dark-2 sm:p-8 lg:px-6 xl:px-8">
                                                    <button class="flex w-full text-left faq-btn"
                                                        @click="openFaq{{ $index }} = !openFaq{{ $index }}">
                                                        <div
                                                            class="bg-primary/5 dark:bg-white/5 text-primary-500 mr-5 flex h-10 w-full max-w-[40px] items-center justify-center rounded-lg">
                                                            <svg :class="openFaq3 && 'rotate-180'" width="22"
                                                                height="22" viewBox="0 0 22 22" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M11 15.675C10.7937 15.675 10.6219 15.6062 10.45 15.4687L2.54374 7.69998C2.23436 7.3906 2.23436 6.90935 2.54374 6.59998C2.85311 6.2906 3.33436 6.2906 3.64374 6.59998L11 13.7844L18.3562 6.53123C18.6656 6.22185 19.1469 6.22185 19.4562 6.53123C19.7656 6.8406 19.7656 7.32185 19.4562 7.63123L11.55 15.4C11.3781 15.5719 11.2062 15.675 11 15.675Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                        </div>
                                                        <div class="w-full">
                                                            <h4 class="mt-1 text-lg font-semibold text-gray-900">
                                                                {{ $priceFaq->question }}
                                                            </h4>
                                                        </div>
                                                    </button>
                                                    <div x-show="openFaq{{ $index }}"
                                                        class="faq-content pl-[62px]">
                                                        <p
                                                            class="py-3 text-base leading-relaxed text-body-color dark:text-dark-6">
                                                            {{ $priceFaq->answer }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="absolute bottom-0 right-0 z-[-1]">
                                <svg width="1440" height="886" viewBox="0 0 1440 886" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.5"
                                        d="M193.307 -273.321L1480.87 1014.24L1121.85 1373.26C1121.85 1373.26 731.745 983.231 478.513 729.927C225.976 477.317 -165.714 85.6993 -165.714 85.6993L193.307 -273.321Z"
                                        fill="url(#paint0_linear)" />
                                    <defs>
                                        <linearGradient id="paint0_linear" x1="1308.65" y1="1142.58" x2="602.827"
                                            y2="-418.681" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#3056D3" stop-opacity="0.36" />
                                            <stop offset="1" stop-color="#F5F2FD" stop-opacity="0" />
                                            <stop offset="1" stop-color="#F5F2FD" stop-opacity="0.096144" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                    </section>
                    <!-- ====== FAQ Section End -->
                </div>
            </section>

            <div class="my-[4rem] rounded-2xl border-2 border-[rgba(0,0,0,0.12)] flex flex-col lg:flex-row items-center  bg-cover bg-no-repeat"
                style="background: url('{{ asset('frontend/images/trial-banner.png') }}')">
                <div class="">
                    @isset($cms->pricing_plan_image)
                        <img src="{{ asset($cms->pricing_plan_image) }}" alt="membership-trial.png" class="w-full">
                    @endisset
                </div>
                <div class="py-[2.78rem] px-[2rem] md:px-[4rem] flex-1">
                    <h6 class="caption-06 text-primary-500">{{ __('you_dont_need_to_pay_first') }}</h6>
                    <h2 class="heading-02 text-black mt-[0.75rem]">{{ __('start_your_free_trial') }}</h2>
                    <p class="body-md-400 text-gray-700 my-[1.5rem]">{{ __('start_your_free_trial_description') }}</p>

                    @if (auth('user')->check())
                        <a href="#price_plan_selection" class="btn-primary">
                            {{ __('start_your_free_trial') }}
                            <x-frontend.icons.arrow-right />
                        </a>
                    @endif

                    <span class="flex items-center gap-2 text-gray-900 body-md-500 mt-[0.75rem]">
                        <x-frontend.icons.credit-card />
                        {{ __('no_credit_card_required') }}
                    </span>
                </div>
            </div>

            <section class="pb-10">
                <div class="container">
                    <div class="flex md:flex-row flex-col gap-5 items-center ">
                        <div class="w-full rounded-lg flex flex-col gap-3 p-8  bg-primary-50 space-y-4">
                            <h4 class="heading-05">{{ __('contact_with_us') }}</h4>
                            <div class="flex flex-wrap h-auto gap-8 items-center min-h-[38px] ">
                                <a href="tel:319-555-0115"
                                    class="group inline-flex gap-4 text-base font-medium text-primary-500 hover:text-primary-700 items-center">
                                    <span
                                        class="flex-1 text-base inline-flex justify-center items-center h-[50px] w-[50px] bg-white rounded-md group-hover:bg-primary-500 group-hover:text-white transition duration-200 ease-linear">
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" data-slot="icon"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.25 9.75v-4.5m0 4.5h4.5m-4.5 0 6-6m-3 18c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z" />
                                            </svg>
                                        </i>
                                    </span>
                                    <div>
                                        <h5 class="heading-06 text-gray-900">{{ __('phone') }}</h5>
                                        <span class="break-words">{{ $cms->contact_number }}</span>
                                    </div>

                                </a>
                                <a href="mailto:adlisting@templatecookie.com"
                                    class="group inline-flex gap-4 text-base font-medium text-primary-500 hover:text-primary-700 items-center">
                                    <span
                                        class="flex-1 text-base inline-flex justify-center items-center h-[50px] w-[50px] bg-white rounded-md group-hover:bg-primary-500 group-hover:text-white transition duration-200 ease-linear">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>

                                    </span>

                                    <div>
                                        <h5 class="heading-06 text-gray-900">{{ __('email') }}</h5>
                                        <span class="break-words">{{ $cms->contact_email }}</span>
                                    </div>
                                    <span></span>
                                </a>
                            </div>
                        </div>
                        <div class="w-full rounded-lg flex flex-col gap-3 p-8  bg-primary-50 space-y-4 self-stretch">
                            <h4 class="heading-05">{{ __('are_you_interested_with_us') }}</h4>
                            <a href="{{ route('frontend.signup') }}"
                                class="bg-white py-4 gap-3 rounded-lg transition duration-200 ease-linear border border-primary-100 px-3 flex items-center justify-center hover:bg-primary-500 hover:text-white font-xl font-semibold text-gray-900 ">
                                {{ __('register_now') }}
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                    </svg>

                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection

@push('js')
    <script>
        changePlanType();

        function changePlanType(){
            if ($('#pricing-switch').is(':checked')) {
                $('.price_plan_recurring').removeClass('hidden');
                $('.price_plan_one_time').addClass('hidden');
            } else {
                $('.price_plan_recurring').addClass('hidden');
                $('.price_plan_one_time').removeClass('hidden');
            }
        }
    </script>
@endpush
