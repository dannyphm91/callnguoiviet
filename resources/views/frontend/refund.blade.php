@extends('frontend.layouts.app')

@section('title', __('refund_policy'))

@section('content')

    <div>
        <x-frontend.breadcrumb.breadcrumb :links="[['url' => '#', 'text' => __('refund_policy')]]" />

        <!-- Refund Policy Page Start  -->
        <section class="py-16">
            <div class="container">
                <div class="flex flex-col md:flex-row gap-12 items-center">
                    <div class="w-full body-md-400 dark:text-gray-100">
                        {!! $refund_content ? $refund_content : $cms->refund_body ?? __('no_refund_policy_found') !!}
                    </div>

                </div>
            </div>
        </section>
        <!-- Refund Policy Page End  -->

    </div>
@endsection
