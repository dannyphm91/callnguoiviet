@extends('frontend.layouts.app')

@section('title', __('terms_condition'))

@section('content')

    <div>
        <x-frontend.breadcrumb.breadcrumb :links="[['url' => '#', 'text' => __('terms_condition')]]" />

        <!-- terms & conditions section start  -->
        <section class="py-16">
            <div class="container">
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <div class="w-full body-md-400 dark:text-gray-100">
                        {!! $terms_content ? $terms_content : $cms->terms_body ?? __('no_terms_conditions_found') !!}
                    </div>

                </div>
            </div>
        </section>
        <!-- terms & conditions section end  -->

    </div>
@endsection
