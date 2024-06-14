@extends('frontend.layouts.dashboard')
@section('title')
    {{ __('requested_ads_list_for_resubmission') }}
@endsection
@section('dashboard-content')
    <x-frontend.breadcrumb.breadcrumb :links="[
        ['url' => 'dashboard', 'text' => __('dashboard')],
        ['url' => '#', 'text' => __('requested_ads_list_for_resubmission')],
    ]" />
    <div class="container mt-[2rem] pb-5">

        @if ($ads->count())
            <div class="flex justify-between  items-center">
                <h3 class="heading-03 text-gray-900 dark:text-white">{{ __('resubmission_listing') }}</h3>
                <a href="{{ route('frontend.post') }}"
                    class="inline-flex justify-center items-center gap-2 py-3 px-5 rounded-md transition-all duration-300 bg-primary-500 hover:bg-primary-600 text-white heading-07">
                    <small
                        class="w-[1.5rem] h-[1.5rem] rounded-full bg-white  text-primary-500 flex items-center justify-center">
                        <x-frontend.icons.plus />
                    </small>
                    <span>{{ __('post_new_listing') }}</span>
                </a>
            </div>
            <div class="mt-6 gap-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:flex lg:flex-col">
                @foreach ($ads as $ad)
                    <x-frontend.my-listing.resubmission-listing-card :ad="$ad"/>
                @endforeach
            </div>
            @if ($ads->total() > $ads->count())
                <div class="card-footer ">
                    <div class="d-flex justify-content-center">
                        {{ $ads->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @endif
        @else
            <div class="py-32 text-center">
                <h3 class="heading-03 text-gray-900 dark:text-white">{{ __('you_have_no_ads_item') }}</h3>
            </div>
        @endif


    </div>
@endsection

@push('css')
    <!-- Add venobox -->
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}" type="text/css" />
    <style>
        .vbox-child {
                max-width: 750px !important;
            }

        @media screen and (max-width: 767px) {
            .mobile-hidden {
                display: none !important;
            }
        }
    </style>
@endpush


@push('js')
    <!-- Add venobox -->
    <script type="text/javascript" src="{{ asset('frontend/js/venobox.min.js') }}"></script>
    <script>
        new VenoBox({
            selector: '.venobox',
            numeration: true,
            infinigall: true,
            share: true,
            spinner: 'rotating-plane'
        });
    </script>
@endpush
