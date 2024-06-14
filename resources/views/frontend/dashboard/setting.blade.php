@extends('frontend.layouts.dashboard')

@section('title', __('account_setting'))
@section('breadcrumb')
    <x-frontend.breadcrumb.breadcrumb :links="[['text' => 'Dashboard', 'url' => '/'], ['text' => 'Account Setting']]" />
@endsection
@section('dashboard-content')
    <div class="flex flex-col gap-8" x-data='{ deleteModal : false }'>
        <div>
            <h3 class="heading-05 dark:text-white text-gray-900 mb-4">{{ __('account_information') }}</h3>
            <form action="{{ route('frontend.profile') }}" method="POST" enctype="multipart/form-data"
                class="flex lg:flex-row flex-col gap-8" x-data="uploadProfile">
                @csrf
                @method('put')
                <div x-data="uploadProfile">
                    <input type="file" id="file-input" @change="handleImageUpload" name="image"
                        accept="image/png, image/jpg, image/jpeg" class="appearance-none w-0 h-0">
                    <template x-if="image?.src">
                        <div
                            class="preview-container relative h-[200px] w-[200px] rounded-full border border-gray-100 overflow-hidden group">
                            <img :src="image?.src" :alt="`Uploaded Image`" class="w-full h-full  object-cover ">
                            <button @click="removeImage()"
                                class=" hidden group-hover:inline-flex  absolute left-[50%] translate-x-[-50%] bottom-4 bg-gray-50 w-[30px] h-[30px] p-[5px] rounded-full  justify-center items-center text-red-500"
                                type="button" title="{{ __('delete') }}">
                                <x-svg.delete-icon />
                            </button>
                        </div>
                    </template>

                    <template x-if="!image?.src">
                        <label for="file-input"
                            class="h-[200px] w-[200px]  items-center justify-center p-6 cursor-zoom-in transition-all duration-300 hover:bg-gray-50 block shadow-[0px_1px_2px_0px_rgba(16,24,40,0.05)] rounded-full border border-gray-100 ">
                            <i class="mb-4  flex justify-center items-center">
                                <x-frontend.icons.outline-upload />
                            </i>
                            <h3 class="mb-1.5 body-sm-500 text-gray-900 text-center">Upload Photo or <span
                                    class="text-primary-500">Browse
                                    File</span></h3>
                            <p class="body-sm-400 text-center text-gray-600">Good Photo radio 4:3 and good width
                                size would be: 1200px</p>

                        </label>
                    </template>

                </div>
                <div class="flex-grow grid lg:grid-cols-1 xl:grid-cols-2 sm:grid-cols-2 grid-cols-1 gap-4">
                    <div>
                        <label for="Fname" class="tc-label">{{ __('full_name') }}</label>
                        <input required id="Fname" name="name" type="text" placeholder="{{ __('full_name') }}"
                            class="tc-input  @error('name') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                            value="{{ $user->name }}">
                        @error('name')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="telephonee" class="tc-label">{{ __('phone_number') }}</label>
                        <input required id="telephonee" name="phone" type="tel" placeholder="{{ __('phone') }}"
                            class="tc-input  @error('phone') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                            value="{{ $user->phone ? $user->phone : '' }}">
                        @error('phone')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="tc-label">{{ __('email') }}</label>
                        <input required id="email" name="email" type="email"
                            placeholder="{{ __('email_address') }}"
                            class="tc-input  @error('email') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                            value="{{ $user->email }}">
                        @error('email')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="web" class="tc-label">{{ __('website_links') }} ({{ __('optional') }})</label>
                        <input name="web" id="web" type="text" placeholder="Website Links" class="tc-input"
                            value="{{ $user->web ? $user->web : '' }}">
                    </div>

                    <div class="w-full">
                        <label for="address" class="tc-label">{{ __('address') }}</label>
                        <textarea name="address" id="address" placeholder="{{ __('address') }}"
                            class="tc-input  @error('address') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                            cols="30" rows="5">{{ $user->address }}</textarea>
                        @error('address')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label for="bio" class="tc-label">{{ __('about_seller') }}</label>
                        <textarea name="bio" id="bio" placeholder="{{ __('bio') }}"
                            class="tc-input  @error('bio') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                            cols="30" rows="5">{{ $user->bio }}</textarea>
                        @error('bio')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="btn-primary">{{ __('save_changes') }}</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="h-[1px] bg-gray-100"></div>
        <div>
            <form action="{{ route('frontend.social.update') }}" method="POST">
                @csrf
                @method('PUT')
                <h3 class="heading-05 dark:text-white text-gray-900 mb-4">{{ __('social_media') }}</h3>
                <div x-data="{ count: 1 }">
                    <template x-for="index in count" :key="index">
                        <div class="dropdown-input__wrap gap-4 flex" :id="'wrap_' + index">
                            <div class="flex-grow flex border border-gray-100 rounded-lg mb-4 dropdown-input">
                                <select name="social_media[]" class="inline-flex rounded-l-lg border-0 focus:border-0">
                                    <option value="" class="d-none">{{ __('select_one') }}</option>
                                    @foreach(\App\Enum\Social::cases() as $key=>$value)
                                        <option value="{{$value->value}}">{{ucf($value->name)}}</option>
                                    @endforeach
                                </select>
                                <input name="url[]" type="text" placeholder="{{ __('url') }}"
                                    class="tc-input !shadow-none !rounded-r-lg !border-none">
                            </div>
                            <div x-show="index !== 1" x-cloak>
                                <button type="button" @click="count -= 1"
                                    class="btn-remove h-[44px] w-[44px] text-white rounded-lg inline-flex justify-center items-center bg-error-500">
                                    <x-svg.remove-icon />
                                </button>
                            </div>
                        </div>
                    </template>

                    @foreach ($social_medias as $media)
                        <div class="dropdown-input__wrap flex gap-4" id="wrap_{{ $media->id }}">
                            <div class="flex-grow flex border border-gray-100 rounded-lg mb-4 dropdown-input">
                                <select name="socialMedia" class="inline-flex rounded-l-lg border-0 focus:border-0">
                                    <option value="" class="d-none">{{ __('select_one') }}
                                    </option>
                                    @foreach(\App\Enum\Social::cases() as $key=>$value)
                                        <option {{ $media->social_media == $value->value ? 'selected' : '' }} value="{{$value->value}}">{{ucf($value->name)}}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="url[]" placeholder="{{ __('url') }}"
                                    class="tc-input !shadow-none !rounded-r-lg !border-none" value="{{ $media->url }}">
                            </div>
                            <div>
                                <button onclick="removeElement({{ $media->id }})" type="button"
                                    class="btn-remove h-[44px] w-[44px] text-white rounded-lg inline-flex justify-center items-center bg-error-500">
                                    <x-svg.remove-icon />
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <div>
                        <button type="button" @click="count += 1"
                            class="btn-primary w-full">{{ __('add_new') }}</button>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn-primary">{{ __('save_changes') }}</button>
                </div>
            </form>
        </div>
        <div class="h-[1px] bg-gray-100"></div>
        <div>
            <h3 class="heading-05 dark:text-white text-gray-900 mb-4">{{ __('change_password') }}</h3>
            <form action="{{ route('frontend.password') }}" method="POST" x-data="{ openEye: false, openEye2: false, openEye3: false }">
                @csrf
                @method('PUT')
                <div class="flex-grow grid grid-cols-3 gap-4">
                    <div>
                        <label for="password" class="tc-label">{{ __('password') }}</label>
                        <div class="relative">
                            <input required name="current_password" :type="openEye ? 'text' : 'password'"
                                placeholder="{{ __('password') }}"
                                class="tc-input  @error('current_password') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                                id="password" value="{{ old('current_password') }}">
                            <span @click="openEye = !openEye"
                                class="absolute cursor-pointer top-1/2 -translate-y-1/2 right-3.5">
                                <x-svg.eye-slash-icon xShow="!openEye" />

                                <x-svg.eye-open-icon xShow="openEye" />
                            </span>
                        </div>
                        @error('current_password')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="newpassword" class="tc-label">{{ __('new_password') }}</label>
                        <div class="relative">
                            <input required name="password" :type="openEye2 ? 'text' : 'password'"
                                placeholder="{{ __('new_password') }}"
                                class="tc-input  @error('password') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                                id="newpassword" value="{{ old('password') }}">
                            <span @click="openEye2 = !openEye2"
                                class="absolute cursor-pointer top-1/2 -translate-y-1/2 right-3.5">
                                <x-svg.eye-slash-icon xShow="!openEye2" />

                                <x-svg.eye-open-icon xShow="openEye2" />
                            </span>
                        </div>
                        @error('password')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="con_password" class="tc-label">{{ __('confirm_password') }}</label>
                        <div class="relative">
                            <input required name="password_confirmation" :type="openEye3 ? 'text' : 'password'"
                                placeholder="{{ __('confirm_password') }}"
                                class="tc-input  @error('password_confirmation') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror">
                            <span @click="openEye3 = !openEye3"
                                class="absolute cursor-pointer top-1/2 -translate-y-1/2 right-3.5">
                                <x-svg.eye-slash-icon xShow="!openEye3" />

                                <x-svg.eye-open-icon xShow="openEye3" />
                            </span>
                        </div>
                        @error('password_confirmation')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn-primary">{{ __('save_changes') }}</button>
                    </div>
                </div>
            </form>
        </div>
         <!-- Profile delete modal start -->
    <div class="h-[1px] bg-gray-100"></div>
    <form action="{{ url('/seller', ['user' => $user->username]) }}" method="POST" >
        @csrf
        @method('delete')
        <div>
            <h3 class="heading-05 dark:text-white text-gray-900 mb-4">{{__('delete_account')}}</h3>
            <div>
                <p class="text-gray-600 dark:text-gray-100 mb-4">{{__('account_delete_warning')}}</p>
            </div>
        </div>
        <div x-show="deleteModal" x-cloak class="fixed z-50 p-8 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white">
            <h3 class="text-xl font-semibold mb-4">{{__('confirm_deletion')}}</h3>
            <p class="mb-3">{{__('Please_enter_your_password_to_confirm_the_deletion')}}</p>
            <input type="password" name="password" required placeholder="Enter your password" class="block w-full text-sm text-gray-900 rounded-lg border border-gray-100 focus:ring-blue-500 mb-4">

            <div class="flex justify-end">
                <button type="submit" class="btn-primary" @click="confirmDelete">{{__('confirm')}}</button>
            </div>
        </div>
        <div x-show="deleteModal" x-cloak @click="deleteModal = false" class="fixed top-0 left-0 w-full h-full bg-black/50 z-10"></div>
        <button type="button" class="btn-danger" @click="deleteModal = true">
            {{__('delete_account')}}
        </button>
        <!-- Profile delete modal end -->
    </div>
