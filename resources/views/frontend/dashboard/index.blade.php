@extends('frontend.layouts.dashboard')

@section('title', __('dashboard'))

@section('breadcrumb')
    <x-frontend.breadcrumb.breadcrumb :links="[['text' => 'Dashboard'], ['text' => 'Overview']]" />
@endsection

@section('dashboard-content')
    <div class="grid xl:grid-cols-3 gap-6 sm:grid-cols-2 grid-cols-1 mb-8">
        <div class="p-5 shadow-sm flex w-full rounded-lg justify-between items-center gap-4 bg-primary-50 dark:bg-primary-800">
            <div>
                <h3 class="heading-02 dark:text-white/80 mb-2">{{ $posted_ads_count }}</h3>
                <p class="body-md-400 dark:text-gray-300">{{ __('posted_ads') }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-600 rounded-md">
                <x-svg.list-icon />
            </div>
        </div>
        <div class="p-5 shadow-sm flex w-full rounded-lg justify-between items-center gap-4 bg-success-50 dark:bg-success-800">
            <div>
                <h3 class="heading-02 dark:text-white/80 mb-2">{{ $favouriteadcount }}</h3>
                <p class="body-md-400 dark:text-gray-300">{{ __('favorite_ads') }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-600 rounded-md">
                <x-svg.favourite-icon />
            </div>
        </div>
        <div class="p-5 shadow-sm flex w-full rounded-lg justify-between items-center gap-4 bg-error-50 dark:bg-error-800">
            <div>
                <h3 class="heading-02 dark:text-white/80 mb-2">{{ $expire_ads_count }}</h3>
                <p class="body-md-400 dark:text-gray-300">{{ __('expire_ads') }}</p>
            </div>
            <div class="p-4 bg-white dark:bg-gray-600 rounded-md">
                <x-svg.cube-icon />
            </div>
        </div>
    </div>
    @if (isset($user_plan))
        <div>
            <h2 class="heading-05 mb-4 dark:text-white">{{ __('current_plan_expirations_and_benefits') }}</h2>
            <div class="grid xl:grid-cols-3 gap-6 sm:grid-cols-2 grid-cols-1">
                <div class="p-5 shadow-sm flex w-full rounded-lg justify-between items-center gap-4 bg-success-50 dark:bg-success-800">
                    <div>
                        <h3 class="heading-02 dark:text-white/80 mb-2">{{ $user_plan->ad_limit }}</h3>
                        <p class="body-md-400 dark:text-gray-300">{{ __('remaining_ads') }}</p>
                    </div>
                </div>
                <div class="p-5 shadow-sm flex w-full rounded-lg justify-between items-center gap-4 bg-error-50 dark:bg-error-800">
                    <div>
                        <h3 class="heading-02 dark:text-white/80 mb-2">{{ $user_plan->featured_limit }}</h3>
                        <p class="body-md-400 dark:text-gray-300">{{ __('featured_ads') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="flex items-start flex-col lg:flex-row gap-6 mt-8">
        <div class="bg-white dark:bg-gray-900 rounded-xl p-6 border border-gray-50 dark:border-gray-600 shadow w-full overflow-hidden">
            <h4 class="heading-06 text-gray-900 dark:text-white">{{ __('ads_view') }}</h4>
            <div class="mt-4">
                <div id="ads-bar-chart"></div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-xl p-6 border border-gray-50 dark:border-gray-600 shadow w-full">
            <h4 class="heading-06 text-gray-900 dark:text-white">{{ __('recent_activities') }}</h4>
            @if (count($activities) > 0)
                <ul class="mt-4 space-y-4">
                    @foreach ($activities as $activity)
                        <li class="flex items-center gap-4 success">
                            <span
                                class="bg-success-50 text-success-400 p-4 h-[30px] w-[30px] rounded-md flex items-center justify-center">
                                <span class="icon">
                                    @if ($activity->type === 'App\\Notifications\\AdDeleteNotification')
                                        <x-svg.warning-icon />
                                    @elseif ($activity->type === 'App\\Notifications\\AdWishlistNotification')
                                        <x-svg.list-icon width="24" height="24" />
                                    @else
                                        <x-svg.check-icon width="24" height="24" />
                                    @endif
                                </span>
                            </span>
                            <p class="body-md-400 dark:text-white/90">
                                {{ $activity->data['msg'] }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-not-found2 message="{{ __('no_recents_activities') }}" />
            @endif
        </div>
    </div>
@endsection
@push('js')
    <script>
        @if (session('verified'))
            toastr.success('Email Verified Successfully!', 'Success');
        @endif

        // ApexCharts options and config
        window.addEventListener("load", function() {
            const options = {
                colors: ["#1A56DB", "#FDBA8C"],
                series: [{
                    name: "Organic",
                    color: "#1768E0",
                    data: @json($bar_chart_datas)
                }],
                chart: {
                    type: "bar",
                    height: 350,
                    width: '100%',
                    fontFamily: "Inter, sans-serif",
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "70%",
                        borderRadiusApplication: "end",
                        borderRadius: 8,
                    },
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
                states: {
                    hover: {
                        filter: {
                            type: "darken",
                            value: 1,
                        },
                    },
                },
                stroke: {
                    show: true,
                    width: 0,
                    colors: ["transparent"],
                },
                grid: {
                    show: true,
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                        top: -14
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    show: false,
                },
                xaxis: {
                    floating: false,

                    labels: {
                        show: true,
                        rotate: -45,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                        }
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: true,
                    lables: {

                    }
                },
                fill: {
                    opacity: 1,
                },
            }

            if (document.getElementById("ads-bar-chart") && typeof ApexCharts !== 'undefined') {

                const chart = new ApexCharts(document.getElementById("ads-bar-chart"), options);
                chart.render();
            }
        });
    </script>
@endpush
