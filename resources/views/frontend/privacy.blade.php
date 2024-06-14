@extends('frontend.layouts.app')

@section('title', __('privacy_policy'))

@section('content')

    <div>
        <x-frontend.breadcrumb.breadcrumb :links="[['url' => '#', 'text' => __('privacy_policy')]]" />

        <!-- privacy policy section start  -->
        <section class="py-16">
            <div class="container">
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <div class="w-full body-md-400 dark:text-gray-100">
                        {!! $privacy_content ? $privacy_content : $cms->privacy_body ?? __('no_privacy_policy_found') !!}
                    </div>

                </div>
            </div>
        </section>
        <!-- privacy policy section end  -->

    </div>
@endsection
