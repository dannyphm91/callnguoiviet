@if (config('services.google.active') || config('services.linkedin.active'))
    <div class="registration-form__sign-btns">
        @if (config('services.google.active') && config('services.google.client_id') && config('services.google.client_secret'))
            <a href="/auth/google/redirect" class="btn-sign">
                <span class="icon">
                    <x-svg.google-icon />
                </span>
                @if (Route::currentRouteNamed('frontend.signup'))
                    {{ __('sign_up_with_google') }}
                @else
                    {{ __('sign_in_with_google') }}
                @endif
            </a>
        @endif
        @if (config('services.linkedin.active') && config('services.linkedin.client_id') && config('services.linkedin.client_secret'))
            <a href="/auth/linkedin/redirect" class="btn-sign">
                <span class="icon ">
                    <x-svg.linkedin-icon fill="#0288d1" />
                </span>
                @if (Route::currentRouteNamed('frontend.signup'))
                    {{ __('sign_up_with_linkedin') }}
                @else
                    {{ __('sign_in_with_linkedin') }}
                @endif
            </a>
        @endif
    </div>
@endif

@if (config('services.facebook.active') || config('services.twitter.active'))
    <div class="registration-form__sign-btns">
        @if (config('services.facebook.active') && config('services.facebook.client_id') && config('services.facebook.client_secret'))
            <a href="/auth/facebook/redirect" class="btn-sign">
                <span class="icon">
                    <x-svg.facebook-icon />
                </span>
                @if (Route::currentRouteNamed('frontend.signup'))
                    {{ __('sign_up_with_facebook') }}
                @else
                    {{ __('sign_in_with_facebook') }}
                @endif
            </a>
        @endif
        @if (config('services.twitter.active') && config('services.twitter.client_id') && config('services.twitter.client_secret'))
            <a href="/auth/twitter/redirect" class="btn-sign">
                <span class="icon">
                    <x-svg.twitter-icon fill="#03A9F4" />
                </span>
                @if (Route::currentRouteNamed('frontend.signup'))
                    {{ __('sign_up_with_twitter') }}
                @else
                    {{ __('sign_in_with_twitter') }}
                @endif
            </a>
        @endif
    </div>
@endif
@if (config('services.github.active'))
    <div class="registration-form__sign-btns">
        @if (config('services.github.active') && config('services.github.client_id') && config('services.github.client_secret'))
            <a href="/auth/github/redirect" class="btn-sign">
                <span class="icon">
                    <x-svg.github-icon />
                </span>
                @if (Route::currentRouteNamed('frontend.signup'))
                    {{ __('sign_up_with_github') }}
                @else
                    {{ __('sign_in_with_github') }}
                @endif
            </a>
        @endif
    </div>
@endif

@if (config('services.google.active') || config('services.linkedin.active') || config('services.facebook.active') || config('services.twitter.active') || config('services.github.active'))
    <h2 class="registration-form__alternative-title text--body-3">
        @if (Route::currentRouteNamed('frontend.signup'))
            {{ __('or_sign_up_with_email') }}
        @else
            {{ __('or_sign_in_with_email') }}
        @endif
    </h2>
@endif
