@extends('frontend.layouts.dashboard')

@section('title')
    {{ __('affiliate') }}
@endsection

@section('breadcrumb')
    <x-frontend.breadcrumb.breadcrumb :links="[['text' => 'Dashboard', 'url' => '/'], ['text' => 'Affiliate']]" />
@endsection
@section('dashboard-content')
    <div x-data="{ openModal: false }">
        <div class="space-y-[1.5rem]">
            <div x-data="{ howItWorks: false }">
                <button @click="howItWorks = !howItWorks" class="inline-flex items-center gap-1 body-lg-500 text-primary-500 dark:text-primary-300">
                    <span>{{ __('how_it_work') }}</span>
                    <x-svg.chevron-down />
                </button>
                <ul x-show="howItWorks" x-cloak x-collapse
                    class="mt-3 border border-gray-100 dark:border-gray-600 rounded-lg shadow-[0px_1px_2px_0px_rgba(28,33,38,0.06),0px_1px_3px_0px_rgba(28,33,38,0.10)] items-center flex justify-center relative flex-wrap flex-col md:flex-row lg:flex-nowrap after:absolute after:hidden lg:after:block after:w-[70%]  after:h-[0.0625rem] after:bg-primary-500 after:top-[20%] after:left-[50%] after:translate-x-[-50%] after:translate-y-[-20%]">
                    <li
                        class="w-full relative mb-6 sm:mb-0 p-[1.5rem] group flex flex-col items-center justify-center gap-[1.2rem] min-w-[19.5rem]">
                        <div
                            class="z-10 text-primary-500 dark:text-primary-200 group-hover:text-white group-hover:bg-primary-500 transition all duration-200 flex items-center justify-center w-[3rem] h-[3rem] bg-primary-50 dark:bg-gray-600 rounded-full ring-1 ring-primary-500  shrink-0">
                            <x-svg.heroicons.arrow-right-circle />
                        </div>
                        <div class="text-center space-y-[0.5rem]">
                            <h3 class="heading-07 text-gray-900 dark:text-white">{{ __('apply_to_become_adlisting_affiliator') }}</h3>

                            <p class="body-sm-400 text-gray-600 dark:text-gray-300">
                                {{ __('this_process_sometimes_takes_some_time_because_the_admin_needs_to_verify_your_account') }}
                            </p>
                        </div>
                    </li>
                    <li
                        class="w-full relative mb-6 sm:mb-0 p-[1.5rem] group flex flex-col items-center justify-center gap-[1.2rem] min-w-[19.5rem] self-start">
                        <div
                            class="z-10 text-primary-500 dark:text-primary-200 group-hover:text-white group-hover:bg-primary-500 transition all duration-200 flex items-center justify-center w-[3rem] h-[3rem] bg-primary-50 dark:bg-gray-600 rounded-full ring-1 ring-primary-500  shrink-0">
                            <x-svg.heroicons.share />
                        </div>
                        <div class="text-center space-y-[0.5rem]">
                            <h3 class="heading-07 text-gray-900 dark:text-white">{{ __('invite_peoples_with_referral_url') }}</h3>

                            <p class="body-sm-400 text-gray-600 dark:text-gray-300">
                                {{ __('invite_your_friends_to_register_on_adlisting_with_unique_url') }}</p>
                        </div>
                    </li>
                    <li
                        class="w-full relative mb-6 sm:mb-0 p-[1.5rem] group flex flex-col items-center justify-center gap-[1.2rem] min-w-[19.5rem] self-start">
                        <div
                            class="z-10 text-primary-500 dark:text-primary-200 group-hover:text-white group-hover:bg-primary-500 transition all duration-200 flex items-center justify-center w-[3rem] h-[3rem] bg-primary-50 dark:bg-gray-600 rounded-full ring-1 ring-primary-500  shrink-0">
                            <x-svg.heroicons.credit-card />
                        </div>
                        <div class="text-center space-y-[0.5rem]">
                            <h3 class="heading-07 text-gray-900 dark:text-white">{{ __('earn_money_and_withdraw_whenever_you_want') }}</h3>

                            <p class="body-sm-400 text-gray-600 dark:text-gray-300">
                                {{ __('you_will_receive_$1_usd_for_each_invitation_and_you_can_withdraw_whenever_you_want') }}
                            </p>
                        </div>
                    </li>

                </ul>
            </div>
            <div class="flex flex-col lg:flex-row items-center justify-evenly gap-[1.5rem]">
                <div class="text-center space-y-[0.5rem]">
                    <h2 class="heading-01 text-gray-900 dark:text-white">{{ number_format($affiliateInvitedUsers->count() ?? 0) }}</h2>
                    <span class="body-md-500 text-gray-700 dark:text-gray-300">{{ __('total_impression') }}</span>
                </div>
                <div class="text-center space-y-[0.5rem]">
                    <h2 class="heading-01 text-gray-900 dark:text-white">{{ changeCurrency($affiliatePointHistory->where('status', 1)->sum('pricing'))?: currentCurrencySymbol().'0'}} 
                    </h2>
                    <span class="body-md-500 text-gray-700 dark:text-gray-300">{{ __('total_earned') }}</span>
                </div>
                <div class="text-center space-y-[0.5rem]">
                    <h2 class="heading-01 text-gray-900 dark:text-white">{{ $purchasedPlan }}</h2>
                    <span class="body-md-500 text-gray-700 dark:text-gray-300">{{ __('package_purchased') }}</span>
                </div>
            </div>
            <div class="flex flex-col xl:flex-row items-start gap-[1.5rem]" x-data="{ generateLinks: {{ $wallet->affiliate_code != null ? 'true' : 'false' }} }">
                <div
                    class="shadow-[0px_1px_2px_0px_rgba(28,33,38,0.06),0px_1px_3px_0px_rgba(28,33,38,0.10)] p-[1.5rem] rounded-[0.75rem] border border-gray-100 dark:border-gray-600 shrink w-full">
                    <template x-if="!generateLinks">
                        <div>
                            <p class="body-md-500 mb-1.5 text-gray-900 dark:text-white">{{ __('generate_affiliate_link') }}</p>
                            <a href="#" target="_blank"
                                class="block text-gray-200 text-xl font-medium">{{ $baseUrl . '/sign-up/account?aff_code=' . $wallet->affiliate_code }}</a>
                            <button class="btn-primary mt-4" @click="generateLinks = true">
                                <span>{{ __('generate_links') }}</span>
                                <x-frontend.icons.arrow-right />
                            </button>
                        </div>
                    </template>
                    <template x-if="generateLinks">
                        <div>
                            <p class="body-md-500 mb-1.5 text-gray-900 dark:text-white">{{ __('share_youe_referral_link') }}</p>

                            <a x-ref="referralLink" href="#" target="_blank"
                                class="block text-primary-500 text-xl font-medium">{{ $baseUrl . '/sign-up/account?aff_code=' . $wallet->affiliate_code }}</a>

                            <button x-on:click="copyToClipboard($refs.referralLink)"
                                class="mt-4 bg-primary-50 text-primary-500 hover:bg-primary-500 hover:text-white transition-all duration-200 ease-in-out px-[1rem] py-[0.75rem] heading-07 inline-flex items-center gap-1 rounded-lg">
                                <x-svg.heroicons.document-duplicate />
                                {{ __('copy_link') }}
                            </button>
                        </div>
                    </template>
                </div>
                <div class="flex flex-col sm:flex-row lg:min-w-max w-full">
                    <div class="bg-primary-50 dark:bg-gray-500 p-6 md:min-w-[212px] flex-grow flex flex-col gap-4 sm:rounded-s-xl sm:rounded-tr-none rounded-t-xl border border-primary-100 dark:border-gray-800">
                        <div class="space-y-2">
                            <p class="body-md-500 text-gray-900 dark:text-white">{{ __('total_points') }}</p>
                            <h5 class="heading-05 text-gray-900 dark:text-white">{{ number_format($wallet->total_points) ?? 0 }}</h5>
                        </div>

                        <button @click="openModal= true"
                            class="text-primary-500 hover:text-primary-600 heading-07 py-2">{{ __('redeem_points') }}</button>
                    </div>
                    <div class="bg-primary-50 dark:bg-gray-500 p-6 md:min-w-[212px] flex-grow flex flex-col gap-4 sm:rounded-e-xl sm:rounded-bl-none rounded-b-xl border border-primary-100 dark:border-gray-800">
                        <div class="space-y-2">
                            <p class="body-md-500 text-gray-900 dark:text-white">{{ __('account_balance') }}</p>
                            <h5 class="heading-05 text-gray-900 dark:text-white">{{ changeCurrency(number_format($wallet->balance, 2)) ?? 0 }}</h5>
                        </div>

                        <a href="{{ route('frontend.priceplan') }}" class="btn-primary">{{ __('buy_package') }}</a>
                    </div>
                </div>
            </div>

            <div>
                @livewire('affiliate-point-history', ['affiliatePointHistory' => $affiliatePointHistory])
            </div>

            <div>
                @livewire('affiliate-invited-users', ['affiliateInvitedUsers' => $affiliateInvitedUsers])
            </div>
        </div>
        <div x-show="openModal" x-cloak
            class="bg-white dark:bg-gray-500 rounded-xl fixed z-50 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transition-all duration-300"
            :class="openModal ? 'visible' : 'invisible'">
            <div class="flex justify-between items-center pb-4 px-6 pt-6">
                <h2 class="heading-06">{{ __('redeem_your_points_into_money') }}</h2>
                <button @click="openModal=false">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.46967 5.46967C5.76256 5.17678 6.23744 5.17678 6.53033 5.46967L12 10.9393L17.4697 5.46967C17.7626 5.17678 18.2374 5.17678 18.5303 5.46967C18.8232 5.76256 18.8232 6.23744 18.5303 6.53033L13.0607 12L18.5303 17.4697C18.8232 17.7626 18.8232 18.2374 18.5303 18.5303C18.2374 18.8232 17.7626 18.8232 17.4697 18.5303L12 13.0607L6.53033 18.5303C6.23744 18.8232 5.76256 18.8232 5.46967 18.5303C5.17678 18.2374 5.17678 17.7626 5.46967 17.4697L10.9393 12L5.46967 6.53033C5.17678 6.23744 5.17678 5.76256 5.46967 5.46967Z"
                            fill="#6E747A" />
                    </svg>
                </button>
            </div>
            <table class="w-full text-left">

                <thead class="text-xs text-gray-700 uppercase bg-gray-50  w-full">
                    <tr>

                        <th scope="col" class="py-[0.5rem] px-[1.5rem]">
                            {{ __('cost_points') }}
                        </th>
                        <th scope="col" class="py-[0.5rem] px-[1.5rem]">
                            {{ __('credit') }} ($)
                        </th>
                        <th scope="col" class="py-[0.5rem] px-[1.5rem]">
                            {{ __('status') }}
                        </th>
                        <th scope="col" class="py-[0.5rem] px-[1.5rem]">
                            {{ __('action') }}
                        </th>
                    </tr>
                </thead>
                <div class="px-[1.5rem]">
                    <tbody>
                        @if ($redeemPoints->isNotEmpty())
                            @foreach ($redeemPoints as $key => $redeemPoint)
                                <tr class=" border-b border-b-gray-100 body-md-400 text-gray-900">
                                    <td scope="row" class="px-[1.5rem] py-[1rem]   whitespace-nowrap ">
                                        {{ number_format($redeemPoint->points) }}
                                    </td>
                                    <td class="px-[1.5rem] py-[1rem]">
                                        ${{ number_format($redeemPoint->redeem_balance, 2) }}
                                    </td>
                                    <td class="px-[1.5rem] py-[1rem]">
                                        @if ($wallet->total_points >= $redeemPoint->points)
                                            <span
                                                class="text-xs-500 text-success-500 bg-success-50 py-0.5 px-2 rounded">{{ __('ready_to_redeem') }}</span>
                                        @else
                                            <span
                                                class="text-xs-500 text-primary-500 bg-primary-50 py-0.5 px-2 rounded">{{ number_format((int) $redeemPoint->points - (int) $wallet->total_points) }}
                                                {{ __('points_needed') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-[1.5rem] py-[1rem]">
                                        @if ($wallet->total_points < $redeemPoint->points)
                                            <button class="bg-gray-500 text-white px-3 py-2 rounded-md cursor-not-allowed"
                                                disabled>
                                                {{ __('redeem') }}
                                            </button>
                                        @else
                                            <a href="#" class="btn-primary"
                                                onclick="document.getElementById('redeem-points-form-{{ $key }}').submit();">
                                                {{ __('redeem') }}
                                            </a>

                                            <form id="redeem-points-form-{{ $key }}"
                                                action="{{ route('frontend.wallet.redeemPoints', $redeemPoint->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <span> {{ __('no_data_found') }} </span>
                        @endif


                    </tbody>
                </div>

            </table>
        </div>
        <div @click="openModal=false" x-show="openModal" x-cloak
            class="fixed z-20 top-0 left-0 bg-black/50 w-full h-full transition-all duration-300"
            :class="openModal ? 'visible' : 'invisible'"></div>
    </div>
@endsection

@push('js')
    <script>
        function copyToClipboard(element) {
            const textarea = document.createElement('textarea');
            textarea.value = element.textContent;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);

            alert('Link copied to clipboard!');
        }
    </script>
@endpush
