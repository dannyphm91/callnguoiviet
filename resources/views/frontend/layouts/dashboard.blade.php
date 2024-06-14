@extends('frontend.layouts.app')
@section('content')
    @yield('breadcrumb')
    <section class="lg:py-16 py-6 dark:bg-gray-800">
        <div class="container">
            @if (session('error'))
                <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <x-svg.error-icon />
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">
                            {{ session('error') }}
                        </span>
                    </div>
                </div>
            @endif
            <div class="lg:hidden flex pb-6 justify-between items-center" x-data="{dashboardMenu : false}">
                <h2 class="heading-07 dark:text-white">Dashboard</h2>
                <button class="bg-primary-500 rounded py-0.5 px-1" @click="dashboardMenu = !dashboardMenu">
                    <x-svg.menu-icon />
                </button>
                <x-frontend.dashboard-menu />
            </div>
            <div class="flex flex-col lg:flex-row items-start gap-8">
                @include('frontend.layouts.partials.dashboard-sidebar')
                <div class="dashboard-content w-full">
                    @yield('dashboard-content')
                </div>
            </div>
        </div>
    </section>
@endsection
