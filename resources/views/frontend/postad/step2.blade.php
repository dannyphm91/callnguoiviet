@extends('frontend.postad.index')

@section('title', __('step2'))

@section('post-ad-content')
    <div>
        <form action="{{ route('frontend.post.step2.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="d-none" name="category_id" value="{{ $category->id }}">
            <div class="sm:p-8 p-4 flex flex-col gap-8">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <h3 class="heading-07 text-gray-900">{{ __('upload_photos') }}</h3>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="lg:col-span-4 col-span-full">
                            <x-forms.flabel name="thumbnail" for="thumbnail"
                                :required="true" />
                            <p class="body-sm-400 text-gray-600 mb-2">
                                {{ __('image_must_be_in_jpg_jpeg_png_format') }} {{ __('recommended_size_750*450') }}
                            </p>
                            <div class="">

                            </div>
                            <input name="thumbnail" type="file"
                                accept="image/png, image/jpg, image/jpeg"
                                class="form-control dropify @error('thumbnail') is-invalid @enderror"
                                style="border:none;padding-left:0;"
                                accept="image/png,image/jpg,image/jpeg"
                                data-allowed-file-extensions='["jpg", "jpeg","png"]'
                                data-max-file-size="3M" data-show-errors="true" required/>
                            @error('thumbnail')
                                <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="lg:col-span-8 col-span-full">
                            <x-forms.flabel name="Gallery_Image" for="thumbnail"
                            :required="true" />
                            <p class="body-sm-400 text-gray-600 mb-2">
                                {{ __('you_must_upload_at_least') }} 2 to {{ $setting->maximum_ad_image_limit }}
                                {{ __('images') }}.{{ __('image_must_be_in_jpg_jpeg_png_format') }} {{ __('recommended_size_750*450') }}
                            </p>
                            <label for="file-input"
                                class="p-6 w-full cursor-zoom-in transition-all duration-300 hover:bg-gray-50 block shadow-[0px_1px_2px_0px_rgba(16,24,40,0.05)] rounded-lg border border-gray-100">
                                <div>
                                    <input type="file" accept="image/png, image/jpeg, image/jpg" class="filepond" name="images[]" multiple />
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="manufacture" class="tc-label">{{ __('video_url') }}</label>
                        <input type="url" id="manufacture" class="tc-input" placeholder="{{ __('enter_video_url') }}"
                            name="video_url" value="{{ old('video_url', $ad?->video_url ?? '') }}">
                    </div>
                </div>
                <div class="h-[1px] bg-gray-100"></div>
                <div class="grid sm:grid-cols-2 grid-cols-1 gap-4">

                    @foreach ($category->customFields as $field)
                        @if ($field->type == 'text')
                            <div>
                                <x-forms.flabel name="{{ $field->name }}" for="ad_{{ $field->slug }}"
                                    :required="$field->required" />
                                <input value="{{ old($field->name) }}" name="{{ $field->slug }}" type="text"
                                    id="ad_{{ $field->slug }}" class="tc-input" placeholder="{{ $field->name }}"
                                    @required($field->required)>

                                @error($field->slug)
                                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if ($field->type == 'select')
                            <div>
                                <x-forms.flabel name="{{ $field->name }}" for="ad_{{ $field->slug }}"
                                    :required="$field->required" />
                                <select name="{{ $field->slug }}" id="ad_{{ $field->slug }}" class="tc-input"
                                    @required($field->required)>
                                    @foreach ($field->values as $value)
                                        <option
                                            {{ (old(ucfirst($field->value)) == ucfirst($value->value) ? 'selected' : $value->id == 1) ? 'selected' : '' }}
                                            value="{{ $value->value }}">
                                            {{ ucfirst($value->value) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error($field->slug)
                                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if ($field->type == 'file')
                            <div>
                                <x-forms.flabel name="{{ $field->name }}" for="ad_{{ $field->slug }}"
                                    :required="$field->required" />
                                <input name="{{ $field->slug }}" type="file" class="w-full" id="ad_{{ $field->slug }}">

                                @error($field->slug)
                                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if ($field->type == 'textarea')
                            <div>
                                <x-forms.flabel name="{{ $field->name }}" for="ad_{{ $field->slug }}"
                                    :required="$field->required" />
                                <textarea name="{{ $field->slug }}" id="ad_{{ $field->slug }}" cols="12" rows="2" class="tc-input"
                                    placeholder="{{ $field->name }}">{{ old($field->slug) }}</textarea>

                                @error($field->slug)
                                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if ($field->type == 'radio')
                            <div>
                                <x-forms.flabel name="{{ $field->name }}" for="adl_{{ $field->slug }}"
                                    :required="$field->required" />
                                <div class="flex gap-3 flex-col md:flex-row flex-wrap md:items-center">
                                    @foreach ($field->values as $value)
                                        <div class="tc-radio">
                                            <input @checked(old(ucfirst($field->value)) == ucfirst($value->value)) value="{{ ucfirst($value->value) }}"
                                                type="radio" name="{{ $field->slug }}"
                                                id="ad_label_{{ $value->id }}">
                                            <label for="ad_label_{{ $value->id }}" class="min-w-max">
                                                {{ $value->value }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                @error($field->slug)
                                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if ($field->type == 'url')
                            <div>
                                <x-forms.flabel name="{{ $field->name }}" for="ad_{{ $field->slug }}"
                                    :required="$field->required" />
                                <input type="url" name="{{ $field->slug }}" id="ad_{{ $field->slug }}"
                                    class="tc-input" placeholder="{{ $field->name }}">

                                @error($field->slug)
                                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if ($field->type == 'number')
                            <div>
                                <x-forms.flabel name="{{ $field->name }}" for="adl_{{ $field->slug }}"
                                    :required="$field->required" />
                                <input min="1" type="number" name="{{ $field->slug }}"
                                    value="{{ old($field->slug) }}" id="adl_{{ $field->slug }}" class="tc-input"
                                    placeholder="{{ $field->name }}">

                                @error($field->slug)
                                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if ($field->type == 'date')
                            <div>
                                <x-forms.flabel name="{{ $field->name }}" for="adl_{{ $field->slug }}"
                                    :required="$field->required" />
                                <input type="date" name="{{ $field->slug }}" value="{{ old($field->slug) }}"
                                    placeholder="{{ $field->name }}" class="tc-input">

                                @error($field->slug)
                                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @php
                            $fieldId = 'cf.' . $field->id;
                            $fieldName = 'cf[' . $field->id . ']';
                            $fieldOld = 'cf.' . $field->id;
                            $defaultValue = isset($oldInput) && isset($oldInput[$field->id]) ? $oldInput[$field->id] : '';
                        @endphp

                        @if ($field->type == 'checkbox')
                            <div>
                                <x-forms.flabel name="{{ $field->name }}" for="adl_{{ $field->slug }}"
                                    :required="$field->required" />
                                <ul class="grid md:grid-cols-2 gap-3">
                                    @foreach ($field->values as $value)
                                        @if ($loop->first)
                                            <li class="tc-checkbox ">
                                                <input type="hidden" value="0" name="{{ $fieldName }}">
                                                <input @checked($defaultValue == '1') value="1" type="checkbox"
                                                    name="{{ $fieldName }}" id="{{ $fieldId }}">
                                                <label for="{{ $fieldId }}">{{ $value->value }}</label>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>

                                @error($field->slug)
                                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if ($field->type == 'checkbox_multiple')
                            <div>
                                <x-forms.flabel name="{{ $field->name }}" for="adl_{{ $field->slug }}"
                                    :required="$field->required" />
                                <ul class="grid md:grid-cols-2 gap-3">
                                    @foreach ($field->values as $value)
                                        <li class="tc-checkbox ">
                                            <input type="checkbox" name="{{ $fieldName . '[' . $value->id . ']' }}"
                                                id="{{ $fieldId . '.' . $value->id }}" value="{{ $value->id }}"
                                                @checked($defaultValue == $value->id)>
                                            <label for="{{ $fieldId . '.' . $value->id }}">
                                                {{ $value->value }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>

                                @error($field->slug)
                                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="h-[1px] bg-gray-100"></div>
                <div class="flex flex-col gap-y-4">
                    <h2 class="heading-07 text-gray-900">{{ __('feature') }}
                        <span class="text-red-600">*</span>
                    </h2>
                    <div>
                        <div class="dropdown-input__wrap gap-4 flex">
                            <div class="flex-grow flex rounded-lg mb-4">
                                <input @required(!$features && count($features) == 0) type="text" class="tc-input"
                                    placeholder="{{ __('feature') }}" name="features[]">
                            </div>
                        </div>
                        <div x-data="dynamicInput">
                            <template x-for="(field, index) in fields" :key="index">
                                <div class="dropdown-input__wrap gap-4 flex" :id="`'wrap_${index}'`">
                                    <div class="flex-grow flex rounded-lg mb-4">
                                        <input @required(!$features && count($features) == 0) type="text" class="tc-input"
                                            placeholder="{{ __('feature') }}" name="features[]"
                                            x-model='field.textContent'>
                                    </div>
                                    <div x-show="fields?.length" x-cloak>
                                        <button type="button" @click="removeField(index)"
                                            class="btn-remove h-[44px] w-[44px] text-white rounded-lg inline-flex justify-center items-center bg-error-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            @if ($features && count($features))
                                @foreach ($features as $key => $feature)
                                    @if ($feature)
                                        <div class="dropdown-input__wrap gap-4 flex" id="feature_{{ $key }}">
                                            <div class="flex-grow flex rounded-lg mb-4">
                                                <input required type="text" id="manufacture" class="tc-input"
                                                    placeholder="{{ __('feature') }}" name="features[]"
                                                    value="{{ $feature }}">
                                            </div>
                                            <div>
                                                <button type="button" onclick="removeElement({{ $key }})"
                                                    class="btn-remove h-[44px] w-[44px] text-white rounded-lg inline-flex justify-center items-center bg-error-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <div>
                                <button type="button" @click="addNewField()"
                                    class="btn-primary w-full">{{ __('add_new') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="post-footer">

            <input type="submit" name="draft" class="btn-secondary cursor-pointer py-3 px-5" value="{{ __('save_on_draft') }}"/>

                <div>
                    <a href="{{ route('frontend.post.step1.back') }}"
                        onclick="return confirm('{{ __('are_you_sure_to_go_back') }}')"
                        class="py-3 px-5">{{ __('back') }}</a>
                    <button type="submit" class="btn-primary py-3 px-5">{{ __('save_and_next') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('backend') }}/css/dropify.min.css" />
    <style>
        .filepond--list li {
            width: 100px !important;
            height: 100px !important;
        }
    </style>
@endpush

@push('css')
<style>
    .dropify-wrapper {
        border-radius: 8px !important;
        border-width: 1px !important;
    }
</style>
@endpush

@push('js')
    @vite('resources/frontend/js/filepond.js')
    <script src="{{ asset('backend') }}/js/dropify.min.js"></script>
    <script defer>
        // dropify
        var drEvent = $('.dropify').dropify();

        drEvent.on('dropify.error.fileSize', function(event, element) {
            alert('Filesize error message!');
        });
        drEvent.on('dropify.error.imageFormat', function(event, element) {
            alert('Image format error message!');
        });

        document.addEventListener('DOMContentLoaded', () => {
            const inputElement = document.querySelector('.filepond');
            console.log(inputElement);
            // Create a FilePond instance
            const pond = filepond.create(inputElement, {
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
                maxFileSize: '5MB',
                maxFiles: "{{ $setting->maximum_ad_image_limit }}",
                storeAsFile: true,
                allowMultiple: true,
                credits: false,
                labelIdle: `Drag & Drop Images or <span class="filepond--label-action">Browse</span>`,
            });
        });

        function removeElement(id) {
            console.log({
                id
            });
            const element = document.getElementById(`feature_${id}`);
            element.remove();
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('dynamicInput', () => ({
                fields: [],
                addNewField() {
                    this.fields.push({
                        textContent: '',
                    });
                },
                removeField(index) {
                    this.fields.splice(index, 1);
                }
            }))
        })
    </script>
@endpush
