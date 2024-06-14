@extends('admin.settings.setting-layout')
@section('title')
    {{ __('payment_gateway_setting') }}
@endsection

@section('website-settings')
    <div id="loading"></div>
    <div class="row" id="opacity">
        <div class="col-sm-6">
            {{-- paypal settings --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('paypal_settings') }}</h3>
                        <div class="form-group row">
                            <input {{ config('templatecookie.paypal_active') ? 'checked' : '' }} type="checkbox" name="paypal"
                                data-bootstrap-switch value="1" class="adminPaymentSettingsSwitchBtn">
                        </div>
                    </div>
                </div>
                @if (config('templatecookie.paypal_active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.payment.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="paypal" name="type">
                            <div class="form-group row">
                                <x-forms.label name="{{ __('live_mode') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input id="paylive"
                                        {{ config('templatecookie.paypal_live_mode') == 'live' ? 'checked' : '' }}
                                        type="checkbox" name="paypal_live_mode" button="button1"
                                        oldvalue="{{ config('templatecookie.paypal_live_mode') }}" data-bootstrap-switch
                                        value="1">
                                </div>
                            </div>
                            @if (config('templatecookie.paypal_live_mode') == 'sandbox')
                                <div class="form-group row">
                                    <x-forms.label name="{{ __('client_id') }}" class="col-sm-3" />
                                    <div class="col-sm-9">
                                        <input
                                            onkeyup="ButtonDisabled('button1', 'paypal_client_id' , '{{ config('templatecookie.paypal_sandbox_client_id') }}')"
                                            value="{{ config('templatecookie.paypal_sandbox_client_id') }}"
                                            name="paypal_client_id" type="text"
                                            class="form-control @error('paypal_client_id') is-invalid @enderror"
                                            autocomplete="off">
                                        @error('paypal_client_id')
                                            <span class="invalid-feedback"
                                                role="alert"><span>{{ $message }}</span></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <x-forms.label name="{{ __('client_secret') }}" class="col-sm-3" />
                                    <div class="col-sm-9">
                                        <input
                                            onkeyup="ButtonDisabled('button1', 'paypal_client_secret' , '{{ config('templatecookie.paypal_sandbox_client_secret') }}')"
                                            value="{{ config('templatecookie.paypal_sandbox_client_secret') }}"
                                            name="paypal_client_secret" type="text"
                                            class="form-control @error('paypal_client_secret') is-invalid @enderror"
                                            autocomplete="off">
                                        @error('paypal_client_secret')
                                            <span class="invalid-feedback"
                                                role="alert"><span>{{ $message }}</span></span>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <div class="form-group row">
                                    <x-forms.label name="{{ __('client_id') }}" class="col-sm-3" />
                                    <div class="col-sm-9">
                                        <input
                                            onkeyup="ButtonDisabled('button1', 'paypal_client_id' , '{{ config('templatecookie.paypal_live_client_id') }}')"
                                            value="{{ config('templatecookie.paypal_live_client_id') }}" name="paypal_client_id"
                                            type="text"
                                            class="form-control @error('paypal_client_id') is-invalid @enderror"
                                            autocomplete="off">
                                        @error('paypal_client_id')
                                            <span class="invalid-feedback"
                                                role="alert"><span>{{ $message }}</span></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <x-forms.label name="{{ __('client_secret') }}" class="col-sm-3" />
                                    <div class="col-sm-9">
                                        <input
                                            onkeyup="ButtonDisabled('button1', 'paypal_client_secret' , '{{ config('templatecookie.paypal_live_client_secret') }}')"
                                            value="{{ config('templatecookie.paypal_live_client_secret') }}"
                                            name="paypal_client_secret" type="text"
                                            class="form-control @error('paypal_client_secret') is-invalid @enderror"
                                            autocomplete="off">
                                        @error('paypal_client_secret')
                                            <span class="invalid-feedback"
                                                role="alert"><span>{{ $message }}</span></span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button id="button1" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif
            </div>

            {{-- SSL Commerz Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('ssl_commerz_settings') }}</h3>
                        <div class="form-group row">
                            <input {{ config('templatecookie.ssl_active') ? 'checked' : '' }} type="checkbox" name="ssl_commerz"
                                data-bootstrap-switch value="1" class="adminPaymentSettingsSwitchBtn">
                        </div>
                    </div>
                </div>
                @if (config('templatecookie.ssl_active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.payment.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="ssl_commerz" name="type">
                            <div class="form-group row">
                                <x-forms.label name="{{ __('live_mode') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input id="sslLive"
                                        {{ config('templatecookie.ssl_live_mode') == 'live' ? 'checked' : '' }} type="checkbox"
                                        name="ssl_live_mode" button="button2"
                                        oldvalue="{{ config('templatecookie.ssl_live_mode') }}" data-bootstrap-switch
                                        value="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="{{ __('store_id') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button2', 'store_id' , '{{ config('templatecookie.store_id') }}')"
                                        value="{{ config('templatecookie.store_id') }}" name="store_id" type="text"
                                        class="form-control @error('store_id') is-invalid @enderror" autocomplete="off">
                                    @error('store_id')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="{{ __('store_password') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button2', 'store_password' , '{{ config('templatecookie.store_password') }}')"
                                        value="{{ config('templatecookie.store_password') }}" name="store_password"
                                        type="text" class="form-control @error('store_password') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('store_password')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button id="button2" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif

            </div>

            {{-- Flutterwave Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('flutterwave_settings') }}</h3>
                        <div class="form-group row">
                            <input {{ config('templatecookie.flw_active') ? 'checked' : '' }} type="checkbox"
                                name="flutterwave" data-bootstrap-switch value="1"
                                class="adminPaymentSettingsSwitchBtn">
                        </div>
                    </div>
                </div>
                @if (config('templatecookie.flw_active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.payment.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="flutterwave" name="type">

                            <div class="form-group row">
                                <x-forms.label name="{{ __('public_key') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button6', 'flw_public_key' , '{{ config('templatecookie.flw_public_key') }}')"
                                        value="{{ config('templatecookie.flw_public_key') }}" name="flw_public_key"
                                        type="text" class="form-control @error('flw_public_key') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('flw_public_key')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="{{ __('secret_key') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button6', 'flw_secret_key' , '{{ config('templatecookie.flw_secret_key') }}')"
                                        value="{{ config('templatecookie.flw_secret_key') }}" name="flw_secret_key"
                                        type="text" class="form-control @error('flw_secret_key') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('flw_secret_key')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="{{ __('secret_hash') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button6', 'flw_secret_hash' , '{{ config('templatecookie.flw_secret_hash') }}')"
                                        value="{{ config('templatecookie.flw_secret_hash') }}" name="flw_secret_hash"
                                        type="text" class="form-control @error('flw_secret_hash') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('flw_secret_hash')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button id="button6" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif

            </div>

            {{-- Instamojo Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('instamojo_setting') }}</h3>
                        <div class="form-group row">
                            <input {{ config('templatecookie.im_active') ? 'checked' : '' }} type="checkbox" name="instamojo"
                                data-bootstrap-switch value="1" class="adminPaymentSettingsSwitchBtn">
                        </div>
                    </div>
                </div>

                @if (config('templatecookie.im_active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.payment.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="instamojo" name="type">

                            <div class="form-group row">
                                <x-forms.label name="instamojo_key" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button9', 'im_key' , '{{ config('templatecookie.im_key') }}')"
                                        value="{{ config('templatecookie.im_key') }}" name="im_key" type="text"
                                        class="form-control @error('im_key') is-invalid @enderror" autocomplete="off">
                                    @error('im_key')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="instamojo_secret" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button9', 'im_secret' , '{{ config('templatecookie.im_secret') }}')"
                                        value="{{ config('templatecookie.im_secret') }}" name="im_secret" type="text"
                                        class="form-control @error('im_secret') is-invalid @enderror" autocomplete="off">
                                    @error('im_secret')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button id="button9" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif
            </div>

            {{-- Mollie Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('mollie_setting') }}</h3>
                        <div class="form-group row">
                            <input {{ config('templatecookie.mollie_active') ? 'checked' : '' }} type="checkbox"
                                name="mollie" data-bootstrap-switch value="1"
                                class="adminPaymentSettingsSwitchBtn">
                        </div>
                    </div>
                </div>
                @if (config('templatecookie.mollie_active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.payment.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="mollie" name="type">

                            <div class="form-group row">
                                <x-forms.label name="{{ __('mollie_key') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button8', 'mollie_key' , '{{ config('templatecookie.mollie_key') }}')"
                                        value="{{ config('templatecookie.mollie_key') }}" name="mollie_key" type="text"
                                        class="form-control @error('mollie_key') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('mollie_key')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button id="button8" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-sm-6">
            {{-- Stripe Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('stripe_settings') }}</h3>
                        <div class="form-group row">
                            <input {{ config('templatecookie.stripe_active') ? 'checked' : '' }} type="checkbox"
                                name="stripe" data-bootstrap-switch value="1"
                                class="adminPaymentSettingsSwitchBtn">
                        </div>
                    </div>
                </div>
                @if (config('templatecookie.stripe_active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.payment.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="stripe" name="type">
                            <div class="form-group row">
                                <x-forms.label name="{{ __('secret_key') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button3', 'stripe_key' , '{{ config('templatecookie.stripe_key') }}')"
                                        value="{{ config('templatecookie.stripe_key') }}" name="stripe_key" type="text"
                                        class="form-control @error('stripe_key') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('stripe_key')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="{{ __('publisher_key') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button3', 'stripe_secret' , '{{ config('templatecookie.stripe_secret') }}')"
                                        value="{{ config('templatecookie.stripe_secret') }}" name="stripe_secret"
                                        type="text" class="form-control @error('stripe_secret') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('stripe_secret')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="{{ __('webhook_secret') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button3', 'stripe_webhook_secret' , '{{ config('templatecookie.stripe_webhook_secret') }}')"
                                        value="{{ config('templatecookie.stripe_webhook_secret') }}" name="stripe_webhook_secret"
                                        type="text" class="form-control @error('stripe_webhook_secret') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('stripe_webhook_secret')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button id="button3" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif
            </div>

            {{-- Razorpay Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('razorpay_settings') }}</h3>
                        <div class="form-group row">
                            <input {{ config('templatecookie.razorpay_active') ? 'checked' : '' }} type="checkbox"
                                name="razorpay" data-bootstrap-switch value="1"
                                class="adminPaymentSettingsSwitchBtn">
                        </div>
                    </div>
                </div>
                @if (config('templatecookie.razorpay_active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.payment.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="razorpay" name="type">
                            <div class="form-group row">
                                <x-forms.label name="{{ __('secret_key') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button4', 'razorpay_key' , '{{ config('templatecookie.razorpay_key') }}')"
                                        value="{{ config('templatecookie.razorpay_key') }}" name="razorpay_key"
                                        type="text" class="form-control @error('razorpay_key') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('razorpay_key')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="{{ __('publisher_key') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button4', 'razorpay_secret' , '{{ config('templatecookie.razorpay_secret') }}')"
                                        value="{{ config('templatecookie.razorpay_secret') }}" name="razorpay_secret"
                                        type="text"
                                        class="form-control @error('razorpay_secret') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('razorpay_secret')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button id="button4" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif
            </div>

            {{-- Paystack Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('paystack_settings') }}</h3>
                        <div class="form-group row">
                            <input {{ config('templatecookie.paystack_active') ? 'checked' : '' }} type="checkbox"
                                name="paystack" data-bootstrap-switch value="1"
                                class="adminPaymentSettingsSwitchBtn">
                        </div>
                    </div>
                </div>
                @if (config('templatecookie.paystack_active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.payment.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="paystack" name="type">
                            <div class="form-group row">
                                <x-forms.label name="{{ __('client_id') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button5', 'paystack_public_key' , '{{ config('templatecookie.paystack_public_key') }}')"
                                        value="{{ config('templatecookie.paystack_public_key') }}" name="paystack_public_key"
                                        type="text"
                                        class="form-control @error('paystack_public_key') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('paystack_public_key')
                                        <span class="invalid-feedback"
                                            role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="{{ __('secret_key') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button5', 'paystack_secret_key' , '{{ config('templatecookie.paystack_secret_key') }}')"
                                        value="{{ config('templatecookie.paystack_secret_key') }}" name="paystack_secret_key"
                                        type="text"
                                        class="form-control @error('paystack_secret_key') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('paystack_secret_key')
                                        <span class="invalid-feedback"
                                            role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="{{ __('merchant_email') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button5', 'merchant_email' , '{{ config('templatecookie.merchant_email') }}')"
                                        value="{{ config('templatecookie.merchant_email') }}" name="merchant_email"
                                        type="text" class="form-control @error('merchant_email') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('merchant_email')
                                        <span class="invalid-feedback"
                                            role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button id="button5" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif
            </div>

            {{-- Midtrans Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('midtrans_setting') }}</h3>
                        <div class="form-group row">
                            <input {{ config('templatecookie.midtrans_active') ? 'checked' : '' }} type="checkbox"
                                name="midtrans" data-bootstrap-switch value="1"
                                class="adminPaymentSettingsSwitchBtn">
                        </div>
                    </div>
                </div>
                @if (config('templatecookie.midtrans_active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.payment.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="midtrans" name="type">

                            <div class="form-group row">
                                <x-forms.label name="{{ __('merchant_id') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button7', 'midtrans_merchat_id' , '{{ config('templatecookie.midtrans_merchat_id') }}')"
                                        value="{{ config('templatecookie.midtrans_merchat_id') }}" name="midtrans_merchat_id"
                                        type="text"
                                        class="form-control @error('midtrans_merchat_id') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('midtrans_merchat_id')
                                        <span class="invalid-feedback"
                                            role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="{{ __('client_key') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button7', 'midtrans_client_key' , '{{ config('templatecookie.midtrans_client_key') }}')"
                                        value="{{ config('templatecookie.midtrans_client_key') }}" name="midtrans_client_key"
                                        type="text"
                                        class="form-control @error('midtrans_client_key') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('midtrans_client_key')
                                        <span class="invalid-feedback"
                                            role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="{{ __('server_key') }}" class="col-sm-3" />
                                <div class="col-sm-9">
                                    <input
                                        onkeyup="ButtonDisabled('button7', 'midtrans_server_key' , '{{ config('templatecookie.midtrans_server_key') }}')"
                                        value="{{ config('templatecookie.midtrans_server_key') }}" name="midtrans_server_key"
                                        type="text"
                                        class="form-control @error('midtrans_server_key') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('midtrans_server_key')
                                        <span class="invalid-feedback"
                                            role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button id="button7" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('backend') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script>
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('#button1').prop('disabled', true);
        $('#button2').prop('disabled', true);
        $('#button3').prop('disabled', true);
        $('#button4').prop('disabled', true);
        $('#button5').prop('disabled', true);
        $('#button6').prop('disabled', true);
        $('#button7').prop('disabled', true);
        $('#button8').prop('disabled', true);
        $('#button9').prop('disabled', true);

        function ButtonDisabled(id, input, data) {
            let inputVal = $('[name=' + input + ']').val();
            if (inputVal == data) {
                $('#' + id).prop('disabled', true);
            } else {
                $('#' + id).prop('disabled', false);
            }
        }

        $(".adminPaymentSettingsSwitchBtn").on('switchChange.bootstrapSwitch', function(event, state) {
            let input = $(this).attr('name');
            let status = state ? 1 : 0;
            $("input[name=" + input + "]").val(status);

            document.querySelector('#loading').classList.add('loading');
            document.querySelector('#loading').classList.add('loading-content');
            document.querySelector('#opacity').classList.add('opacity');

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('settings.payment.status.update') }}",
                data: {
                    'type': input,
                    'status': status
                },
                success: function(response) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                }
            });
        });

        $("#paylive").on('switchChange.bootstrapSwitch', function(event, state) {

            let oldData = event.target.attributes.oldvalue.value;
            let newData = event.currentTarget.checked ? 'live' : 'sandbox';
            let button = event.target.attributes.button.value;

            if (oldData == newData) {
                $('#' + button).prop('disabled', true);
            } else {
                $('#' + button).prop('disabled', false);
            }
        });

        // For SSL Commerz Live switch btn on/off
        $("#sslLive").on('switchChange.bootstrapSwitch', function(event, state) {

            let oldData = event.target.attributes.oldvalue.value;
            let newData = event.currentTarget.checked ? 'live' : 'sandbox';
            let button = event.target.attributes.button.value;

            if (oldData == newData) {
                $('#' + button).prop('disabled', true);
            } else {
                $('#' + button).prop('disabled', false);
            }
        });
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <style>
        .loading {
            z-index: 20;
            position: absolute;
            top: 0;
            left: -5px;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .opacity{
            opacity: 0.3;
        }

        .loading-content {
            position: fixed;
            top: 50%;
            left: 55%;
            transform: translate(-50%, -50%);
            border: 16px solid #111431;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }


        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection
