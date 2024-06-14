@props(['intent','plan', 'currentplan'])

<div class="container">
    <div class="grid md:grid-cols-2 gap-6 mt-6">
        <h2 class="heading-05 col-span-full">
            {{ __('subscribe_to_plan', ['plan' => $plan->label]) }}
        </h2>

        <div class="bg-white rounded-lg shadow-sm p-8">
            <div class="flex gap-6 items-start">
                <form action="{{ route('subscribe.plan') }}" method="post" id="subscribe-payment-form">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    <div class="my-5">
                        <label for="card-holder-name">{{ __('card_holder_name') }}</label>
                        <input required name="name" type="text" class="tc-input mt-2" id="card-holder-name">
                    </div>
                    <div class="my-5">
                        <label for="card-element">{{ __('card_details') }}</label>
                        <div id="card-element" class="mt-5"></div>
                    </div>
                    <button type="submit" id="subscribe-btn" class="mt-3 btn-primary"
                        data-secret="{{ $intent->client_secret }}">
                        {{ __('subscribe_now') }}
                    </button>
                    <button type="button" id="loading-button" class="mt-3 btn-primary hidden">
                        {{ __('processing') }}...
                    </button>
                </form>
            </div>
        </div>

        @if (auth()->user()->subscribed('default'))
            @can('cancel',
                auth()->user()->subscription('default'))
                <form class="my-5 py-5" action="{{ route('subscribe.plan.cancel') }}" method="post">
                    @csrf
                    <div>
                        <button class="btn-danger" type="submit">
                            {{ __('cancel_subscription') }}
                        </button>
                    </div>
                </form>
            @endcan
            @can('resume',
                auth()->user()->subscription('default'))
                <form class="my-5 py-5" action="{{ route('subscribe.plan.resume') }}" method="post">
                    @csrf
                    <div>
                        <button class="btn-primary" type="submit">
                            {{ __('resume_subscription') }}
                        </button>
                    </div>
                </form>
            @endcan
        @endif
    </div>
</div>


@push('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        @if ($currentplan && $plan && $currentplan->subscription_type != $plan->plan_payment_type)
            setTimeout(() => {
                swal({
                    title: "{{__('are_you_sure_to_purchase_this_plan')}}",
                    text: "{{ __('you_already_have_one_time_plan_if_you_subscribe_to_this_plan_your_one_time_plan_will_be_cancelled_and_you_will_be_charged_for_this_plan') }}",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonColor: '#3daf29',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{__('yes_i_am_sure')}}",
                    closeOnConfirm: false,
                });
        }, 1000);
        @endif

        const form = document.getElementById('subscribe-payment-form');
        const cardButton = document.getElementById('subscribe-btn');
        const cardHolderName = document.getElementById('card-holder-name');

        const stripe = Stripe("{{ config('cashier.key') }}");
        const elements = stripe.elements();

        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            $('#loading-button').removeClass('hidden');
            $('#subscribe-btn').addClass('hidden');

            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                cardButton.dataset.secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            cardButton.disabled = false;
            if (error) {
                $('#loading-button').addClass('hidden');
                $('#subscribe-btn').removeClass('hidden');
                console.log(error);
            } else {
                let token = document.createElement('input');

                token.setAttribute('type', 'hidden');
                token.setAttribute('name', 'token');
                token.setAttribute('value', setupIntent.payment_method);
                form.appendChild(token);
                form.submit();
            }
        });
    </script>
@endpush
