@extends('frontend.layouts.app')

@section('title', __('ad_post_success'))

@section('content')
    <div class="max-w-[872px] overflow-hidden bg-primary-50 my-24 mx-auto rounded-xl p-12">
        <div class="text-center max-w-[648px] w-full mx-auto">
            <div class="flex justify-center items-center text-primary-500 mb-8">
                <x-svg.post-success-icon />
            </div>
            @if ($mode == 'update')
                <h2 class="text-xl font-display font-semibold text-gray-900 mb-2">
                    {{ __('your_ad_has_successfully_update') }}
                </h2>
            @elseif ($mode == 'draft')
            <h2 class="text-xl font-display font-semibold text-gray-900 mb-2">
                {{ __('your_ad_has_successfully_drafted') }}
            </h2>
            @else
                <h2 class="text-xl font-display font-semibold text-gray-900 mb-2">
                    {{ __('your_ad_has_successfully_publish') }}
                </h2>
            @endif
            
            @if($mode=="draft")
            <p class="text-base text-gray-500 max-w-[384px] w-full mx-auto mb-6">
                {{ __('ad_drafted_success_description') }}
            </p>
            @elseif($mode == 'update')
            <p class="text-base text-gray-500 max-w-[384px] w-full mx-auto mb-6">
                {{ __('ad_update_success_description') }}
            </p>
            @else
            <p class="text-base text-gray-500 max-w-[384px] w-full mx-auto mb-6">
                {{ __('ad_create_success_description') }}
            </p>
            @endif

            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <a href="/dashboard" class="btn-primary">
                    Go To Dashboard
                </a>
                <a href="{{ route('frontend.addetails', $ad_slug) }}" class="btn-secondary">
                    <span>
                        {{ __('view_ad') }}
                    </span>
                </a>
            </div>

            {{-- @if ($mode == 'update')
            <h2 class="text--heading-1">{{ __('your_ad_has_successfully_update') }}</h2>
            @else
                <h2 class="text--heading-1">{{ __('your_ad_has_successfully_publish') }}</h2>
            @endif
            <p class="post-publish__brief text--body-3">{{ __('ad_create_success_description') }}</p>
            <div class="btns-group">
                <a href="{{ route('frontend.post') }}" class="btn btn--outline">{{ __('go_back') }}</a>
                <a href="{{ route('frontend.addetails', $ad_slug) }}" class="btn">
                    {{ __('view_ad') }}
                    <span class="icon--right">
                        <x-svg.right-arrow-icon />
                    </span>
                </a>
            </div> --}}

        </div>
    </div>
@endsection
