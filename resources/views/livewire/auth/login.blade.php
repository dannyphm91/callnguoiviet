<div class="min-h-[80vh] py-16 flex items-center justify-center dark:bg-gray-900 bg-gray-50">
    <div class="mx-3">
        <div class="auth-card border border-gray-100 dark:border-gray-600 w-full max-w-[536px] md:min-w-[536px] sm:p-8 p-5 mb-4 rounded-xl bg-white dark:bg-gray-800">
            <h2 class="heading-05 text-center text-gray-900 dark:text-white mb-6">{{ __('login_to_your_account') }}</h2>
            <form x-data="{ openEye: false }">
                <div class="flex flex-col gap-4 mb-6">
                    <div>
                        <label for="email" class="tc-label">{{ __('email') }}</label>
                        <input wire:model.lazy="username" type="text" placeholder="Email address"
                            class="tc-input @error('username') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                            autocomplete="off">
                        @error('username')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <div class="flex justify-between items-center">
                            <label for="email" class="tc-label">{{ __('password') }}</label>
                            <a href="{{ route('frontend.forgot.password') }}"
                                class="heading-08 text-primary-500">{{ __('forgot_password') }}</a>
                        </div>
                        <div class="relative">
                            <input wire:model.lazy="password" :type="openEye ? 'text' : 'password'"
                                placeholder="Password"
                                class="tc-input @error('password') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror">
                            <span @click="openEye = !openEye"
                                class="absolute dark:text-gray-100 cursor-pointer top-1/2 -translate-y-1/2 ltr:right-3.5 rtl:left-3.5">
                                <x-svg.eye-slash-icon xShow="!openEye" />
                                <x-svg.eye-open-icon xShow="openEye" />
                            </span>
                        </div>
                        @error('password')
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
                    <button wire:loading.attr="disabled" wire:click.prevent="login()" type="button"
                        class="btn-primary py-3 px-5 w-full flex">
                        <span>{{ __('login') }}</span>
                        <span wire:loading wire:target="login" class="animate-spin rtl:rotate-180">
                            <x-svg.loading-icon />
                        </span>
                        <span wire:loading.remove wire:target="login" class="rtl:rotate-180">
                            <x-svg.arrow-long-icon />
                        </span>
                    </button>
                </div>
            </form>

            {{-- Social Login --}}
            <x-frontend.social-login />
        </div>
        <div class="flex gap-3 flex-wrap justify-between items-center">
            <p class="flex gap-1.5 items-center">
                <span class="body-md-400 text-gray-600 dark:text-gray-100">{{ __('you_dont_have_account') }}</span>
                <a href="{{ route('frontend.signup') }}"
                    class="heading-07 hover:text-primary-700 transition-all duration-300 text-primary-500">
                    {{ __('create_account') }}
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
