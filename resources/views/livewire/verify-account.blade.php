<div class="flex flex-col gap-8">
    <div>
        <h3 class="heading-05 dark:text-white text-gray-900 mb-4">{{ __('verify_account') }}</h3>
        <form wire:submit.prevent="save" >
            <div class="flex flex-wrap gap-6 items-start">
                <div class="mb-5 sm:max-w-[300px] w-full flex flex-col gap-4">
                    <div x-data="uploadProfile">
                        <h3 class="tc-label">{{ __('profile_photo') }}</h3>
                        <template x-if="!image">
                            <label for="file-input"
                                class="p-6 w-full h-[160px] cursor-zoom-in transition-all duration-300 hover:bg-gray-50 block shadow-[0px_1px_2px_0px_rgba(16,24,40,0.05)] rounded-lg border border-gray-100 dark:border-gray-600">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="mb-4">
                                        <x-frontend.icons.outline-upload />
                                    </div>
                                    <h3 class="mb-1.5 body-sm-500 dark:text-white text-gray-900">
                                        {{ __('upload_photo') }} {{ __('or') }}
                                        <span class="text-primary-500">{{ __('choose_file')}}</span></h3>
                                    <p class="body-sm-400 text-center dark:text-gray-100 text-gray-600">Good Photo radio 4:3 and good width
                                        size would be: 1200px</p>
                                </div>
                                <input hidden type="file" id="file-input" @change="handleFileInput">
                            </label>
                        </template>
                        <template x-if="image">
                            <div class="preview-container relative">
                                <img :src="image.url" :alt="`Uploaded Image`"
                                    class="w-full max-h-[160px] min-h-[160px] object-cover rounded-md border border-gray-100">
                                <button @click="removeImage()"
                                    class="remove-button absolute -top-1 -right-1 bg-gray-400 p-[3px] rounded-full inline-flex justify-center items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                        viewBox="0 0 10 10" fill="none">
                                        <path d="M7.1875 7.1875L2.8125 2.8125M7.1875 2.8125L2.8125 7.1875"
                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </template>

                    </div>
                    <div>
                        <label for="" class="tc-label">{{ __('national_id') }}/{{ __('passport') }}/{{ __('driving_license') }}</label>
                        <input type="file" name="" class="dark:text-gray-100" wire:model="passport" accept=".pdf, image/*" id="" class="!p-0 tc-input">
                        <x-forms.input-error for="passport" />
                    </div>
                </div>
                <div class="flex flex-col gap-4 flex-grow">
                    <div>
                        <label for="" class="tc-label">{{ __('full_name')}}</label>
                        <input type="text" value="{{$user->name}}" placeholder="{{ __('full_name')}}" class="tc-input min-w-[300px]">
                    </div>
                    <div>
                        <label for="" class="tc-label">{{ __('phone_number')}}</label>
                        <input type="text" value="{{$user->phone}}" placeholder="{{ __('phone_number')}}" class="tc-input min-w-[300px]">
                    </div>
                    <div>
                        <label for="" class="tc-label">{{ __('email_address')}}</label>
                        <input type="email" value="{{$user->email}}" placeholder="{{ __('email_address')}}" class="tc-input min-w-[300px]">
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <button class="btn-primary">{{ __('submit_for_verification') }}</button>
            </div>
        </form>
    </div>
</div>
