@extends('admin.layouts.app')

@section('title')
    {{ __('order_edit') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="line-height: 36px;">
                            {{ __('order_edit') }}
                        </h3>
                        <a href="{{ route('order.index') }}"
                            class="btn bg-primary float-right d-flex align-items-center justify-content-center">
                            <i class="fas fa-arrow-left"></i>
                            <span class="ml-2">
                                {{ __('back') }}
                            </span>
                        </a>
                    </div>
                    <div class="row pt-3 pb-4">
                        <div class="col-12 px-5">
                            <form class="form-horizontal" action="{{ route('order.update', $transaction->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <x-forms.label name="select_user" required="true" />
                                                <select name="user"
                                                    class="form-control select2bs4 @error('user') is-invalid @enderror">
                                                    @foreach ($users as $user)
                                                        <option {{ $transaction->user_id == $user->id ? 'selected' : '' }}
                                                            value="{{ $user->id }}">
                                                            {{ Str::ucfirst($user->name) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('user')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <x-forms.label name="select_plan" required="true" />
                                                <select name="plan"
                                                    class="form-control select2bs4 @error('plan') is-invalid @enderror">
                                                    @foreach ($plans as $plan)
                                                        <option {{ $transaction->plan_id == $plan->id ? 'selected' : '' }}
                                                            value="{{ $plan->id }}">
                                                            {{ $plan->label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('plan')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <x-forms.label name="currency_symbol" required="true" />
                                                <select name="currency_symbol"
                                                    class="form-control select2bs4 @error('currency_symbol') is-invalid @enderror">
                                                    @foreach ($currencies as $currency)
                                                        <option
                                                            {{ $transaction->currency_symbol == $currency->symbol ? 'selected' : '' }}
                                                            value="{{ $currency->symbol }}">
                                                            {{ $currency->symbol }} ({{ $currency->name }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('currency_symbol')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <x-forms.label name="amount" required="true" />
                                                <input type="number" name="amount"
                                                    class="form-control @error('amount') is-invalid @enderror"
                                                    value="{{ $transaction->amount }}" placeholder="{{ __('amount') }}">
                                                @error('amount')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <x-forms.label name="usd_amount" required="true" />
                                                <input type="number" name="usd_amount"
                                                    class="form-control @error('usd_amount') is-invalid @enderror"
                                                    value="{{ $transaction->usd_amount }}"
                                                    placeholder="{{ __('usd_amount') }}">
                                                @error('usd_amount')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <x-forms.label name="payment_providers" required="true" />
                                                <select name="payment_provider"
                                                    class="form-control select2bs4 @error('payment_provider') is-invalid @enderror">
                                                    <option
                                                        {{ $transaction->payment_provider == 'paypal' ? 'selected' : '' }}
                                                        value="paypal">
                                                        {{ __('paypal') }}
                                                    </option>
                                                    <option
                                                        {{ $transaction->payment_provider == 'stripe' ? 'selected' : '' }}
                                                        value="stripe">
                                                        {{ __('stripe') }}
                                                    </option>
                                                    <option
                                                        {{ $transaction->payment_provider == 'razorpay' ? 'selected' : '' }}
                                                        value="razorpay">
                                                        {{ __('razorpay') }}
                                                    </option>
                                                    <option
                                                        {{ $transaction->payment_provider == 'paystack' ? 'selected' : '' }}
                                                        value="paystack">
                                                        {{ __('paystack') }}
                                                    </option>
                                                    <option
                                                        {{ $transaction->payment_provider == 'sslcommerz' ? 'selected' : '' }}
                                                        value="sslcommerz">
                                                        {{ __('sslcommerz') }}
                                                    </option>
                                                    <option
                                                        {{ $transaction->payment_provider == 'instamojo' ? 'selected' : '' }}
                                                        value="instamojo">
                                                        {{ __('instamojo') }}
                                                    </option>
                                                    <option
                                                        {{ $transaction->payment_provider == 'flutterwave' ? 'selected' : '' }}
                                                        value="flutterwave">
                                                        {{ __('flutterwave') }}
                                                    </option>
                                                    <option
                                                        {{ $transaction->payment_provider == 'mollie' ? 'selected' : '' }}
                                                        value="mollie">
                                                        {{ __('mollie') }}
                                                    </option>
                                                    <option
                                                        {{ $transaction->payment_provider == 'midtrans' ? 'selected' : '' }}
                                                        value="midtrans">
                                                        {{ __('midtrans') }}
                                                    </option>
                                                    <option
                                                        {{ $transaction->payment_provider == 'offline' ? 'selected' : '' }}
                                                        value="offline">
                                                        {{ __('offline') }}
                                                    </option>
                                                </select>
                                                @error('payment_provider')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <x-forms.label name="payment_status" required="true" />
                                                <select name="payment_status"
                                                    class="form-control select2bs4 @error('payment_status') is-invalid @enderror">
                                                    <option {{ $transaction->payment_status == 'paid' ? 'selected' : '' }}
                                                        value="paid">
                                                        {{ __('paid') }}
                                                    </option>
                                                    <option {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}
                                                        value="unpaid">
                                                        {{ __('unpaid') }}
                                                    </option>
                                                </select>
                                                @error('payment_status')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-plus"></i>
                                            &nbsp;{{ __('update_order') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <style>
        .select2-results__option[aria-selected=true] {
            display: none;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
            color: #fff;
            border: 1px solid #fff;
            background: #007bff;
            border-radius: 30px;
        }

        .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('backend') }}/plugins/select2/js/select2.full.min.js"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endsection
