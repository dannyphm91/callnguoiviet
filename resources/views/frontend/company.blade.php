@extends('frontend.layouts.app')
@section('content')
    <x-frontend.breadcrumb.breadcrumb />
    <div class="container pb-8">
        {{-- company hero section start --}}
        <div class="bg-left h-[16.5rem] bg-red w-full"
            style="background: url('{{ asset('/frontend/images/company-banner.png') }}'), lightgray 0px -141.492px / 100% 185.076% no-repeat;">
        </div>
        {{-- company hero section end --}}
        <div class="flex w-full flex-wrap md:flex-nowrap">
            <x-frontend.company.side-panel />
            <x-frontend.company.tab-section />
        </div>
    </div>
@endsection
