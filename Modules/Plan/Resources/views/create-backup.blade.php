@extends('admin.layouts.app')
@section('title')
    {{ __('create_plan') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('module.plan.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('create_plan') }}</h3>
                        <a href="{{ route('module.plan.index') }}"
                            class="btn bg-primary float-right d-flex align-items-center justify-content-center">
                            <i class="fas fa-arrow-left"></i>&nbsp; {{ __('back') }}
                        </a>
                    </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 d-none" id="interval_date">
                                    <div class="form-group">
                                        <x-forms.label name="interval_days" required="true"
                                            for="custom_interval_days" />
                                        <input type="number" min="1" id="custom_interval_days"
                                            name="custom_interval_days" value="{{ old('custom_interval_days', 15) }}"
                                            class="form-control @error('custom_interval_days') is-invalid @enderror"
                                            placeholder="{{ __('interval_days') }}">
                                        @error('custom_interval_days')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <x-forms.label name="plan_payment_type" required="true"/>
                                        <div class="d-flex ">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input onclick="changePaymentType()" type="radio" id="one_time_plan" name="plan_payment_type" class="custom-control-input" value="one_time" @checked(old('plan_payment_type', 'one_time') == 'one_time')>
                                                <label class="custom-control-label" for="one_time_plan">
                                                    {{ __('one_time') }}
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input onclick="changePaymentType()" type="radio" id="recurring_plan" name="plan_payment_type" class="custom-control-input" value="recurring" @checked(old('plan_payment_type') == 'recurring')>
                                                <label class="custom-control-label" for="recurring_plan">
                                                    {{ __('recurring') }}
                                                </label>
                                            </div>
                                        </div>
                                        @error('plan_payment_type')
                                            <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 recurring_plan">
                                    <div class="form-group">
                                        <x-forms.label name="plan_type" required="true" for="ad_limit"
                                            for="plan_type" />
                                        <select name="interval" class="custom-select mr-sm-2" id="plan_type">
                                            <option {{ old('interval') == 'monthly' ? 'selected' : '' }}
                                                value="monthly">
                                                {{ __('monthly') }}
                                            </option>
                                            <option {{ old('interval') == 'yearly' ? 'selected' : '' }}
                                                value="yearly">
                                                {{ __('yearly') }}
                                            </option>
                                            <option {{ old('interval') == 'custom_date' ? 'selected' : '' }}
                                                value="custom_date">
                                                {{ __('plan_duration') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 recurring_plan">
                                    <div class="form-group">
                                        <x-forms.label name="stripe_price_id" required="true" for="stripe_id"
                                            for="plan_type" />
                                        <input type="text" id="stripe_id" name="stripe_id" value="{{ old('stripe_id') }}"
                                            class="form-control @error('stripe_id') is-invalid @enderror"
                                            placeholder="e.g: price_****">
                                        @error('stripe_id')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 d-none recurring_plan" id="interval_date">
                                    <div class="form-group">
                                        <x-forms.label name="interval_days" required="true"
                                            for="custom_interval_days" />
                                        <input type="number" min="1" id="custom_interval_days"
                                            name="custom_interval_days" value="{{ old('custom_interval_days', 15) }}"
                                            class="form-control @error('custom_interval_days') is-invalid @enderror"
                                            placeholder="{{ __('interval_days') }}">
                                        @error('custom_interval_days')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="plan_name" required="true" for="label" />
                                        <input type="text" id="label" name="label" value="{{ old('label') }}"
                                            class="form-control @error('label') is-invalid @enderror"
                                            placeholder="e.g: {{ __('basic') }}">
                                        @error('label')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <x-forms.label name="price" required="true" for="price">
                                            ({{ config('templatecookie.currency_symbol') }})
                                        </x-forms.label>
                                        <input type="number" id="price" name="price" value="{{ old('price') }}"
                                            class="form-control @error('price') is-invalid @enderror" placeholder="{{ __('price') }}">
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="listing_post_limit" required="true" for="ad_limit" />
                                        <input type="number" id="ad_limit" name="ad_limit"
                                            value="{{ old('ad_limit') }}"
                                            class="form-control @error('ad_limit') is-invalid @enderror" placeholder="{{ __('ad_limit') }}">
                                        @error('ad_limit')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="featured_listing_limit" required="true" for="featured_limit" />
                                        <input type="number" id="featured_limit" name="featured_limit"
                                            value="{{ old('featured_limit') }}"
                                            class="form-control @error('featured_limit') is-invalid @enderror" placeholder="{{ __('featured_limit') }}">
                                        @error('featured_limit')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="featured_listing_duration" required="true" for="featured_duration" />
                                        <input type="number" id="featured_duration" name="featured_duration"
                                            value="{{ old('featured_duration') }}"
                                            class="form-control @error('featured_duration') is-invalid @enderror" placeholder="{{ __('featured_limit') }}">
                                        @error('featured_duration')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="urgent_listing_limit" required="true" for="urgent_limit" />
                                        <input type="number" id="urgent_limit" name="urgent_limit"
                                            value="{{ old('urgent_limit') }}"
                                            class="form-control @error('urgent_limit') is-invalid @enderror" placeholder="{{ __('urgent_limit') }}">
                                        @error('urgent_limit')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="urgent_listing_duration" required="true" for="urgent_duration" />
                                        <input type="number" id="urgent_duration" name="urgent_duration"
                                            value="{{ old('urgent_duration') }}"
                                            class="form-control @error('urgent_duration') is-invalid @enderror" placeholder="{{ __('urgent_duration') }}">
                                        @error('urgent_duration')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="highlight_listing_limit" required="true" for="highlight_limit" />
                                        <input type="number" id="highlight_limit" name="highlight_limit"
                                            value="{{ old('highlight_limit') }}"
                                            class="form-control @error('highlight_limit') is-invalid @enderror" placeholder="{{ __('highlight_limit') }}">
                                        @error('highlight_limit')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="highlight_listing_duration" required="true" for="highlight_duration" />
                                        <input type="number" id="highlight_duration" name="highlight_duration"
                                            value="{{ old('highlight_duration') }}"
                                            class="form-control @error('highlight_duration') is-invalid @enderror" placeholder="{{ __('highlight_duration') }}">
                                        @error('highlight_duration')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="top_listing_limit" required="true" for="top_limit" />
                                        <input type="number" id="top_limit" name="top_limit"
                                            value="{{ old('top_limit') }}"
                                            class="form-control @error('top_limit') is-invalid @enderror" placeholder="{{ __('top_limit') }}">
                                        @error('top_limit')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="top_listing_duration" required="true" for="top_duration" />
                                        <input type="number" id="top_duration" name="top_duration"
                                            value="{{ old('top_duration') }}"
                                            class="form-control @error('top_duration') is-invalid @enderror" placeholder="{{ __('top_duration') }}">
                                        @error('top_duration')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="bump_up_listing_limit" required="true" for="bump_up_limit" />
                                        <input type="number" id="bump_up_limit" name="bump_up_limit"
                                            value="{{ old('bump_up_limit') }}"
                                            class="form-control @error('bump_up_limit') is-invalid @enderror" placeholder="{{ __('bump_up_limit') }}">
                                        @error('bump_up_limit')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="bump_up_listing_duration" required="true" for="bump_up_duration" />
                                        <input type="number" id="bump_up_duration" name="bump_up_duration"
                                            value="{{ old('bump_up_duration') }}"
                                            class="form-control @error('bump_up_duration') is-invalid @enderror" placeholder="{{ __('bump_up_duration') }}">
                                        @error('bump_up_duration')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{-- <x-forms.label name="premium_badge" for="badge" /> --}}
                                        <x-forms.label name="membership_badge" for="badge" />
                                        <select name="badge" id="badge"
                                            class="form-control @error('badge') is-invalid @enderror">
                                            <option value="1">{{ __('yes') }}</option>
                                            <option value="0">{{ __('no') }}</option>
                                        </select>
                                        @error('badge')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <x-forms.label name="premium_badge" required="true"/>
                                        <div class="d-flex ">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="badge_plan_yes" name="badge" class="custom-control-input" value="0">
                                                <label class="custom-control-label" for="badge_plan_yes">
                                                    {{ __('yes') }}
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="badge_plan_no" name="badge" class="custom-control-input" value="1" checked="">
                                                <label class="custom-control-label" for="badge_plan_no">
                                                    {{ __('no') }}
                                                </label>
                                            </div>
                                        </div>
                                        @error('premium_badge')
                                            <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="recommended" required="true"/>
                                        <div class="d-flex ">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="recommended_plan_yes" name="recommended" class="custom-control-input" value="1">
                                                <label class="custom-control-label" for="recommended_plan_yes">
                                                    {{ __('yes') }}
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="recommended_plan_no" name="recommended" class="custom-control-input" value="0" checked="">
                                                <label class="custom-control-label" for="recommended_plan_no">
                                                    {{ __('no') }}
                                                </label>
                                            </div>
                                        </div>
                                        @error('recommended')
                                            <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <x-forms.label name="premium_member" for="premium_member" />
                                        <select name="premium_member" id="premium_member"
                                            class="form-control @error('premium_member') is-invalid @enderror">
                                            <option value="1">{{ __('yes') }}</option>
                                            <option value="0">{{ __('no') }}</option>
                                        </select>
                                        @error('premium_member')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <button class="btn btn-success" type="submit"><i class="fas fa-plus"></i>&nbsp;
                                    {{ __('create') }}</button>
                            </div>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="line-height: 36px;">{{ __('featured_listing') }}</h3>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-forms.label name="featured_listing_limit" required="true" for="featured_limit" />
                                    <input type="number" id="featured_limit" name="featured_limit"
                                        value="{{ old('featured_limit') }}"
                                        class="form-control @error('featured_limit') is-invalid @enderror" placeholder="e.g: 5">
                                    @error('featured_limit')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-forms.label name="featured_listing_duration" required="true" for="featured_duration" />
                                    <input type="number" id="featured_duration" name="featured_duration"
                                        value="{{ old('featured_duration') }}"
                                        class="form-control @error('featured_duration') is-invalid @enderror" placeholder="e.g: 2">
                                    @error('featured_duration')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                    <small class="text-danger">Featured days will not be expired, if you put 0</small>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        changePaymentType();
        if ('{{ old('interval') }}' == 'custom_date') {
            $('#interval_date').removeClass('d-none');
        }

        function changePaymentType(){
            if($('#one_time_plan').is(':checked')){
                $('.recurring_plan').addClass('d-none');
            }else{
                $('.recurring_plan').removeClass('d-none');
            }
        }

        $('#plan_type').on('change', function() {
            if ($(this).val() == 'custom_date') {
                $('#interval_date').removeClass('d-none');
            } else {
                $('#interval_date').addClass('d-none');
            }
        });
    </script>
@endsection
