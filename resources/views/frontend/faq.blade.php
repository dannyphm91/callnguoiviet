@extends('frontend.layouts.app')

@section('title', __('faqs'))

@section('meta')
@php
$data = metaData('faq');
@endphp

<meta name="title" content="{{ $data->title }}">
<meta name="description" content="{{ $data->description }}">

<meta property="og:image" content="{{ $data->image_url }}" />
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:title" content="{{ $data->title }}">
<meta property="og:url" content="{{ route('frontend.faq') }}">
<meta property="og:type" content="article">
<meta property="og:description" content="{{ $data->description }}">

<meta name=twitter:card content="{{ $data->image_url }}" />
<meta name=twitter:site content="{{ config('app.name') }}" />
<meta name=twitter:url content="{{ route('frontend.faq') }}" />
<meta name=twitter:title content="{{ $data->title }}" />
<meta name=twitter:description content="{{ $data->description }}" />
<meta name=twitter:image content="{{ $data->image_url }}" />
@endsection

@section('content')
    <div>
        <x-frontend.breadcrumb.breadcrumb :links="[ ['url' => '#', 'text' => __('faqs')] ]" />

        <section class="py-16 dark:bg-gray-800">
            <div class="container">
                <h2 class="text-center heading-02 text-gray-900 dark:text-white mb-6">{{ __('frequently_asked_question') }}</h2>
                <p class="text-center body-md-400 text-gray-800 dark:text-gray-100 mb-14">{{ $cms->faq_content }}</p>

                <div class="flex flex-wrap xl:px-44 justify-center items-center">
                    <div x-data="{tab: '{{ $initialTab }}'}" x-init="" class="relative w-full">

                        <div class="flex flex-wrap justify-center items-center gap-3 md:gap-6">
                            @foreach ($categories as $index => $faq_category)
                                <button @click="tab='tab-{{ $index + 1 }}'" type="button"
                                    :class="{ '!bg-primary-500 text-white': tab==='tab-{{ $index + 1 }}' }"
                                    class="flex flex-col gap-0.5 md:gap-4 justify-center items-center md:px-6 md:py-6 px-3 py-1.5 md:w-56 rounded-lg transition-all duration-300 text-gray-900 dark:text-white/80 hover:text-white bg-gray-50 dark:bg-gray-700 hover:bg-primary-500">
                                    <i class="{{ $faq_category->icon }} md:text-3xl text-sm"></i>
                                    <span class="text-sm">{{ $faq_category->name }}</span>
                                </button>
                            @endforeach
                        </div>

                        <div class="w-full md:p-5 p-0 mt-2 text-xs text-gray-400 rounded-md content">

                            @foreach ($categories as $index => $faq_category)
                                <div x-show="tab==='tab-{{ $index + 1 }}'" x-cloak class="relative">
                                    <div x-data="{
                                        activeAccordion: '',
                                        setActiveAccordion(id) {
                                            this.activeAccordion = (this.activeAccordion == id) ? '' : id
                                        }
                                    }" class="relative w-full mx-auto heading-05">

                                        @forelse ($faq_category->faqs as $faq)
                                            <div x-data="{ id: $id('accordion') }"
                                                :class="{
                                                    'text-primary-500 dark:text-primary-300': activeAccordion == {{ $faq->id }},
                                                    'text-gray-900 dark:text-gray-100': activeAccordion != {{ $faq->id }}
                                                }"
                                                class="mb-4 duration-300 ease-out border border-gray-100 dark:border-gray-300 rounded-md cursor-pointer group" x-cloak>
                                                <button @click="setActiveAccordion({{ $faq->id }})"
                                                    class="accordion-btn flex items-center justify-between w-full md:px-5 px-3 py-1.5 md:py-4 font-semibold text-left select-none">
                                                    <span> {{ $faq->question }}</span>
                                                    <div :class="{ 'rotate-90': activeAccordion == {{ $faq->id }} }"
                                                        class="relative flex items-center justify-center md:w-5 w-3 h-3 md:h-5 duration-300 ease-out">
                                                        <div
                                                            class="absolute w-0.5 h-full bg-neutral-500 group-hover:bg-neutral-800 rounded-full">
                                                        </div>
                                                        <div :class="{ 'rotate-90': activeAccordion == {{ $faq->id }} }"
                                                            class="absolute w-full h-0.5 ease duration-500 bg-neutral-500 group-hover:bg-neutral-800 group-hover:dark:bg-neutral-300 rounded-full">
                                                        </div>
                                                    </div>
                                                </button>
                                                <div x-show="activeAccordion=={{ $faq->id }}" x-collapse.duration.400ms
                                                    x-cloak>
                                                    <div class="accordion-item md:px-5 px-3 py-1.5 md:py-4 mt-2 body-md-400 text-gray-700 dark:text-gray-100">
                                                        {!! $faq->answer !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <x-no-data-found />
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        </section>

    </div>
@endsection

@push('css')
    <style>

    </style>
@endpush
