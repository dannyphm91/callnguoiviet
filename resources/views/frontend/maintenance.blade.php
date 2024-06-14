@extends('frontend.layouts.blank')
@section('content')
    <div class="bg-primary-500 py-3 text-center">
        <a href="#">
            <img src="{{ $setting->white_logo_url }}" alt="">
        </a>
    </div>
    <div class="flex justify-center items-center min-h-screen">
        <div class="flex flex-wrap-reverse gap-6 justify-center items-center px-4 py-8 overflow-y-auto">
            <div class="max-w-xl">
                <h4
                    class="font-display text-start font-semibold text-xl sm:text-3xl xl:text-5xl leading-[56px] text-gray-900 mb-5">
                    {{ __('Website is under construction') }}
                </h4>
                <p class="body-base-400 mb-6">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quas dolore unde
                    cumque hic sequi natus omnis quam reiciendis ad fuga!</p>
                <a href="#" class="btn-primary">Learn More</a>
            </div>
            {{-- <img src="{{ asset('frontend/images/maintenance.png') }}" alt="" class="max-w-[500px] w-full h-auto" /> --}}
            <x-svg.maintenance />
        </div>
    </div>
@endsection
