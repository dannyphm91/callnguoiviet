@extends('frontend.layouts.app')
@section('title')
    {{ __('opss_page_not_found') }}
@endsection
@section('content')
<div class="w-full min-h-screen flex justify-center items-center relative overflow-hidden">
    <div class="w-full h-full flex flex-col justify-center items-center px-4 py-8">
        <img src="{{ asset('frontend/images/500.png') }}" alt="" class="max-w-[500px] h-[300px]" />
        <div>
            <h4 class="font-display font-semibold text-xl sm:text-3xl xl:text-5xl leading-[56px] text-center text-gray-900 mb-5">
               {{__('500 Error ! Page Not Found')}}
            </h4>
            <p class="font-display text-sm sm:text-lg max-w-2xl font-normal text-center text-gray-700 mb-8">
               {{ __('the_page_you_are_looking_for_does_not_exist_or_an_other_error_occurred_go_back_or_head_over_to_choose_new_direction', ['domain' => config('app.url')]) }}
            </p>
        </div>
        <div class="flex justify-center gap-3">
            <a class="btn-primary" href="/">
                <span>{{__('go_to_home_page')}}</span>
            </a>

            <a class="btn-secondary" href="/home">
                <span>{{__('go_back')}}</span>
            </a>
        </div>
        <p class="text-center bg-white px-4 pt-24 rounded-md text-base text-gray-500 text-opacity-90">
            {{ __('all_content_current_and_respective_copyright_holders', ['domain' => config('app.url'), 'year' => now()->year ]) }}
        </p>
    </div>
</div>
@endsection
