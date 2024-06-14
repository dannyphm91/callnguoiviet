@extends('frontend.layouts.app')

@section('title', __('price_plan'))

@section('content')
    <x-frontend.breadcrumb.breadcrumb :links="[['url' => '#', 'text' => __('price_plan')]]" />
    <div class="relative">
        <div aria-hidden="true" class=" absolute -top-48 start-0 -z-[1] hidden xl:flex">
            <div class="bg-purple-200 opacity-30 blur-3xl w-[1036px] h-[600px] "></div>
            <div class="bg-slate-200 opacity-90 blur-3xl w-[577px] h-[300px] transform translate-y-32 ">
            </div>
        </div>

        <div class="max-w-[85rem] px-4 pt-10 sm:px-6 lg:px-8 lg:pt-14 mx-auto">
            <div class="max-w-2xl mx-auto text-center mb-10">
                <h2
                    class="text-3xl leading-tight font-bold md:text-4xl md:leading-tight lg:text-5xl lg:leading-tight bg-clip-text bg-gradient-to-r from-primary-500 to-fuchsia-700 text-transparent">
                    {{ __('simple_transparent_pricing') }}</h2>
                <p class="mt-2 lg:text-lg text-gray-800 ">
                    {{ __('whatever_your_status_our_offers_evolve_according_to_your_needs') }}</p>
            </div>

            <div class="mt-6 md:mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6 lg:gap-3 xl:gap-6 lg:items-center my-5 py-5">
                {{-- @foreach ($plans as $plan)
                    <x-frontend.single-plan :plan="$plan" />
                @endforeach --}}
                <form action="{{ route('stripe.subscribe') }}" method="post" id="payment-form">
                    @csrf
                    <div class="my-5">
                        <label for="">Card Holder Name</label>
                        <input name="name" type="text" class="tc-input mt-2" id="card-holder-name">
                    </div>
                    <div class="my-5">
                        <label for="">Card Details</label>
                        <div id="card-element" class="mt-5"></div>
                    </div>
                    <div>
                        <button id="card-button" class="btn-primary" data-secret="{{ $intent->client_secret }}">
                            Subscribe Now
                        </button>
                    </div>
                </form>
            </div>





            @if (auth()->user()->subscribed('default'))
                @can('cancel',auth()->user()->subscription('default'))
                    <form class="my-5 py-5" action="{{ route('stripe.subscribe.cancel') }}" method="post">
                        @csrf
                        <div>
                            <button class="btn-danger" type="submit">
                                Cancel Subscription
                            </button>
                        </div>
                    </form>
                @endcan
                @can('resume',auth()->user()->subscription('default'))
                    <form class="my-5 py-5" action="{{ route('stripe.subscribe.resume') }}" method="post">
                        @csrf
                        <div>
                            <button class="btn-primary" type="submit">
                                Resume Subscription
                            </button>
                        </div>
                    </form>
                @endcan
                {{-- @if (!auth()->user()->subscription('default')->cancelled())
                    <form class="my-5 py-5" action="{{ route('stripe.subscribe.cancel') }}" method="post">
                        @csrf
                        <div>
                            <button class="btn-danger" type="submit">
                                Cancel Subscription
                            </button>
                        </div>
                    </form>
                @else
                    <form class="my-5 py-5" action="{{ route('stripe.subscribe.resume') }}" method="post">
                        @csrf
                        <div>
                            <button class="btn-primary" type="submit">
                                Resume Subscription
                            </button>
                        </div>
                    </form>
                @endif --}}
            @endif
        </div>
    </div>
@endsection

@push('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ config('cashier.key') }}");
        const elements = stripe.elements();

        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        const cardButton = document.getElementById('card-button');
        const cardHolderName = document.getElementById('card-holder-name');

        form.addEventListener('submit', async(e) => {
            e.preventDefault();
            cardButton.disabled = true;

            const {setupIntent, error} = await stripe.confirmCardSetup(
                cardButton.dataset.secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            if (error) {
                cardButton.disabled = false;
                console.log(error);
            } else {
                console.log(setupIntent);
                let token = document.createElement('input');

                token.setAttribute('type', 'hidden');
                token.setAttribute('name', 'token');
                token.setAttribute('value', setupIntent.payment_method);
                form.appendChild(token);

                form.submit();
            }


            // const {
            //     paymentMethod,
            //     error
            // } = await stripe.createPaymentMethod(
            //     'card', cardElement, {
            //         billing_details: {
            //             name: 'Jenny Rosen'
            //         }
            //     }
            // );

            // if (error) {
            //     // Display "error.message" to the user...
            // } else {
            //     // The card has been verified successfully...
            // }
        });
    </script>
@endpush
