<div class="col-lg-6 order-1 order-lg-0">
    <div class="registration-form">
        <h2 class="text-center text--heading-1 registration-form__title">{{ __('sign_in') }}</h2>
        {{-- Social Login --}}
        <x-auth.social-login />
        <div class="registration-form__wrapper">
            <form action="{{ route('frontend.login') }}" method="POST">
                @csrf
                <!-- check if user from post job button -->
                <input type="hidden" class="d-none" value="{{ request('post_ads') }}" name="post_job">
                <!-- check if user from post job button end -->
                <div class="input-field">
                    <input value="{{ old('email') }}" type="text" name="login_data"
                        placeholder="{{ __('username_or_email_address') }}"
                        class="@error('email') is-invalid border-danger @enderror @error('username') is-invalid border-danger @enderror" />
                    @error('email')
                        <span cssslass="text-danger">{{ $message }}</span>
                    @enderror
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <input type="password" placeholder="{{ __('password') }}" id="password" name="password"
                        class="@error('password') is-invalid border-danger @enderror" value="" />
                    <span class="icon icon--eye {{ $errors->has('password') ? 'height-45' : '' }}"
                        onclick="showPassword('password',this)">
                        <x-svg.eye-icon />
                    </span>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="registration-form__option">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkme" />
                        <x-forms.label name="keep_me_logged" class="form-check-label" for="checkme" />
                    </div>

                    <div class="registration-form__forget-pass text--body-4">
                        <a href="{{ route('customer.forgot.password') }}">{{ __('forget_password') }}</a>
                    </div>
                </div>
                @if (config('captcha.active'))
                    <div class="input-field">
                        {!! NoCaptcha::display() !!}
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger text-sm">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                    </div>
                @endif
                <button class="btn btn--lg w-100 registration-form__btns" type="submit">
                    {{ __('sign_in') }}
                    <span class="icon--right">
                        <x-svg.right-arrow-icon stroke="currentColor" />
                    </span>
                </button>

                <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                    <p class="text--body-3 registration-form__redirect">
                        {{ __('dont_have_account') }} ?
                        <!-- check if user from post job button -->
                        @if (request('post_ads'))
                            <a href="{{ route('frontend.signup', ['post_ads' => true]) }}">
                                {{ __('sign_up') }}
                            </a>
                        @else
                            <a href="{{ route('frontend.signup') }}">
                                {{ __('sign_up') }}
                            </a>
                        @endif
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

@push('component_style')
    <style>
        .height-45 {
            height: 45px !important;
        }
    </style>
@endpush
