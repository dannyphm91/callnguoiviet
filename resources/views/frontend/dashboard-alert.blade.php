@if (auth('user')->check() &&
    !auth()->user()->hasVerifiedEmail() &&
    $setting->customer_email_verification)
    <div class="row">
        <div class="col-12 mb-2">
            <div class="alert alert-warning mb-0" role="alert">
                <strong>{{ __('verify_account_now') }}</strong> <a href="{{ route('verification.notice') }}"
                    class="text-dark text-decoration-underline">
                    {{ __('click_here') }}
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
@endif
