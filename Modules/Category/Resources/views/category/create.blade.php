@extends('admin.layouts.app')

@section('title')
    {{ __('add_category') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('add_category') }}</h3>
                        <a href="{{ route('module.category.index') }}"
                            class="btn bg-primary float-right d-flex align-items-center justify-content-center"><i
                                class="fas fa-arrow-left"></i>&nbsp; {{ __('back') }}</a>
                    </div>
                    <div class="row pt-3 pb-4">
                        <div class="col-md-6 offset-md-3">
                            <form class="form-horizontal" action="{{ route('module.category.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @foreach ($locales as $locale)
                                    <div class="form-group row">
                                        @if ($locale->code == 'en')
                                        <x-forms.label name="{{ __('category_name') }} ({{$locale->name}})"  required="true"
                                            class="col-sm-3 col-form-label" />
                                        @else
                                        <x-forms.label name="{{ __('category_name') }} ({{$locale->name}})"  required="false"
                                            class="col-sm-3 col-form-label" />
                                        @endif
                                        <div class="col-sm-9">
                                            <input value="{{ old('name.' . $locale->code) }}" name="name[{{ $locale->code }}]"
                                                type="text"
                                                class="form-control @error('name.' . $locale->code) is-invalid @enderror"
                                                placeholder="{{ __('enter_category_name') }} ({{ $locale->name }})">
                                            @if ($locale->code == 'en')
                                                @error('name.' . $locale->code)
                                                    <span class="invalid-feedback" role="alert"><strong>English category name
                                                            is required</strong></span>
                                                @enderror
                                            @else
                                                @error('name.' . $locale->code)
                                                    <span class="invalid-feedback"
                                                        role="alert"><strong>{{ $message }}</strong></span>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                <div class="form-group row">
                                    <x-forms.label name="image" required="true" class="col-sm-3 col-form-label" />
                                    <div class="col-sm-9">
                                        <input name="image" type="file" accept="image/png, image/jpg, image/jpeg"
                                            class="form-control dropify @error('image') is-invalid @enderror"
                                            style="border:none;padding-left:0;" data-max-file-size="3M"
                                            data-show-errors="true" data-allowed-file-extensions='["jpg", "jpeg","png"]'>
                                        @error('image')
                                            <span class="invalid-feedback d-block"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <x-forms.label name="icon" required="true" class="col-sm-3 col-form-label" />
                                    <div class="col-sm-9">
                                        <input type="hidden" name="icon" id="icon" value="{{ old('icon') }}" />
                                        <div id="target"></div>
                                        @error('icon')
                                            <span class="invalid-feedback d-block"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-4">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-plus"></i>&nbsp; {{ __('create') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <!-- Bootstrap-Iconpicker -->
    <link rel="stylesheet"
        href="{{ asset('backend') }}/plugins/bootstrap-iconpicker/dist/css/bootstrap-iconpicker.min.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/css/dropify.min.css" />
@endsection

@section('script')
    <!-- Bootstrap-Iconpicker Bundle -->
    <script type="text/javascript"
        src="{{ asset('backend') }}/plugins/bootstrap-iconpicker/dist/js/bootstrap-iconpicker.bundle.min.js"></script>
    <script type="text/javascript"
        src="{{ asset('backend') }}/plugins/bootstrap-iconpicker/dist/js/bootstrap-iconpicker.min.js"></script>
    <script src="{{ asset('backend') }}/js/dropify.min.js"></script>

    <script>
        $('#target').iconpicker({
            align: 'left', // Only in div tag
            arrowClass: 'btn-danger',
            arrowPrevIconClass: 'fas fa-angle-left',
            arrowNextIconClass: 'fas fa-angle-right',
            cols: 15,
            footer: true,
            header: true,
            icon: 'fas fa-bomb',
            iconset: 'fontawesome5',
            labelHeader: '{0} of {1} pages',
            labelFooter: '{0} - {1} of {2} icons',
            placement: 'bottom', // Only in button tag
            rows: 5,
            search: true,
            searchText: 'Search',
            selectedClass: 'btn-success',
            unselectedClass: ''
        });

        $('#target').on('change', function(e) {
            $('#icon').val(e.icon)
        });

        // dropify
        var drEvent = $('.dropify').dropify();

        drEvent.on('dropify.error.fileSize', function(event, element) {
            alert('Filesize error message!');
        });
        drEvent.on('dropify.error.imageFormat', function(event, element) {
            alert('Image format error message!');
        });
    </script>
@endsection
