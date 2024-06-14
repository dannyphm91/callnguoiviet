@extends('admin.layouts.app')
@section('title')
    {{ __('plan_list') }}
@endsection
@section('content')
    <div class="card p-2">
        <div class="card-header">
            <h3 class="card-title" style="line-height: 36px;">{{ __('plan_list') }}</h3>
            @if (userCan('plan.create'))
                <a href="{{ route('module.plan.create') }}"
                    class="btn bg-primary float-right d-flex align-items-center justify-content-center">
                    <i class="fas fa-plus"></i>&nbsp; {{ __('create') }}
                </a>
            @endif
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-2 mt-4">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item border rounded mb-1">
                        <a class="nav-link active" data-toggle="tab" href="#all">
                            {{ __('all') }}
                        </a>
                    </li>
                    <li class="nav-item border rounded mb-1">
                        <a class="nav-link" data-toggle="tab" href="#one_time">
                            {{ __('one_time') }}
                        </a>
                    </li>
                    <li class="nav-item border rounded mb-1">
                        <a class="nav-link" data-toggle="tab" href="#recurring">
                            {{ __('recurring') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-sm-12 col-md-10 mt-4">
                <div class="tab-content no-padding">
                    <div class="tab-pane show active" id="all">
                        <div class="row">
                            @forelse ($plans as $plan)
                                @include('plan::single-plan')
                            @empty
                                <div class="col-md-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <x-not-found route="module.plan.create" message="{{ __('no_data_found') }}" />
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="tab-pane" id="one_time">
                        <div class="row">
                            @forelse ($one_time_plans as $plan)
                                @include('plan::single-plan')
                            @empty
                                <div class="col-md-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <x-not-found route="module.plan.create"
                                                message="{{ __('no_data_found') }}" />
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="tab-pane" id="recurring">
                        <div class="row">
                            @forelse ($recurring_plans as $plan)
                                @include('plan::single-plan')
                            @empty
                                <div class="col-md-12">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <x-not-found route="module.plan.create"
                                                message="{{ __('no_data_found') }}" />
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .icon {
            height: 25px;
            width: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #007bff;
            border-radius: 50%;
            color: white;
        }
    </style>
@endsection

@section('script')
    <script>
        function MonthlyPrice(plan) {

            if ($('#customSwitch' + plan.id).is(":checked")) {
                $('#price' + plan.id).html("$" + plan.monthly_price);
                $('#monthoryear' + plan.id).html("{{ __('/monthly') }}");
            } else {
                $('#price' + plan.id).html("$" + plan.yearly_price);
                $('#monthoryear' + plan.id).html("{{ __('/yearly') }}");
            }
        }
    </script>
@endsection
