@extends('frontend.postad_edit.index')

@section('title', __('step1'))

@section('post-ad-content')
    <div>

        <form action="{{ route('frontend.post.update', $ad->slug) }}" method="POST" id="step_edit_form">
            @csrf
            @method('PUT')
            <div class="sm:p-8 p-4 flex flex-col gap-8">

                {{-- Category Subcategory Choose Start --}}
                @livewire('category-subcategory-component', ['category_id' => $ad?->category_id, 'subcategory_id' => $ad?->subcategory_id])
                @error('category_id')
                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
                @error('subcategory_id')
                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
                {{-- Category Subcategory Choose End --}}
                <div class="h-[1px] bg-gray-100"></div>

                <div class="flex flex-col gap-4">
                    <div class="app-select">
                        <x-forms.flabel name="brand" for="brand" :required="true" />
                        <select required name="brand_id" id="brand"
                            class="tc-input @error('brand_id') focus:border-red-500 hover:border-red-500 border-red-500 @enderror">
                            <option value="">{{ __('select_brand') }}</option>
                            @foreach ($brands as $brand)
                                <option @selected($ad?->brand_id ?? '' == $brand->id) value="{{ $brand->id }}">{{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- <div>
                        <x-forms.flabel name="promote_ad" for="promote_ad" />
                        <li class="tc-checkbox ">
                            <input name="featured" type="hidden" value="0">
                            <input @checked($ad?->featured == 1) type="checkbox" name="featured" id="featured"
                                value="1">
                            <label for="featured">{{ __('featured') }}</label>
                        </li>
                    </div> --}}
                </div>
                <div class="h-[1px] bg-gray-100"></div>
                <div class="flex flex-col gap-4">
                    <div>
                        <x-forms.flabel name="title" for="ad_title" :required="true" />
                        <input type="text" placeholder="{{ __('title') }}"
                            class="tc-input  @error('title') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                            name="title" value="{{ old('title', $ad?->title) }}">
                        @error('title')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <div class="flex justify-between items-center">
                            <x-forms.flabel name="price" for="price" :required="true">
                                ({{ config('templatecookie.currency_symbol') }})
                            </x-forms.flabel>
                        </div>
                        <input required type="text" placeholder="{{ __('price') }}"
                            class="tc-input  @error('price') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                            name="price" value="{{ old('price', $ad?->price) }}">
                        @error('price')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-forms.flabel name="description" for="description" :required="true" />
                        <textarea name="description" id="description" cols="30" rows="4"
                            class="tc-input  @error('description') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                            placeholder="{{ __('write_description_of_ad') }}">{{ old('description', $ad->description) }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="h-[1px] bg-gray-100"></div>
                <div class="col-md-12 input-field__group">
                    <div class=" w-100 mb-3">
                        <x-forms.label name="location" required="true" />
                        @if (config('templatecookie.map_show'))
                            <span data-toggle="tooltip" title="Drag the pointer Or click your location"
                                data-original-title="Drag the pointer Or click your location">
                                <x-svg.exclamation />
                            </span>
                        @endif
                        @php
                            $map = setting('default_map');
                            session([
                                'selectedCountryId' => null,
                                'selectedStateId' => null,
                                'selectedCityId' => null,
                            ]);
                            session([
                                'selectedCountryId' => $ad->country,
                                'selectedStateId' => $ad->region,
                                'selectedCityId' => $ad->district,
                            ]);
                        @endphp
                        @if (config('templatecookie.map_show'))
                            @if ($map == 'map-box')
                                <div class="map mymap" id='map-box'></div>
                            @elseif ($map == 'google-map')
                                <div>
                                    <input id="searchInput" class="mapClass" type="text"
                                        placeholder="{{ __('enter_a_location') }}">
                                    <div class="map mymap" id="google-map"></div>
                                </div>
                            @elseif ($map == 'leaflet')
                                <div>
                                    <input type="text" autocomplete="off" id="leaflet_search"
                                        placeholder="{{ __('enter_city_name') }}" class="full-width form-control" />
                                    <br>
                                    <div id="leaflet-map"></div>
                                </div>
                            @endif
                            @error('location')
                                <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        @else
                            @livewire('country-state-city')
                        @endif
                    </div>
                </div>

            </div>
            <div class="post-footer">
                <input type="submit" name="draft" class="btn-secondary cursor-pointer py-3 px-5"
                    value="{{ __('save_on_draft') }}" />
                <div>
                    <a href="{{ route('frontend.post.cancel.edit') }}" type="button"
                        class="btn-danger py-3 px-5">{{ __('cancel_edit') }}</a>

                        @if ($ad->resubmission == true)
                        <button onclick="updateCancelEdit()" type="button"
                        class="btn-info py-3 px-5">{{ __('save_and_resubmit') }}</button>
                        @else
                        <button onclick="updateCancelEdit()" type="button"
                        class="btn-info py-3 px-5">{{ __('update_cancel_edit') }}</button>
                        @endif

                    <button type="submit" class="btn-primary py-3 px-5">{{ __('save_and_next') }}</button>
                </div>
            </div>

            <input type="hidden" id="cancel_edit_input" name="cancel_edit" value="0">
        </form>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/css/select2.min.css') }}">
@endpush

@push('js')
    <script defer src="{{ asset('backend/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend') }}/dist/js/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('backend') }}/dist/js/ckeditor/config.js"></script>
    <script>
        // Category wise subcategories dropdown
        $('#category').on('change', function() {
            var categoryID = $(this).val();
            console.log({
                categoryID
            })
            if (categoryID) {
                cat_wise_subcat(categoryID);
            }
        });

        var subct_id = document.getElementById('subct_id')?.value;

        $(document).ready(function() {
            var category_id = document.getElementById('category').value;
            cat_wise_subcat(category_id);
            $('#category').select2({
                placeholder: 'Select Category'
            });
            $('#subcategory').select2({
                placeholder: 'Select Subcategory'
            })
            $('#brand').select2({
                placeholder: 'Select Brand'
            })
        });

        // category wise subcategory function
        function cat_wise_subcat(categoryID) {
            axios.get('/get-sub-categories/' + categoryID).then((res => {
                if (res.data) {
                    console.log(res);

                    $('#subcategory').empty();
                    $.each(res.data, function(key, subcat) {

                        var matched = parseInt(subct_id) === subcat.id ? true : false

                        $('select[name="subcategory_id"]').append(
                            `<option ${matched ? 'selected':''} value="${subcat.id}">${subcat.name}</option>`
                        );
                    });
                } else {
                    $('#subcategory').empty();
                }
            }))
        }
    </script>
     {{-- ck-editor --}}
    <script>
         CKEDITOR.replace('description', {
             height: 200,
         });
    </script>
@endpush
