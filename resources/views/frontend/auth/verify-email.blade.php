@extends('frontend.layouts.app')
@section('title', __('verify_email'))
@section('content')
    <div class="min-h-[80vh] py-16 flex items-center justify-center bg-gray-50">
        <div class="mx-3">
            <div class="auth-card w-full max-w-[536px] md:min-w-[536px] p-8 mb-4 rounded-xl bg-white">
                <h2 class="heading-05 text-center text-gray-900 mb-6">{{ __('please_verify_your_email') }}</h2>
                <p class="text-center body-md-400 text-gray-600 mb-6">
                    {{ __('you_are_almost_there_we_sent_an_email_to') }}:
                    <b>{{ authUser()->email }}</b>
                </p>
                <span class="body-md-400 text-gray-600 dark:text-gray-100 mb-3">{{ __('did_not_receive_the_email') }}</span>
                @if (checkMailConfig())
                    <form action="{{ route('verification.resend') }}" method="POST" class="mb-6">
                        @csrf
                        <button type="submit" class="btn-primary py-3 px-5 w-full flex">
                            {{ __('send_mail_again') }}
                        </button>
                    </form>
                @else
                    <button type="button" onclick="toastr.error('Mail not sent due to incomplete mail configuration')"
                        class="btn-primary py-3 px-5 w-full flex">
                        {{ __('send_mail_again') }}
                    </button>
                @endif
            </div>
        </div>
    </div>
@endsection
