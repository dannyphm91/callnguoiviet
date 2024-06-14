@extends('frontend.layouts.app')

@section('title', __('message'))

@section('content')
    <x-frontend.breadcrumb.breadcrumb :links="[['text' => 'Dashboard'], ['text' => 'Message']]" />

    <div id="app">
        <messenger :users="{{ $users }}" :auth="{{ auth()->user() }}"></messenger>
    </div>
@endsection

@push('js')
@vite('resources/frontend/js/vue-config.js')
@endpush
