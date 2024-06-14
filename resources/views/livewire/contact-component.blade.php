<div>
    <section class="py-16 dark:bg-gray-800">
        <div class="container">
            <div class="w-full flex flex-col lg:flex-row bg-white dark:bg-gray-900 shadow-md border border-gray-50 dark:border-gray-600 rounded-lg">
                <div class="contact-info flex-grow p-12 max-w-[400px]">
                    <h2 class="heading-05 dark:text-white mb-8">{{ __('contact_info') }}</h2>
                    <ul>
                        <li class="flex gap-3 items-center mb-5 text-gray-700 dark:text-gray-300">
                            <i class="fa fa-phone text-primary-500"></i>
                            <span>{{ $cms->contact_number }}</span>
                        </li>
                        <li class="flex gap-3 items-center mb-5 text-gray-700 dark:text-gray-300">
                            <i class="fa fa-envelope text-primary-500"></i>
                            <span>{{ $cms->contact_email }}</span>
                        </li>
                        <li class="flex gap-3 items-center mb-5 text-gray-700 dark:text-gray-300">
                            <i class="fa fa-map text-primary-500"></i>
                            <span>{{ $cms->contact_address }}</span>
                        </li>
                    </ul>
                </div>
                <div
                    class="contact-form p-12 flex-grow lg:flex-grow-0 lg:w-2/3 lg:border-l lg:border-t-0 border-t border-gray-50 dark:border-gray-600">
                    <h2 class="heading-05 dark:text-white mb-8">{{ __('send_message') }}</h2>
                    <form wire:submit.prevent="submitContact" method="Post" class="mb-6">
                        @csrf
                        <div class="flex flex-col gap-4">
                            <div class="grid sm:grid-cols-2 grid-cols-1 gap-5">
                                <div>
                                    <label for="name" class="tc-label dark:text-gray-600">{{__('name')}}</label>
                                    <input type="text" name="name" wire:model.defer="name"
                                        placeholder="{{ __('full_name') }}" id="name"
                                        class="tc-input @error('name') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror">
                                    @error('name')
                                        <p class="text-sm text-red-600 dark:text-red-500"> {{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="tc-label dark:text-gray-600">{{__('email')}}</label>
                                    <input type="email" name="email" wire:model.defer="email"
                                        placeholder="{{ __('email_address') }}" id="email"
                                        class="tc-input @error('email') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror">
                                    @error('email')
                                        <p class="text-sm text-red-600 dark:text-red-500"> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="subject" class="tc-label dark:text-gray-600">{{__('subject')}}</label>
                                <div class="relative">
                                    <input type="text" name="subject" wire:model.defer="subject"
                                        placeholder="{{ __('subjects') }}"
                                        class="tc-input @error('subject') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror">
                                    @error('subject')
                                        <p class="text-sm text-red-600 dark:text-red-500"> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="message" class="tc-label dark:text-gray-600">{{ __('message') }}</label>
                                <textarea placeholder="{{ __('message') }}" name="message" wire:model.defer="message"
                                    class="tc-input @error('message') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                                    rows="8"></textarea>
                                @error('message')
                                    <p class="text-sm text-red-600 dark:text-red-500"> {{ $message }}</p>
                                @enderror
                            </div>

                            @if (config('captcha.active'))
                                <div class="mb-5">
                                    <div id="captcha" wire:ignore></div>
                                    @error('captcha')
                                        <p class="text-sm text-red-600 dark:text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <div>
                            <button wire:loading.attr="disabled" wire:click.prevent="submitContact()" type="button"
                                class="btn-primary py-3 px-5 mt-4">
                                <span>{{ __('send_message') }}</span>
                                <span wire:loading wire:target="submitContact">
                                    <span class="spinner-border spinner-border-sm" id="circle-notch"></span>
                                </span>
                                <span wire:loading.remove wire:target="submitContact" class="submit-arrow-icon">
                                    <x-svg.arrow-long-icon />
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>

@push('css')
    <style>
        /* Form submit spinner circle css */
        .spinner-border {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: -.125em;
            border: .25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: .75s linear infinite spinner-border;
            animation: .75s linear infinite spinner-border;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: .2em;
        }

        @-webkit-keyframes spinner-border {
            to {
                transform: rotate(360deg)
            }
        }

        @keyframes spinner-border {
            to {
                transform: rotate(360deg)
            }
        }

        /* Form submit spinner circle css */
    </style>
@endpush

@push('js')
    <!-- Captcha Script Start -->
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
    <!-- Captcha Script End -->
@endpush
