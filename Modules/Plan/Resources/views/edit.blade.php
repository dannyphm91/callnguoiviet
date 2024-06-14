@extends('admin.layouts.app')
@section('title')
    {{ __('edit_plan') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('edit_plan') }}</h3>
                        <a href="{{ route('module.plan.index') }}"
                            class="btn bg-primary float-right d-flex align-items-center justify-content-center">
                            <i class="fas fa-arrow-left"></i>&nbsp; {{ __('back') }}
                        </a>
                    </div>
                </div>

                <div class="row pb-4">

                    <div class="col-md-8 pt-3">
                        <form id="form" class="form-horizontal" action="{{ route('module.plan.update', $plan->id) }}"
                            method="POST">
                            @csrf
                            @method('put')

                            <!-- Plan Information Box -->
                            <div id="planInfoBox" class="section card mb-4">
                                <div class="card-header">
                                    <h5 class="fw-bold">{{ __('plan_information') }}</h5>
                                </div>
                                <div class="card-body row">

                                    <!-- Select Plan payment type Here -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <x-forms.label name="plan_payment_type" required="true" />
                                            <div class="d-flex ">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input onclick="changePaymentType()" type="radio" id="one_time_plan"
                                                        name="plan_payment_type" class="custom-control-input"
                                                        value="one_time" @checked(old('plan_payment_type', $plan->plan_payment_type) == 'one_time')>
                                                    <label class="custom-control-label" for="one_time_plan">
                                                        {{ __('one_time') }}
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input onclick="changePaymentType()" type="radio" id="recurring_plan"
                                                        name="plan_payment_type" class="custom-control-input"
                                                        value="recurring" @checked(old('plan_payment_type', $plan->plan_payment_type) == 'recurring')>
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

                                    <!-- Recurring Pricing Here -->
                                    <div class="col-md-4 recurring_plan">
                                        <div class="form-group">
                                            <x-forms.label name="plan_type" required="true" for="plan_type" />
                                            <select name="interval" class="custom-select mr-sm-2" id="plan_type">
                                                <option {{ $plan->interval == 'monthly' ? 'selected' : '' }}
                                                    value="monthly">
                                                    {{ __('monthly') }}
                                                </option>
                                                <option {{ $plan->interval == 'yearly' ? 'selected' : '' }} value="yearly">
                                                    {{ __('yearly') }}
                                                </option>
                                                <option {{ $plan->interval == 'custom_date' ? 'selected' : '' }}
                                                    value="custom_date">
                                                    {{ __('plan_duration') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 recurring_plan">
                                        <div class="form-group">
                                            <x-forms.label name="stripe_price_id" required="true" for="stripe_id" />
                                            <input type="text" id="stripe_id" name="stripe_id"
                                                value="{{ old('stripe_id', $plan->stripe_id) }}"
                                                class="form-control @error('stripe_id') is-invalid @enderror"
                                                placeholder="e.g: price_****">
                                            @error('stripe_id')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!--  This field is dependent to Recurring option. Whenever you choose "duration" from Plan type, it will be visible -->
                                    <div class="col-md-4 {{ $plan->interval == 'custom_date' ? '' : 'd-none' }}"
                                        id="interval_date">
                                        <div class="form-group">
                                            <x-forms.label name="interval_days" required="true"
                                                for="custom_interval_days" />
                                            <input type="number" min="1" id="custom_interval_days"
                                                name="custom_interval_days"
                                                value="{{ old('custom_interval_days', $plan->custom_interval_days) }}"
                                                class="form-control @error('custom_interval_days') is-invalid @enderror"
                                                placeholder="{{ __('interval_days') }}">
                                            @error('custom_interval_days')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Onetime Pricing Here -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="plan_name" required="true" for="label" />
                                            <input type="text" id="label" name="label" value="{{ $plan->label }}"
                                                class="form-control @error('label') is-invalid @enderror"
                                                placeholder="e.g: {{ __('basic') }} / {{ __('standard') }} / {{ __('premium') }}">
                                            @error('label')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="price" required="true" for="price">
                                                ({{ config('templatecookie.currency_symbol') }})
                                            </x-forms.label>
                                            <input type="number" id="price" name="price"
                                                value="{{ $plan->price }}"
                                                class="form-control @error('price') is-invalid @enderror"
                                                placeholder="{{ __('price') }}">
                                            @error('price')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <x-forms.label name="set_recommended_package" required="true" />
                                            <div class="d-flex ">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="recommended_plan_yes" name="recommended"
                                                        class="custom-control-input" value="1"
                                                        {{ $plan->recommended == true ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="recommended_plan_yes">
                                                        {{ __('yes') }}
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="recommended_plan_no" name="recommended"
                                                        class="custom-control-input" value="0"
                                                        {{ $plan->recommended == false ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="recommended_plan_no">
                                                        {{ __('no') }}
                                                    </label>
                                                </div>
                                            </div>
                                            @error('recommended')
                                                <span class="invalid-feedback d-block"
                                                    role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Listing Post Limit Box -->
                            <div id="listingLimitBox" class="section card mb-4">
                                <div class="card-header">
                                    <h5 class="fw-bold">{{ __('listing_limit') }}</h5>
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <x-forms.label name="listing_post_limit" required="true" for="ad_limit" />
                                            <input type="number" id="ad_limit" name="ad_limit"
                                                value="{{ $plan->ad_limit }}"
                                                class="form-control @error('ad_limit') is-invalid @enderror"
                                                placeholder="e.g: 5">
                                            @error('ad_limit')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Featured Box -->
                            <div id="featuredBox" class="section card mb-4">
                                <div class="card-header">
                                    <h5 class="fw-bold">{{ __('featured_listing') }}</h5>
                                </div>
                                <div class="card-body row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="featured_listing_limit" required="true"
                                                for="featured_limit" />
                                            <input type="number" id="featured_limit" name="featured_limit"
                                                value="{{ $plan->featured_limit }}"
                                                class="form-control @error('featured_limit') is-invalid @enderror"
                                                placeholder="e.g: 5">
                                            @error('featured_limit')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="featured_listing_duration_days" required="true"
                                                for="featured_duration" />
                                            <input type="number" id="featured_duration" name="featured_duration" min="-1"
                                                value="{{ $plan->featured_duration }}"
                                                class="form-control @error('featured_duration') is-invalid @enderror"
                                                placeholder="e.g: 2">
                                            @error('featured_duration')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror

                                            <p><small class="text-mute">{{ __('featured') }}
                                                    {{ __('days_wont_expire_with_a_setting_of_minus_one') }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Urgent Box -->
                            <div id="urgentBox" class="section card mb-4">
                                <div class="card-header">
                                    <h5 class="fw-bold">{{ __('urgent_listing') }}</h5>
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="urgent_listing_limit" required="true"
                                                for="urgent_limit" />
                                            <input type="number" id="urgent_limit" name="urgent_limit"
                                                value="{{ $plan->urgent_limit }}"
                                                class="form-control @error('urgent_limit') is-invalid @enderror"
                                                placeholder="e.g: 5">
                                            @error('urgent_limit')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="urgent_listing_duration_days" required="true"
                                                for="urgent_duration" />
                                            <input type="number" id="urgent_duration" name="urgent_duration" min="-1"
                                                value="{{ $plan->urgent_duration }}"
                                                class="form-control @error('urgent_duration') is-invalid @enderror"
                                                placeholder="e.g: 2">
                                            @error('urgent_duration')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror

                                            <p><small class="text-mute">{{ __('urgent') }}
                                                    {{ __('days_wont_expire_with_a_setting_of_minus_one') }}</small></p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Highlight Box -->
                            <div id="highlightBox" class="section card mb-4">
                                <div class="card-header">
                                    <h5 class="fw-bold">{{ __('highlight_listing') }}</h5>
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="highlight_listing_limit" required="true"
                                                for="highlight_limit" />
                                            <input type="number" id="highlight_limit" name="highlight_limit"
                                                value="{{ $plan->highlight_limit }}"
                                                class="form-control @error('highlight_limit') is-invalid @enderror"
                                                placeholder="e.g: 5">
                                            @error('highlight_limit')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="highlight_listing_duration_days" required="true"
                                                for="highlight_duration" />
                                            <input type="number" id="highlight_duration" name="highlight_duration" min="-1"
                                                value="{{ $plan->highlight_duration }}"
                                                class="form-control @error('highlight_duration') is-invalid @enderror"
                                                placeholder="e.g: 2">
                                            @error('highlight_duration')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror

                                            <p><small class="text-mute">{{ __('highlight') }}
                                                    {{ __('days_wont_expire_with_a_setting_of_minus_one') }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Top Box -->
                            <div id="topBox" class="section card mb-4">
                                <div class="card-header">
                                    <h5 class="fw-bold">{{ __('top_listing') }}</h5>
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="top_listing_limit" required="true" for="top_limit" />
                                            <input type="number" id="top_limit" name="top_limit"
                                                value="{{ $plan->top_limit }}"
                                                class="form-control @error('top_limit') is-invalid @enderror"
                                                placeholder="e.g: 5">
                                            @error('top_limit')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="top_listing_duration_days" required="true"
                                                for="top_duration" />
                                            <input type="number" id="top_duration" name="top_duration" min="-1"
                                                value="{{ $plan->top_duration }}"
                                                class="form-control @error('top_duration') is-invalid @enderror"
                                                placeholder="e.g: 2">
                                            @error('top_duration')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror

                                            <p><small class="text-mute">{{ __('top') }}
                                                    {{ __('days_wont_expire_with_a_setting_of_minus_one') }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bump up Box -->
                            <div id="bumpUpBox" class="section card mb-4">
                                <div class="card-header">
                                    <h5 class="fw-bold">{{ __('bump_up_listing') }}</h5>
                                </div>
                                <div class="card-body row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="bump_up_listing_limit" required="true"
                                                for="bump_up_limit" />
                                            <input type="number" id="bump_up_limit" name="bump_up_limit"
                                                value="{{ $plan->bump_up_limit }}"
                                                class="form-control @error('bump_up_limit') is-invalid @enderror"
                                                placeholder="e.g: 5">
                                            @error('bump_up_limit')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="bump_up_listing_duration_days" required="true"
                                                for="bump_up_duration" />
                                            <input type="number" id="bump_up_duration" name="bump_up_duration" min="-1"
                                                value="{{ $plan->bump_up_duration }}"
                                                class="form-control @error('bump_up_duration') is-invalid @enderror"
                                                placeholder="e.g: 2">
                                            @error('bump_up_duration')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror

                                            <p><small class="text-mute">{{ __('bump_up') }}
                                                    {{ __('days_wont_expire_with_a_setting_of_minus_one') }}</small></p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Membership Box -->
                            <div id="membershipBox" class="section card mb-4">
                                <div class="card-header">
                                    <h5 class="fw-bold">{{ __('membership') }}</h5>
                                </div>
                                <div class="card-body row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="membership_badge" for="badge" required="true" />
                                            <div class="d-flex ">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="badge_plan_yes" name="badge"
                                                        class="custom-control-input" value="1"
                                                        {{ $plan->badge == true ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="badge_plan_yes">
                                                        {{ __('yes') }}
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="badge_plan_no" name="badge"
                                                        class="custom-control-input" value="0"
                                                        {{ $plan->badge == false ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="badge_plan_no">
                                                        {{ __('no') }}
                                                    </label>
                                                </div>
                                            </div>
                                            @error('badge')
                                                <span class="invalid-feedback d-block"
                                                    role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-forms.label name="premium_member" for="premium_member" required="true" />
                                            <div class="d-flex">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="premium_member_yes" name="premium_member"
                                                        class="custom-control-input" value="1"
                                                        {{ $plan->premium_member == true ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="premium_member_yes">
                                                        {{ __('yes') }}
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="premium_member_no" name="premium_member"
                                                        class="custom-control-input" value="0"
                                                        {{ $plan->premium_member == false ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="premium_member_no">
                                                        {{ __('no') }}
                                                    </label>
                                                </div>
                                            </div>
                                            @error('premium_member')
                                                <span class="invalid-feedback d-block"
                                                    role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="row justify-content-center mt-3">
                                <button class="btn btn-success" type="submit"><i class="fas fa-plus"></i>&nbsp;
                                    {{ __('update') }}</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4 pt-3">
                        <div class="card tc-sticky-sidebar">
                            <div class="card-body">
                                <h5 class="mb-4">{{ __('create_plan') }}</h5>
                                <div class="tc-vertical-step">
                                    <ul class="list-unstyled">
                                        <li>
                                            <a href="#planInfoBox"
                                                class="step-menu active">{{ __('plan_information') }}</a>
                                        </li>
                                        <li>
                                            <a href="#listingLimitBox" class="step-menu">{{ __('listing_limit') }}</a>
                                        </li>
                                        <li>
                                            <a href="#featuredBox" class="step-menu">{{ __('featured_listing') }}</a>
                                        </li>
                                        <li>
                                            <a href="#urgentBox" class="step-menu">{{ __('urgent_listing') }}</a>
                                        </li>
                                        <li>
                                            <a href="#highlightBox" class="step-menu">{{ __('highlight_listing') }}</a>
                                        </li>
                                        <li>
                                            <a href="#topBox" class="step-menu">{{ __('top_listing') }}</a>
                                        </li>
                                        <li>
                                            <a href="#bumpUpBox" class="step-menu">{{ __('bump_up_listing') }}</a>
                                        </li>
                                        <li>
                                            <a href="#membershipBox" class="step-menu">{{ __('membership') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        h5 {
            font-weight: bold;
        }

        /* Sidebar menu CSS Start */
        .tc-vertical-step,
        .tc-vertical-step-link {
            position: relative;
        }

        .tc-vertical-step ul:before,
        .tc-vertical-step-link ul:before {
            content: "";
            position: absolute;
            left: 5px;
            top: 10px;
            width: 2px;
            height: 100%;
            background: #dfe3e8;
        }

        .tc-vertical-step ul li:not(:last-child),
        .tc-vertical-step-link ul li:not(:last-child) {
            padding-bottom: 1rem;
        }

        .tc-vertical-step ul li a,
        .tc-vertical-step-link ul li a {
            position: relative;
            display: block;
            color: #454f5b;
            padding-left: 26px;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        body.dark-mode .tc-vertical-step ul li a,
        body.dark-mode .tc-vertical-step-link ul li a {
            color: #dfe3e8;
        }

        .tc-vertical-step ul li a:before,
        .tc-vertical-step-link ul li a:before {
            content: "";
            position: absolute;
            left: 1px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            background: #dfe3e8;
            border-radius: 50%;
            z-index: 2;
        }

        .tc-vertical-step ul li a:after,
        .tc-vertical-step-link ul li a:after {
            content: "";
            position: absolute;
            left: -3px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 1px solid var(--main-color);
            z-index: 1;
            opacity: 0;
        }

        .step-menu.active:before,
        .step-menu.active:before {
            background-color: var(--main-color) !important;
        }

        .step-menu.active:after,
        .step-menu.active:after {
            opacity: 1;
        }

        .tc-sticky-sidebar {
            position: sticky;
            top: 1rem;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
            z-index: 8;
        }

        /* Sidebar menu CSS End */
    </style>
@endsection

@section('script')
    <script>
        changePaymentType('{{ $plan->plan_payment_type }}');

        function changePaymentType() {
            if ($('#one_time_plan').is(':checked')) {
                $('.recurring_plan').addClass('d-none');
            } else {
                $('.recurring_plan').removeClass('d-none');
            }
        }

        if ('{{ old('interval') }}' == 'custom_date') {
            $('#interval_date').removeClass('d-none');
        }

        if ('{{ $plan->interval }}' == 'custom_date') {
            $('#interval_date').removeClass('d-none');
        }

        $('#plan_type').on('change', function() {
            if ($(this).val() == 'custom_date') {
                $('#interval_date').removeClass('d-none');
            } else {
                $('#interval_date').addClass('d-none');
            }
        });
    </script>

    {{-- Sidebar Menu script start --}}
    <script>
        const stepMenus = document.querySelectorAll('.step-menu');
        const sections = document.querySelectorAll('.section');


        function isElementInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
            );
        }

        function updateActiveStepMenuItem() {
            let activeSection = null;

            for (let i = 0; i < sections.length; i++) {
                if (isElementInViewport(sections[i])) {
                    activeSection = sections[i];
                    break;
                }
            }

            stepMenus.forEach(menu => menu.classList.remove('active'));

            if (activeSection) {
                const targetId = activeSection.id;
                const activeMenuItem = document.querySelector(`.step-menu[href="#${targetId}"]`);
                if (activeMenuItem) {
                    activeMenuItem.classList.add('active');
                }
            }
        }

        function handleStepMenuItemClick(event) {
            event.preventDefault();

            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }

        stepMenus.forEach(menuItem => {
            menuItem.addEventListener('click', handleStepMenuItemClick);
        });

        window.addEventListener('scroll', updateActiveStepMenuItem);

        updateActiveStepMenuItem();
    </script>
    {{-- Sidebar Menu script end --}}
@endsection
