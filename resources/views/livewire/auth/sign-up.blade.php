<div class="min-h-[80vh] py-16 flex items-center justify-center dark:bg-gray-900 bg-gray-50">
    <div class="mx-3">
        <div class="auth-card w-full max-w-[536px] md:min-w-[536px] sm:p-8 p-4 mb-4 rounded-xl bg-white dark:bg-gray-800">
            <h2 class="heading-05 text-center text-gray-900 dark:text-white sm:mb-6 mb-4">{{ __('create_account') }}</h2>
            <form action="" class="mb-6" x-data="{ openEye: false, openEye2: false }">
                <div class="flex flex-col gap-4 sm:mb-6 mb-4">
                    <div>
                        <label for="name" class="tc-label">{{ __('name') }}</label>
                        <input wire:model.lazy="name" type="text" placeholder="{{ __('full_name') }}" id="name"
                            class="tc-input @error('name') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror">
                        @error('name')
                            <p class="text-sm mt-0.5 text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="tc-label">{{ __('email') }}</label>
                        <input wire:model.lazy="email" type="email" placeholder="{{ __('email_address') }}"
                            id="email"
                            class="tc-input @error('email') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror">
                        @error('email')
                            <p class="text-sm mt-0.5 text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="tc-label">{{ __('password') }}</label>
                        <div class="relative">
                            <input wire:model.lazy="password" :type="openEye ? 'text' : 'password'"
                                placeholder="{{ __('password') }}"
                                class="tc-input @error('password') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror">

                            <span @click="openEye = !openEye"
                                class="absolute cursor-pointer top-1/2 -translate-y-1/2 ltr:right-3.5 rtl:left-3.5">
                                <x-svg.eye-slash-icon xShow="!openEye" />
                                <x-svg.eye-open-icon xShow="openEye" />
                            </span>
                        </div>
                        @error('password')
                            <p class="text-sm mt-0.5 text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="con_password" class="tc-label">{{ __('confirm_password') }}</label>
                        <div class="relative">
                            <input wire:model.lazy="cpassword" :type="openEye2 ? 'text' : 'password'"
                                placeholder="{{ __('confirm_password') }}"
                                class="tc-input @error('cpassword') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror">
                            <span @click="openEye2 = !openEye2"
                                class="absolute cursor-pointer top-1/2 -translate-y-1/2 ltr:right-3.5 rtl:left-3.5">
                                <x-svg.eye-slash-icon xShow="!openEye2" />
                                <x-svg.eye-open-icon xShow="openEye2" />
                            </span>
                        </div>
                        @error('cpassword')
                            <p class="text-sm mt-0.5 text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    @if (config('captcha.active'))
                        <div>
                            <div id="captcha" wire:ignore></div>
                            @error('captcha')
                                <p class="mb-3 text-sm text-red-600 dark:text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    @endif
                </div>
                <div>
                    <button wire:loading.attr="disabled" wire:click.prevent="register()" type="button"
                        class="btn-primary py-3 px-5 w-full flex">
                        <span>{{ __('sign_up') }}</span>
                        <span wire:loading wire:target="register" class="animate-spin rtl:rotate-180">
                            <x-svg.loading-icon />
                        </span>
                        <span wire:loading.remove wire:target="register" class="rtl:rotate-180">
                            <x-svg.arrow-long-icon />
                        </span>
                    </button>
                </div>
            </form>

            {{-- Social Login --}}
            <x-frontend.social-login />
        </div>
        <div class="flex flex-wrap gap-3 justify-between items-center">
            <p class="flex gap-1.5 items-center">
                <span class="body-md-400 text-gray-600 dark:text-gray-100">{{ __('have_account') }}</span>
                <a href="/login"
                    class="heading-07 hover:text-primary-700 transition-all duration-300 text-primary-500">{{ __('login') }}</a>
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
