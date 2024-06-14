@extends('admin.layouts.app')

@section('title')
    {{ __('update_user_plan_benefit') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-md-6 mb-3 mx-auto">
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5>
                        <i class="icon fas fa-info"></i>
                        {{ __('do_you_want_to_update_the_plan_data_of_the_user_under_this_order') }} ?
                    </h5>
                </div>
                <div class="card card-widget widget-user shadow">
                    <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username">
                            {{ $plan->label }}
                        </h3>
                        <h5 class="widget-user-desc">
                            {{ config('templatecookie.currency_symbol') }} {{ $plan->price }}
                        </h5>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        {{ __('ad_limit') }}
                                    </h5>
                                    <span class="description-text text-capilatize">
                                        {{ $plan->ad_limit }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        {{ __('featured_limits') }}
                                    </h5>
                                    <span class="description-text text-capilatize">
                                        {{ $plan->featured_limit }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        {{ __('badge') }}
                                    </h5>
                                    <span class="description-text text-capilatize">
                                        {{ $plan->badge ? 'True' : 'False' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        {{ __('interval') }}
                                    </h5>
                                    <span class="description-text text-capilatize">
                                        {{ Str::ucfirst($plan->interval) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="line-height: 36px;">
                            {{ __('update_user_plan_benefit') }}
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
                            <form class="form-horizontal" action="{{ route('user.plan.update', $user->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <!-- user plan details  -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <x-forms.label name="user_plan" required="true" />
                                                <select name="user_plan"
                                                    class="form-control select2bs4 @error('user_plan') is-invalid @enderror">
                                                    @foreach ($plans as $item)
                                                        <option {{ $plan->id == $item->id ? 'selected' : '' }}
                                                            value="{{ $item->id }}">
                                                            {{ $item->label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('user_plan')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <x-forms.label name="ad_limit" required="true" />
                                                <input type="number" name="ad_limit"
                                                    class="form-control @error('ad_limit') is-invalid @enderror"
                                                    value="{{ $user->userPlan->ad_limit }}"
                                                    placeholder="{{ __('ad_limit') }}">
                                                @error('ad_limit')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <x-forms.label name="featured_limit" required="true" />
                                                <input type="number" name="featured_limit"
                                                    class="form-control @error('ad_limit') is-invalid @enderror"
                                                    value="{{ $user->userPlan->featured_limit }}"
                                                    placeholder="{{ __('featured_limit') }}">
                                                @error('featured_limit')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <x-forms.label name="badge" required="true" />
                                                <select name="badge"
                                                    class="form-control @error('badge') is-invalid @enderror">
                                                    <option value="1">
                                                        {{ __('true') }}
                                                    </option>
                                                    <option value="0">
                                                        {{ __('false') }}
                                                    </option>
                                                </select>
                                                @error('badge')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <x-forms.label name="expired_date" required="true" />
                                                <div class="form-group">
                                                    <div class="input-group date" id="datetimepicker1"
                                                        data-target-input="nearest">
                                                        <input name="expired_date" type="text"
                                                            value="{{ date('d-m-Y', strtotime($user->userPlan->expired_date ?? $date)) }}"
                                                            placeholder="{{ __('expired_date') }}"
                                                            class="form-control datetimepicker-input"
                                                            data-target="#datetimepicker1">
                                                        <div class="input-group-append" data-target="#datetimepicker1"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('expired_date')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- user plan details end -->
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-plus"></i>
                                            &nbsp;{{ __('update_user_plan') }}
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
    <link rel="stylesheet" href="{{ asset('backend') }}/css/bootstrap-datetimepicker.min.css">

    <style>
        .card-footer {
            padding-top: 0px !important;
        }

        @media screen and (max-width: 768px) {
            .border-right {
                border-right: 0px !important;
            }
        }

        .widget-user .widget-user-header {
            height: 93px !important;
        }

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

        .description-block>.description-text {
            text-transform: none !important;
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('backend') }}/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('backend') }}/js/moment.min.js"></script>
    <script src="{{ asset('backend') }}/js/bootstrap-datetimepicker.min.js"></script>=

    <script>
        //Date picker
        $(document).ready(function() {
            // $('#datetimepicker1').datetimepicker();\
            $("#datetimepicker1").datetimepicker({
                format: 'DD-MM-YYYY',
                allowInputToggle: true,
            });
        });



        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endsection
