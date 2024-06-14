@props(['manualpayments', 'plan', 'midtoken', 'walletbalance'])

<div class="container">
    @if ($walletbalance && $walletbalance > $plan->price)
        <div class="grid md:grid-cols-2 gap-6 mt-6">
            <h2 class="heading-05 col-span-full dark:text-gray-50">{{ __('wallet_payment') }}</h2>

            <div class="bg-white rounded-lg shadow-sm p-8">
                <div class="flex gap-6 items-start">
                    <div class="">
                        <form action="{{ route('wallet.plan.payment') }}" method="POST">
                            @csrf
                            <h2 class="heading-06">{{ __('balance') }}: ${{ $walletbalance }}</h2>
                            <button class="btn btn-primary mt-3">
                                {{ __('pay_now') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="grid md:grid-cols-2 gap-6 mt-6">
        <h2 class="heading-05 col-span-full dark:text-gray-50">{{ __('online_payment') }}</h2>
        {{-- Paypal payment --}}
        @if (config('paypal.mode') == 'sandbox')
            @if (config('paypal.active') && config('paypal.sandbox.client_id') && config('paypal.sandbox.client_secret'))
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <div class="flex gap-6 items-start">
                        <div class="bg-primary-50 w-14 h-14 rounded-full inline-flex justify-center items-center">
                            <x-svg.paypal-icon />
                        </div>
                        <div class="">
                            <h2 class="heading-06">{{ __('paypal_payment') }}</h2>
                            <button id="paypal_btn" class="mt-3 btn-primary">
                                {{ __('pay_now') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @else
            @if (config('paypal.active') && config('paypal.live.client_id') && config('paypal.live.client_secret'))
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <div class="flex gap-6 items-start">
                        <div class="bg-primary-50 w-14 h-14 rounded-full inline-flex justify-center items-center">
                            <x-svg.paypal-icon />
                        </div>
                        <div class="">
                            <h2 class="heading-06">{{ __('paypal_payment') }}</h2>
                            <button id="paypal_btn" class="mt-3 btn-primary">
                                {{ __('pay_now') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        {{-- Stripe payment --}}
        @if (config('templatecookie.stripe_active') &&
                config('templatecookie.stripe_key') &&
                config('templatecookie.stripe_secret'))
            <div class="bg-white rounded-lg shadow-sm p-8">
                <div class="flex gap-6 items-start">
                    <div class="bg-primary-50 w-14 h-14 rounded-full inline-flex justify-center items-center">
                        <x-svg.stripe-icon />
                    </div>
                    <div class="">
                        <h2 class="heading-06">{{ __('stripe_payment') }}</h2>
                        <button id="stripe_btn" class="mt-3 btn-primary">
                            {{ __('pay_now') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Razorpay payment --}}
        @if (config('templatecookie.razorpay_active') &&
                config('templatecookie.razorpay_key') &&
                config('templatecookie.razorpay_secret'))
            <div class="bg-white rounded-lg shadow-sm p-8">
                <div class="flex gap-6 items-start">
                    <div class="bg-primary-50 w-14 h-14 rounded-full inline-flex justify-center items-center">
                        <img src="{{ asset('frontend/images/payment/razorpay.svg') }}" alt="">
                    </div>
                    <div class="">
                        <h2 class="heading-06">{{ __('razor_payment') }}</h2>
                        <button id="razorpay_btn" class="mt-3 btn-primary">
                            {{ __('pay_now') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- SSl Commerz payment --}}
        @if (config('templatecookie.ssl_active') && config('templatecookie.store_id') && config('templatecookie.store_password'))
            <div class="bg-white rounded-lg shadow-sm p-8">
                <div class="flex gap-6 items-start">
                    <div class="bg-primary-50 w-14 h-14 rounded-full inline-flex justify-center items-center">
                        <img src="{{ asset('frontend/images/payment/ssl.jpeg') }}" alt="">
                    </div>
                    <div class="">
                        <h2 class="heading-06">{{ __('sslcommerz_payment') }}</h2>
                        <button type="button" id="ssl_btn" class="mt-3 btn-primary">
                            {{ __('pay_now') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Paystack payment --}}
        @if (config('templatecookie.paystack_active') &&
                config('templatecookie.paystack_public_key') &&
                config('templatecookie.paystack_secret_key'))
            <div class="bg-white rounded-lg shadow-sm p-8">
                <div class="flex gap-6 items-start">
                    <div class="bg-primary-50 w-14 h-14 rounded-full inline-flex justify-center items-center">
                        <img src="{{ asset('frontend/images/payment/paystack.png') }}" alt="">
                    </div>
                    <div class="">
                        <h2 class="heading-06">{{ __('paystack_payment') }}</h2>
                        @if (config('templatecookie.currency') == 'USD')
                            <button id="paystack_btn" class="mt-3 btn-primary">
                                {{ __('pay_now') }}
                            </button>
                        @else
                            <p class="text-red-500">{{ __('paystack_does_not_support') }}
                                {{ config('templatecookie.currency') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- Flutterwave payment --}}
        @if (config('templatecookie.flw_active') &&
                config('templatecookie.flw_public_key') &&
                config('templatecookie.flw_secret_key') &&
                config('templatecookie.flw_secret_hash'))
            <div class="bg-white rounded-lg shadow-sm p-8">
                <div class="flex gap-6 items-start">
                    <div class="bg-primary-50 w-14 h-14 rounded-full inline-flex justify-center items-center">
                        <img height="80px" width="80px"
                            src="{{ asset('frontend/images/payment/Flutterwave-logo.png') }}" alt="">
                    </div>
                    <div class="">
                        <h2 class="heading-06">{{ __('flutterwave_payment') }}</h2>
                        <button id="flutterwave_btn" class="mt-3 btn-primary">
                            {{ __('pay_now') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Instamojo payment --}}
        @if (config('templatecookie.im_active') &&
                config('templatecookie.im_key') &&
                config('templatecookie.im_secret') &&
                config('templatecookie.im_url'))
            <div class="bg-white rounded-lg shadow-sm p-8">
                <div class="flex gap-6 items-start">
                    <div class="bg-primary-50 w-14 h-14 rounded-full inline-flex justify-center items-center">
                        <img height="20px" width="20px" src="{{ asset('frontend/images/payment/insta.png') }}"
                            alt="">
                    </div>
                    <div class="">
                        <h2 class="heading-06">{{ __('instamojo_payment') }}</h2>
                        <button id="instamojo_btn" class="mt-3 btn-primary">
                            {{ __('pay_now') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Midtrans payment --}}
        @if (config('templatecookie.midtrans_active') &&
                config('templatecookie.midtrans_merchat_id') &&
                config('templatecookie.midtrans_client_key') &&
                config('templatecookie.midtrans_server_key'))
            <div class="bg-white rounded-lg shadow-sm p-8">
                <div class="flex gap-6 items-start">
                    <div class="bg-primary-50 w-14 h-14 rounded-full inline-flex justify-center items-center">
                        <img height="20px" width="20px" src="{{ asset('frontend/images/payment/midtrans.jpeg') }}"
                            alt="">
                    </div>
                    <div class="">
                        <h2 class="heading-06">{{ __('midtrans_payment') }}</h2>
                        <button id="midtrans_btn" class="mt-3 btn-primary">
                            {{ __('pay_now') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Mollie payment --}}
        @if (config('templatecookie.mollie_key') && config('templatecookie.mollie_active'))
            <div class="bg-white rounded-lg shadow-sm p-8">
                <div class="flex gap-6 items-start">
                    <div class="bg-primary-50 w-14 h-14 rounded-full inline-flex justify-center items-center">
                        <img height="20px" width="20px" src="{{ asset('frontend/images/payment/mollie.png') }}"
                            alt="">
                    </div>
                    <div class="">
                        <h2 class="heading-06">{{ __('mollie_payment') }}</h2>
                        <button id="mollie_btn" class="mt-3 btn-primary">
                            {{ __('pay_now') }}
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if ($manualpayments && count($manualpayments))
        <div class="grid md:grid-cols-2 gap-6 mt-6">
            <h2 class="heading-05 col-span-full dark:text-gray-50">{{ __('offline_payment') }}</h2>

            @foreach ($manualpayments as $payment)
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <form action="{{ route('manual.payment') }}" method="post">
                        @csrf
                        <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                        <div class="flex gap-6 items-start">
                            <div class="bg-primary-50 w-14 h-14 rounded-full inline-flex justify-center items-center">
                                <x-svg.stripe-icon />
                            </div>
                            <div class="">
                                <h2 class="heading-06">{{ $payment->name }}</h2>
                                <p class="body-small-400 mt-1">{!! $payment->description !!}</p>
                                <button id="manual_payment_btn" class="mt-3 btn-primary">
                                    {{ __('pay_now') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Paypal Form --}}
    <form action="{{ route('paypal.post') }}" method="POST" class="hidden" id="paypal-form">
        @csrf
    </form>

    {{-- Stripe Form --}}
    <form action="{{ route('stripe.post') }}" method="POST" class="hidden">
        @csrf
        <script id="stripe_script" src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ config('templatecookie.stripe_key') }}" data-amount="{{ session('stripe_amount') }}"
            data-name="{{ config('app.name') }}" data-description="Money pay with stripe"
            data-locale="{{ app()->getLocale() == 'default' ? 'en' : app()->getLocale() }}" data-currency="USD"></script>
    </form>

    {{-- Razorpay Form --}}
    <form action="{{ route('razorpay.post') }}" method="POST" class="hidden">
        @csrf
        <script id="razor_script" src="https://checkout.razorpay.com/v1/checkout.js"
            data-key="{{ config('templatecookie.razorpay_key') }}" data-amount="{{ session('razor_amount') }}"
            data-buttontext="Pay with Razorpay" data-name="{{ config('app.name') }}" data-description="Money pay with razorpay"
            data-prefill.name="{{ auth('user')->user()->name }}" data-prefill.email="{{ auth('user')->user()->email }}"
            data-theme.color="#2980b9" data-currency="INR"></script>
    </form>

    {{-- paystack_btn Form --}}
    <form action="{{ route('paystack.post') }}" method="POST" class="hidden" id="paystack-form">
        @csrf
    </form>

    {{-- SSL Form --}}
    <form method="POST" class="needs-validation hidden" novalidate>
        <input type="hidden" value="{{ session('ssl_amount') }}" name="amount" id="total_amount" />
        <input id="ssl_plan_id" type="hidden" name="plan_id" value="{{ $plan->id }}">
        <button class="btn btn-primary" id="sslczPayBtn" token="if you have any token validation"
            postdata="your javascript arrays or objects which requires in backend"
            order="If you already have the transaction generated for current order"
            endpoint="{{ route('ssl.pay') }}">
            {{ __('pay_now') }}
        </button>
    </form>

    {{-- flutterwave Form --}}
    <form action="{{ route('flutterwave.pay') }}" method="POST" class="hidden" id="flutter-form">
        @csrf
    </form>

    {{-- instamojo Form --}}
    <form action="{{ route('instamojo.pay') }}" method="POST" class="hidden" id="instamojo-form">
        @csrf
    </form>

    {{-- mollie Form --}}
    <form action="{{ route('mollie.payment') }}" method="POST" class="hidden" id="mollie-form">
        @csrf
    </form>


</div>

@push('js')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('templatecookie.midtrans_key') }}"></script>
    <script>
      

        document.addEventListener('DOMContentLoaded', function () {
            $('#paypal_btn').on('click', function (e) {
                e.preventDefault();
                $('#paypal-form').submit();
            });

            $('#stripe_btn').on('click', function(e) {
                console.log('data');
                e.preventDefault();
                $('.stripe-button-el').click();
            });

            $('#razorpay_btn').on('click', function(e) {
                e.preventDefault();
                $('.razorpay-payment-button').click();
            });

            $('#paystack_btn').on('click', function(e) {
                e.preventDefault();
                $('#paystack-form').submit();
            });
            $('#ssl_btn').on('click', function(e) {
                e.preventDefault();
                $('#sslczPayBtn').click();
            });
            $('#flutterwave_btn').on('click', function(e) {
                e.preventDefault();
                $('#flutter-form').submit();
            });
            $('#instamojo_btn').on('click', function(e) {
                e.preventDefault();
                $('#instamojo-form').submit();
            });
            $('#mollie_btn').on('click', function(e) {
                e.preventDefault();
                $('#mollie-form').submit();
            });
        });
        // ssl commerz
        var obj = {};
        obj.amount = $('#total_amount').val();
        obj.plan_id = $('#ssl_plan_id').val();

        $('#sslczPayBtn').prop('postdata', obj);

        (function(window, document) {
            var loader = function() {
                var script = document.createElement("script"),
                    tag = document.getElementsByTagName("script")[0];
                // script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR LIVE
                script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(
                    7); // USE THIS FOR SANDBOX
                tag.parentNode.insertBefore(script, tag);
            };

            window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload",
                loader);
        })(window, document);


        // Midtrans
        if (
            '{{ config('templatecookie.midtrans_active ') && config('templatecookie.midtrans_id ') && config('templatecookie.midtrans_key ') && config('templatecookie.midtrans_secret ') }}') {
            const payButton = document.querySelector('#midtrans_btn');
            payButton.addEventListener('click', function(e) {
                e.preventDefault();

                snap.pay('{{ $midtoken }}', {
                    // Optional
                    onSuccess: function(result) {
                        // console.log(result);
                        successMidtransPayment();
                    },
                    // Optional
                    onPending: function(result) {
                        alert('Transaction is in pending state');
                    },
                    // Optional
                    onError: function(result) {
                        alert('Transaction is failed. Try again.');
                    }
                });
            });

            function successMidtransPayment() {
                $.ajax({
                    type: "post",
                    url: "{{ route('midtrans.success') }}",
                    data: {
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.href = response.redirect_url;
                    }
                });
            }
        }
    </script>
@endpush
