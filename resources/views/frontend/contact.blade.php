@extends('frontend.layouts.app')

@section('title', __('contact'))

@section('meta')
    @php
        $data = metaData('contact');
    @endphp

    <meta name="title" content="{{ $data->title }}">
    <meta name="description" content="{{ $data->description }}">

    <meta property="og:image" content="{{ $data->image_url }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $data->title }}">
    <meta property="og:url" content="{{ route('frontend.contact') }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{ $data->description }}">

    <meta name=twitter:card content="{{ $data->image_url }}" />
    <meta name=twitter:site content="{{ config('app.name') }}" />
    <meta name=twitter:url content="{{ route('frontend.contact') }}" />
    <meta name=twitter:title content="{{ $data->title }}" />
    <meta name=twitter:description content="{{ $data->description }}" />
    <meta name=twitter:image content="{{ $data->image_url }}" />
@endsection

@section('content')
    <div>
        {{-- <x-frontend.breadcrumb.breadcrumb :links="[['text' => 'Contact']]" /> --}}
        <x-frontend.breadcrumb.breadcrumb :links="[ ['url' => '#', 'text' => __('contact')] ]" />

        <!-- Contact section Start -->
        @livewire('contact-component')
        <!-- Contact section End -->

        @if($setting->map_address)
        <div class="map">
            {!! $setting->map_address !!}
        </div>
        @endif

    </div>
@endsection