@endsection
@push('js')
    <script defer>
        document.addEventListener('alpine:init', () => {
            Alpine.data('uploadProfile', () => ({
                image: {
                    src: '{{ $user->image_url }}',
                    name: ''
                },
                handleImageUpload(event) {
                    const file = event.target.files[0];
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        this.image.src = event.target.result;
                        this.image.name = file?.name;
                    };
                    reader.readAsDataURL(file);
                },
                removeImage() {
                    this.image = {
                        src: "",
                        name: ""
                    };
                }
            }))
        })

        function removeElement(id) {
            const element = document.getElementById(`wrap_${id}`);
            element.remove();
        }
        // document.addEventListener('DOMContentLoaded', function() {
        //     const addButton = document.querySelector('.btn-primary');

        //     addButton.addEventListener('click', function() {
        //         const dropdownInput = document.querySelector('#wrap_1');
        //         const clone = dropdownInput.children[0].cloneNode(true);
        //         dropdownInput.appendChild(clone);
        //     });
        // });
    </script>
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('deleteModal', () => {
            return {
                password: '',
                deleteModal: false,

                confirmDelete() {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('_method', 'DELETE');
                    formData.append('password', this.password);

                    fetch('{{ url("/seller", ["user" => $user->username]) }}', {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {

                                alert('Account deleted successfully');
                                this.resetModal();
                            } else {

                            }
                        })
                        .catch(error => {

                        });
                },

                resetModal() {
                    this.password = '';
                    this.deleteModal = false;
                }
            };
        });
    });
</script>
@endpush
