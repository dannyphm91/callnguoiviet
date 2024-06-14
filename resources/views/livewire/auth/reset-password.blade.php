<div class="min-h-screen bg-gray-50 dark:bg-gray-800">
    <div class="py-16 min-h-[80vh] flex justify-center items-center">
        <div class="mx-3">
            <div class="auth-card w-full max-w-[536px] md:min-w-[536px] p-8 mb-4 rounded-xl bg-white">
                <h2 class="heading-05 text-center text-gray-900 mb-3">{{ __('reset_password') }}</h2>
                <p class="text-center body-md-400 text-gray-600 mb-6">
                    {{ __('be_sure_to_write_a_password_thats_easy_for_you_to_remember_but_hard_for_others_to_guess') }}
                </p>
                <form action="" x-data="{ openEye: false, openEye2: false }">
                    <div class="flex flex-col gap-4 mb-6">
                        <div>
                            <label for="password" class="tc-label">{{ __('password') }}</label>
                            <div class="relative">
                                <input wire:model.lazy="password" :type="openEye ? 'text' : 'password'"
                                    placeholder="{{ __('password') }}"
                                    class="tc-input @error('password') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror">
                                @error('password')
                                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                                <span @click="openEye = !openEye"
                                    class="absolute cursor-pointer top-1/2 -translate-y-1/2 right-3.5">
                                    <x-svg.eye-slash-icon xShow="!openEye" />
                                    <x-svg.eye-open-icon xShow="openEye" />
                                </span>
                            </div>
                        </div>
                        <div>
                            <label for="con_password" class="tc-label">{{ __('confirm_new_password') }}</label>
                            <div class="relative">
                                <input wire:model.lazy="cpassword" :type="openEye2 ? 'text' : 'password'"
                                    placeholder="{{ __('confirm_new_password') }}"
                                    class="tc-input @error('cpassword') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror">
                                @error('cpassword')
                                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                                <span @click="openEye2 = !openEye2"
                                    class="absolute cursor-pointer top-1/2 -translate-y-1/2 right-3.5">
                                    <x-svg.eye-slash-icon xShow="!openEye2" />
                                    <x-svg.eye-open-icon xShow="openEye2" />
                                </span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button wire:loading.attr="disabled" wire:click.prevent="resetPassword()" type="button"
                            class="btn-primary py-3 px-5 w-full flex">
                            <span>{{ __('reset_password') }}</span>
                            <span wire:loading wire:target="resetPassword" class="animate-spin">
                                <x-svg.loading-icon />
                            </span>
                            <span wire:loading.remove wire:target="resetPassword">
                                <x-svg.arrow-long-icon />
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
