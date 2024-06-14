@extends('frontend.layouts.app')

@section('title', __('reset_password'))

@section('content')
    @livewire('auth.reset-password', ['token' => $token])
@endsection
