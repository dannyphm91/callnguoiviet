@extends('frontend.postad.index')

@section('title', __('step1'))

@section('post-ad-content')
    <div class="overflow-x-hidden" x-data="{ categoryModal: false }">
        <form action="{{ route('frontend.payper.ads.post.store') }}" method="POST">
            @csrf
            <div class="sm:p-8 p-4 flex flex-col gap-8">
                {{-- Category Subcategory Choose Start --}}
                @livewire('category-subcategory-component', ['category_id' => old('category_id'), 'subcategory_id' => old('subcategory_id')])
                @error('category_id')
                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
                @error('subcategory_id')
                    <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
                {{-- Category Subcategory Choose End --}}

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
                            <input @checked(old('featured') == 1) type="checkbox" name="featured" id="featured"
                                value="1">
                            <label for="featured">{{ __('featured') }}</label>
                        </li>
                    </div> --}}
                </div>
                <div class="h-[1px] bg-gray-100"></div>
                <div class="flex flex-col gap-4">
                    <div>
                        <x-forms.flabel name="title" for="ad_title" :required="true" />
                        <input required type="text" placeholder="{{ __('title') }}"
                            class="tc-input  @error('title') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                            name="title" value="{{ old('title', $ad?->title ?? '') }}">
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
                        <input required type="number" min="0" placeholder="{{ __('price') }}"
                            class="tc-input  @error('price') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                            name="price" value="{{ old('price', $ad?->price ?? '') }}">
                        @error('price')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <x-forms.flabel name="description" for="description" :required="true" />
                        <textarea required name="description" id="description" cols="30" rows="4"
                            class="tc-input  @error('description') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror"
                            placeholder="{{ __('write_description_of_ad') }}">{{ old('description', $ad?->description ?? '') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="h-[1px] bg-gray-100"></div>
                <div class="col-md-12 input-field__group">
                    <div class=" w-100 mb-3 space-y-2">
                        <div class=" flex items-center gap-2">
                            <x-forms.label name="location" required="true" />
                            @if (config('templatecookie.map_show'))
                                <span data-toggle="tooltip" title="Drag the pointer Or click your location"
                                    data-original-title="Drag the pointer Or click your location">
                                    <x-svg.exclamation />
                                </span>
                            @endif
                        </div>

                        @php
                            $map = setting('default_map');

                        @endphp

                        @if (config('templatecookie.map_show'))
                            @if ($map == 'map-box')
                                <div class="map mymap" id='map-box'></div>
                            @elseif ($map == 'google-map')
                                <div class="space-y-4">
                                    <input id="searchInput" class="mapClass" type="text"
                                        placeholder="{{ __('enter_a_location') }}">
                                    <div class="map mymap" id="google-map"></div>
                                </div>
                            @elseif ($map == 'leaflet')
                                <div class="space-y-4">
                                    <div class="auto-search-wrapper">
                                        <input id="leaflet_search" required type="text"
                                            placeholder="{{ __('Enter Location') }}" class="tc-input w-full"
                                            name="location" value="{{ request('location') }}" autocomplete="off">
                                    </div>

                                    <div id="leaflet-map">
                                    </div>
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
                <button type="submit" class="btn-primary py-3 px-5">{{ __('save_and_next') }}</button>
            </div>
        </form>
    </div>
@endsection

@push('css')
    <x-map.leaflet.map_links />
    <x-map.leaflet.autocomplete_links />

    <!-- >=>Mapbox<=< -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/mapbox/mapbox-gl-geocoder.css') }}" type="text/css">
    <link href="{{ asset('frontend/plugins/mapbox/mapbox-gl.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/intlTelInput/css/intlTelInput.min.css') }}">
    <style>
        .mymap {
            width: 100%;
            min-height: 300px;
            border-radius: 12px;
        }

        .p-half {
            padding: 1px;
        }

        .mapClass {
            border: 1px solid transparent;
            margin-top: 15px;
            border-radius: 4px 0 0 4px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 35px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #searchInput {
            font-family: 'Roboto';
            background-color: #fff;
            font-size: 16px;
            text-overflow: ellipsis;
            margin-left: 16px;
            font-weight: 400;
            width: 30%;
            padding: 0 11px 0 13px;
        }

        #searchInput:focus {
            border-color: #4d90fe;
        }

        .iti {
            width: 100% !important;
        }

        .iti__country-list {
            z-index: 9999 !important;
        }

        .swiper-button-disabled.choose-category-slider_prev,
        .swiper-button-disabled.choose-category-slider_next {
            background: var(--primary-200);
            cursor: not-allowed;
        }
    </style>
    <!-- >=>Mapbox<=< -->
    <link rel="stylesheet" href="{{ asset('backend/css/select2.min.css') }}">
@endpush

@push('js')

    <script defer src="{{ asset('backend/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script>
        // Category wise subcategories dropdown
        $('#category').on('change', function() {
            var categoryID = $(this).val();
            if (categoryID) {
                cat_wise_subcat(categoryID);
            }
            // display subcategory
            $('#subcategory').prop('disabled', false);
        });

        var subct_id = document.getElementById('subct_id')?.value;

        $(document).ready(function() {
            $('#category').prepend('<option value="" selected>{{ __('select_category') }}</option>');
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
                if (res.data && res.data.length > 0) {
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
                    $('select[name="subcategory_id"]').append('<option value="">No category found</option>');
                }
            }))
        }
    </script>

    @if ($map == 'map-box')
        <x-map.set-mapbox />
    @elseif ($map == 'google-map')
        <x-map.set-googlemap />
    @elseif ($map == 'leaflet')
        <x-map.leaflet.leafletmap />
    @endif
@endpush
