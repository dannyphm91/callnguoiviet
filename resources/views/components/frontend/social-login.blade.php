<div>
    @if (config('services.google.active') || config('services.linkedin.active') || config('services.facebook.active') || config('services.twitter.active') || config('services.github.active'))
        <div class="relative text-center mb-6 mt-4 sm:mt-6">
            <div class="relative z-50 px-4 bg-white dark:bg-gray-800 body-sm-400 inline-flex justify-center items-center text-gray-600 dark:text-gray-300">
                Or continue with
            </div>
            <div class="h-[1px] z-10 w-full bg-gray-100 absolute top-1/2 -translate-1/2"></div>
        </div>
        <div class="flex flex-wrap gap-3 items-center">
            @if (config('services.google.active') && config('services.google.client_id') && config('services.google.client_secret'))
            <a href="/auth/google/redirect" class="btn-social-login">
                <img src="{{ asset('frontend/images/google.png') }}" alt="">
                <span>Google</span>
            </a>
            @endif
            @if (config('services.linkedin.active') && config('services.linkedin.client_id') && config('services.linkedin.client_secret'))
            <a href="/auth/linkedin/redirect" class="btn-social-login">
                <img src="{{ asset('frontend/images/linkedin.svg') }}" alt="">
                <span>Linkedin</span>
            </a>
            @endif
            @if (config('services.facebook.active') && config('services.facebook.client_id') && config('services.facebook.client_secret'))
            <a href="/auth/facebook/redirect" class="btn-social-login">
                <img src="{{ asset('frontend/images/facebook.png') }}" alt="">
                <span>Facebook</span>
            </a>
            @endif
            @if (config('services.twitter.active') && config('services.twitter.client_id') && config('services.twitter.client_secret'))
            <a href="/auth/twitter/redirect" class="btn-social-login">
                <img src="{{ asset('frontend/images/twitter.svg') }}" alt="">
                <span>Twitter</span>
            </a>
            @endif
            @if (config('services.github.active') && config('services.github.client_id') && config('services.github.client_secret'))
            <a href="/auth/github/redirect" class="btn-social-login">
                <img src="{{ asset('frontend/images/github.svg') }}" alt="">
                <span>Github</span>
            </a>
            @endif
        </div>
    @endif
</div>
