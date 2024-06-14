@extends('admin.layouts.app')
@section('title')
    {{ __('create_listing') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('create_listing') }}</h3>
                        <a href="{{ route('module.ad.index') }}"
                            class="btn bg-primary float-right d-flex align-items-center justify-content-center"><i
                                class="fas fa-arrow-left"></i>&nbsp; {{ __('back') }}</a>
                    </div>
                </div>
                <div class="row pt-3 pb-4">
                    <div class="col-md-8">
                        <form id="form" class="form-horizontal" action="{{ route('module.ad.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="section pt-3" id="basic-info">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <x-forms.label name="title" required="true" />
                                                <input type="text" name="title"
                                                    class="form-control @error('title') is-invalid @enderror"
                                                    value="{{ old('title') }}" placeholder="{{ __('enter_ad_title') }}">
                                                @error('title')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <x-forms.label name="brand" required="true" />
                                                <select name="brand_id"
                                                    class="form-control @error('brand_id') is-invalid @enderror">
                                                    @foreach ($brands as $brand)
                                                        <option {{ old('brand_id') == $brand->id ? 'selected' : '' }}
                                                            value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('brand_id')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section pt-3" id="product-image">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <x-forms.label name="upload_thumbnail" required="true" />
                                                <input name="thumbnail" type="file"
                                                    accept="image/png, image/jpg, image/jpeg, image/webp"
                                                    class="form-control dropify @error('thumbnail') is-invalid @enderror"
                                                    style="border:none;padding-left:0;"
                                                    accept="image/png,image/jpg,image/jpeg"
                                                    data-allowed-file-extensions='["jpg", "jpeg","png"]'
                                                    data-max-file-size="3M" data-show-errors="true" />
                                                @error('thumbnail')
                                                    <span
                                                        class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section pt-3" id="author-price">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <x-forms.label name="author" required="true" />
                                                <select name="user_id"
                                                    class="form-control @error('user_id') is-invalid @enderror">
                                                    @foreach ($customers as $customer)
                                                        <option {{ old('user_id') == $customer->id ? 'selected' : '' }}
                                                            value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('user_id')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <x-forms.label name="price" required="true">
                                                    ({{ config('templatecookie.currency_symbol') }})
                                                </x-forms.label>
                                                <input type="number" name="price"
                                                    class="form-control @error('price') is-invalid @enderror"
                                                    value="{{ old('price') }}" placeholder="{{ __('enter_ad_price') }}">
                                                @error('price')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section pt-3" id="category">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <x-forms.label name="select_category" required="true" />
                                                <select name="category_id" id="ad_category"
                                                    class="form-control @error('category_id') border-danger @enderror">
                                                    @foreach ($categories as $cat)
                                                        <option @selected(old('category_id') == $cat->id) value="{{ $cat->id }}">
                                                            {{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <x-forms.label name="select_subcategory" required="true" />
                                                <select name="subcategory_id" id="ad_subcategory"
                                                    class="form-control @error('subcategory_id') border-danger @enderror"></select>
                                                @error('subcategory_id')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section pt-3" id="feature">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-field--textarea">
                                                    <x-forms.label name="features" for="feature" />
                                                    <div id="multiple_feature_part">
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <div class="input-field mb-3">
                                                                    <input name="features[]" type="text"
                                                                        placeholder="{{ __('feature') }}" id="adname"
                                                                        class="form-control @error('features') border-danger @enderror" />
                                                                </div>
                                                            </div>
                                                            <div class="col-2 mt-10">
                                                                <a role="button" onclick="add_features_field()"
                                                                    class="btn bg-primary btn-sm text-light">
                                                                    <i class="fas fa-plus"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="icheck-success d-inline" data-toggle="tooltip"
                                                    data-original-title="{{ __('show_featured_ads_on_homepage') }} ">
                                                    <input {{ old('featured') == 1 ? 'checked' : '' }} value="1"
                                                        name="featured" type="checkbox" class="form-check-input"
                                                        id="featured" />
                                                    <x-forms.label name="featured" class="form-check-label"
                                                        for="featured" :required="false" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section pt-3" id="contact-info">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <input type="hidden" name="show_phone" id="show_phone" value="1">
                                                <label for="phone_number">{{ __('phone_number') }}
                                                    <span>(
                                                        <input type="checkbox" name="show_phone" id="show_phone_number"
                                                            value="0"> <label
                                                            for="show_phone_number">{{ __('hide_in_details') }}</label>
                                                        )</span>
                                                </label>
                                                <input type="tel" id="phone" name="phone"
                                                    class="phone-input form-control @error('phone') is-invalid @enderror"
                                                    value="{{ old('phone') }}"
                                                    placeholder="{{ __('enter_customer_phone_number') }}">
                                                @error('phone')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div>
                                                    <label for="whatsapp_profile_url"
                                                        class="p-1">{{ __('whatsapp_number') }}
                                                        (<a href="https://faq.whatsapp.com/iphone/how-to-link-to-whatsapp-from-a-different-app/?lang=en"
                                                            target="_blank">{{ __('get_help') }}</a>)
                                                    </label>
                                                </div>
                                                <div class="w-100">
                                                    <input type="tel" name="whatsapp"
                                                        class="phone-input form-control @error('whatsapp') is-invalid @enderror"
                                                        value="{{ old('whatsapp') }}" placeholder="E.g: 01681******"
                                                        id="whatsapp_profile_url">
                                                </div>
                                                <div>
                                                    @error('whatsapp')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="section pt-3" id="location">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <x-forms.label name="location" required="true" />
                                                <span data-toggle="tooltip" title=""
                                                    data-original-title="{{ __('drag_the_pointer_or_find_your_location') }} ">
                                                    <x-svg.exclamation />
                                                </span>
                                                @php
                                                    $map = setting('default_map');
                                                @endphp
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
                                                            placeholder="{{ __('enter_city_name') }}"
                                                            class="full-width form-control" /> <br>
                                                        <div id="leaflet-map"></div>
                                                    </div>
                                                @endif
                                                @error('location')
                                                    <span class="text-md text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <x-forms.label name="location" required="true" />
                                        <span data-toggle="tooltip" title=""
                                            data-original-title="{{ __('drag_the_pointer_or_find_your_location') }} ">
                                            <x-svg.exclamation />
                                        </span>
                                        @php
                                            $map = setting('default_map');
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
                                                        placeholder="{{ __('enter_city_name') }}"
                                                        class="full-width form-control" /> <br>
                                                    <div id="leaflet-map"></div>
                                                </div>
                                            @endif
                                            @error('location')
                                                <span class="text-md text-danger">{{ $message }}</span>
                                            @enderror
                                        @else
                                            @livewire('country-state-city')
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <x-forms.label name="description" required="true" />
                                        <textarea id="editor2" name="description" class="form-control @error('description') is-invalid @enderror"
                                            placeholder="{{ __('write_description_of_ad') }}">
                                            {{ old('description') }}
                                        </textarea>

                                        @error('description')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="section pt-3" id="video_url">
                    <div class="input-field--textarea">
                        <x-forms.label name="video_url" for="video_url" />
                        <div id="multiple_feature_part">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-field mb-3">
                                        <input name="video_url" type="url" placeholder="{{ __('enter_video_url') }}"
                                            id="video_url"
                                            class="form-control @error('video_url') border-danger @enderror" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus"></i>&nbsp;
                            {{ __('create') }}
                        </button>
                    </div>
                </div>
                </form>
            </div>
            <div class="col-md-4 pt-3">
                <div class="card tc-sticky-sidebar">
                    <div class="card-body">
                        <h5 class="mb-4">Product Information</h5>
                        <div class="tc-vertical-step">
                            <ul class="list-unstyled">
                                <li>
                                    <a href="#basic-info" class="step-menu active">Basic Information</a>
                                </li>
                                <li>
                                    <a href="#product-image" class="step-menu">Product Images</a>
                                </li>
                                <li>
                                    <a href="#author-price" class="step-menu">Author & Price</a>
                                </li>
                                <li>
                                    <a href="#category" class="step-menu">Category</a>
                                </li>
                                <li>
                                    <a href="#feature" class="step-menu">Feature</a>
                                </li>
                                <li>
                                    <a href="#contact-info" class="step-menu">Contact Info</a>
                                </li>
                                <li>
                                    <a href="#location" class="step-menu">Location</a>
                                </li>
                                <li>
                                    <a href="#description" class="step-menu">Description</a>
                                </li>
                                <li>
                                    <a href="#video_url" class="step-menu">Video URL</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    @if (old('subcategory_id'))
        <input type="hidden" id="subct_id" value="{{ old('subcategory_id') }}">
    @else
        <input type="hidden" id="subct_id" value="">
    @endif
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('frontend/css') }}/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/css/dropify.min.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/plugins/intlTelInput/css/intlTelInput.min.css') }}">
    <!-- >=>Leaflet Map<=< -->
    <x-map.leaflet.map_links />
    <x-map.leaflet.autocomplete_links />

    <!-- >=>Mapbox<=< -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/mapbox/mapbox-gl-geocoder.css') }}" type="text/css">
    <link href="{{ asset('frontend/plugins/mapbox/mapbox-gl.css') }}" rel="stylesheet">
    <style>
        .dropify-wrapper {
            height: 210px !important;
        }

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

        .tc-vertical-step,
        .tc-vertical-step-link {
            position: relative;
        }

        .tc-vertical-step ul:before,
        .tc-vertical-step-link ul:before {
            content: "";
            position: absolute;
            left: 5px;
            top: 10px;
            width: 2px;
            height: 100%;
            background: #dfe3e8;
        }

        .tc-vertical-step ul li:not(:last-child),
        .tc-vertical-step-link ul li:not(:last-child) {
            padding-bottom: 1rem;
        }

        .tc-vertical-step ul li a,
        .tc-vertical-step-link ul li a {
            position: relative;
            display: block;
            color: #454f5b;
            padding-left: 26px;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        .tc-vertical-step ul li a:before,
        .tc-vertical-step-link ul li a:before {
            content: "";
            position: absolute;
            left: 1px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            width: 10px;
            height: 10px;
            background: #dfe3e8;
            border-radius: 50%;
            z-index: 2;
        }

        .tc-vertical-step ul li a:after,
        .tc-vertical-step-link ul li a:after {
            content: "";
            position: absolute;
            left: -3px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 1px solid var(--main-color);
            z-index: 1;
            opacity: 0;
        }

        .step-menu.active:before,
        .step-menu.active:before {
            background-color: var(--main-color) !important;
        }

        .step-menu.active:after,
        .step-menu.active:after {
            opacity: 1;
        }

        .tc-sticky-sidebar {
            position: sticky;
            top: 1rem;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
            z-index: 8;
        }
    </style>
    <!-- >=>Mapbox<=< -->
@endsection

@section('script')
    @livewireScripts
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        window.addEventListener('render-select2', event => {
            console.log('fired');
            $('.select2').select2();
        })
    </script>
    @stack('js')
    <script src="{{ asset('backend') }}/js/dropify.min.js"></script>
    <script src="{{ asset('frontend') }}/js/axios.min.js"></script>
    <script src="{{ asset('backend') }}/dist/js/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('backend') }}/dist/js/ckeditor/config.js"></script>
    <script src="{{ asset('frontend/plugins/intlTelInput/js/intlTelInput.min.js') }}"></script>
    <script>
        const stepMenus = document.querySelectorAll('.step-menu');
        const sections = document.querySelectorAll('.section');


        function isElementInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
            );
        }

        function updateActiveStepMenuItem() {
            let activeSection = null;

            for (let i = 0; i < sections.length; i++) {
                if (isElementInViewport(sections[i])) {
                    activeSection = sections[i];
                    break;
                }
            }

            stepMenus.forEach(menu => menu.classList.remove('active'));

            if (activeSection) {
                const targetId = activeSection.id;
                const activeMenuItem = document.querySelector(`.step-menu[href="#${targetId}"]`);
                if (activeMenuItem) {
                    activeMenuItem.classList.add('active');
                }
            }
        }

        function handleStepMenuItemClick(event) {
            event.preventDefault();

            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }

        stepMenus.forEach(menuItem => {
            menuItem.addEventListener('click', handleStepMenuItemClick);
        });

        window.addEventListener('scroll', updateActiveStepMenuItem);

        updateActiveStepMenuItem();
    </script>
    {{-- ck-editor --}}
    <script>
        CKEDITOR.replace('editor2', {
            height: 200,
        });
    </script>

    {{-- category-subcategory dropdown --}}
    <script>
        var subct_id = document.getElementById('subct_id').value;

        $(document).ready(function() {
            var category_id = document.getElementById('ad_category').value;
            cat_wise_subcat(category_id);
        });

        // phone number code assign
        var phone = document.querySelector("#phone");
        var whatsapp_profile_url = document.querySelector("#whatsapp_profile_url");

        window.intlTelInput(phone);
        window.intlTelInput(whatsapp_profile_url);

        var form = document.querySelector("#form");
        // get country code and push into phone number
        form.addEventListener("submit", function(event) {
            getCode('#phone');
            getCode('#whatsapp_profile_url');
        });

        function getCode(id_value) {
            var id = document.querySelector(id_value);
            let getInstance = window.intlTelInputGlobals.getInstance(id);
            let dialCode = getInstance.getSelectedCountryData().dialCode;
            let value = $(id).val();
            $(id).val(dialCode + value);
        }

        // category wise subcategory function
        function cat_wise_subcat(categoryID) {
            axios.get('/get_subcategory/' + categoryID).then((res => {
                // console.log(res);
                if (res.data) {
                    $('#ad_subcategory').empty();
                    $.each(res.data, function(key, subcat) {

                        var matched = parseInt(subct_id) === subcat.id ? true : false

                        $('select[name="subcategory_id"]').append(
                            `<option ${matched ? 'selected':''} value="${subcat.id}">${subcat.name}</option>`
                        );
                    });
                } else {
                    $('#ad_subcategory').empty();
                }
            }))
        }

        // Category wise subcategories dropdown
        $('#ad_category').on('change', function() {
            var categoryID = $(this).val();
            if (categoryID) {
                cat_wise_subcat(categoryID);
            }
        });
    </script>

    {{-- Featured inputs --}}
    <script>
        function add_features_field() {
            $("#multiple_feature_part").append(`
            <div class="row">
                <div class="col-lg-10">
                    <div class="input-field mb-3">
                        <input name="features[]" type="text" placeholder="Feature" id="adname" class="form-control @error('features') border-danger @enderror"/>
                        </div>
                        </div>
                    <div class="col-lg-2 mt-10">
                        <button onclick="remove_single_field()" id="remove_item" class="btn btn-sm bg-danger text-light"><i class="fas fa-times"></i></button>
                    </div>
                    </div>
                    `);
        }

        $(document).on("click", "#remove_item", function() {
            $(this).parent().parent('div').remove();
        });
    </script>

    {{-- Dropify image upload --}}
    <script>
        var drEvent = $('.dropify').dropify();

        drEvent.on('dropify.error.fileSize', function(event, element) {
            alert('Filesize error message!');
        });
        drEvent.on('dropify.error.imageFormat', function(event, element) {
            alert('Image format error message!');
        });
    </script>

    <!--=============== maps ===============-->
    @if ($map == 'map-box')
        <x-map.set-mapbox />
    @elseif ($map == 'google-map')
        <x-map.set-googlemap />
    @elseif ($map == 'leaflet')
        <x-map.leaflet.leafletmap />
    @endif
    <!--=============== maps ===============-->
@endsection
