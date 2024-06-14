<div class="min-h-[80vh] py-16 flex items-center justify-center bg-gray-50 dark:bg-gray-900">
    <div class="mx-3">
        @if (session()->has('success'))
            <div class="flex items-center p-4 mb-4 text-sm text-white rounded-lg bg-green-500 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <x-svg.session-success-icon />
                <div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="auth-card w-full max-w-[536px] md:min-w-[536px] sm:p-8 p-4 mb-4 rounded-xl bg-white dark:bg-gray-800">
            <h2 class="heading-05 text-center text-gray-900 dark:text-white mb-3">{{ __('forget_password') }}</h2>
            <p class="text-center body-md-400 text-gray-600 dark:text-gray-300 mb-6">
                {{ __('please_provide_the_email_address_that_you_used_when_you_signed_up_for_you_account') }} </p>
            <form action="">
                <div class="flex flex-col gap-4 mb-6">
                    <div>
                        <label for="email" class="tc-label">{{ __('email') }}</label>
                        <input wire:model="email" type="email" placeholder="{{ __('email_address') }}"
                            class="tc-input @error('email') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror">
                        @error('email')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @if (config('captcha.active'))
                    <div class="mb-5">
                        <div id="captcha" wire:ignore></div>
                        @error('captcha')
                            <p class="mb-3 text-sm text-red-600 dark:text-red-500">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                @endif
                <div>
                    <button wire:loading.attr="disabled" wire:click.prevent="sendPasswordResetLink()" type="button"
                        class="btn-primary py-3 px-5 w-full flex">
                        <span>{{ __('forget_password') }}</span>
                        <span wire:loading class="animate-spin ms-2" wire:target="sendPasswordResetLink">
                            <x-svg.loading-icon />
                        </span>
                    </button>
                </div>
            </form>
        </div>
        <div class="flex gap-3 flex-wrap justify-between items-center">
            <p class="flex gap-1.5 items-center">
                <span class="body-md-400 text-gray-600 dark:text-gray-100">{{ __('back_to') }}</span>
                <a href="/login"
                    class="heading-07 hover:text-primary-700 transition-all duration-300 text-primary-500">
                    {{ __('login') }}
                </a>
            </p>
        </div>
    </div>
</div>

@push('js')
    @if (config('captcha.active'))
        <script src="https://www.google.com/recaptcha/api.js?onload=handle&render=explicit" async defer></script>

        <script>
            var handle = function(e) {
                widget = grecaptcha.render('captcha', {
                    'sitekey': '{{ config('captcha.sitekey') }}',
                    'theme': 'light', // you could switch between dark and light mode.
                    'callback': verify
                });

            }
            var verify = function(response) {
                @this.set('captcha', response)
            }
        </script>
    @endif
@endpush
