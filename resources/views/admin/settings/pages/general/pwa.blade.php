@extends('admin.settings.pages.general.layout')

@section('general-setting')
<div class="card">
    <form class="form-horizontal" action="{{ route('settings.general.pwa.update') }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="card-body">
            <h6>{{ __('pwa_settings') }}</h6>
            <hr>
                <div class="row">

                    <div class="col-sm-4 col-md-4 mb-3">
                        <x-forms.label name="{{ __('app_pwa_icon') }}" />
                        <input type="file" class="form-control dropify"
                            data-default-file="{{ $setting->app_pwa_icon_url }}" name="app_pwa_icon"
                            data-allowed-file-extensions='["jpg", "jpeg","png"]' accept="image/png, image/jpg, image/jpeg">

                            <p class="img-size-note text-danger mt-2">{{ __('app_pwa_icon_size_note')}}</p>

                    </div>

                    <div class="col-sm-4 col-md-4 mb-3">

                        <div class="form-group">
                            <x-forms.label name="{{ __('pwa_enable') }}" />
                            <div>
                                <input type="hidden" name="pwa_enable" value="0" />
                                <input type="checkbox" id="pwa_enable" {{ $setting->pwa_enable ? 'checked' : '' }}
                                    name="pwa_enable" data-bootstrap-switch data-on-color="success"
                                    data-on-text="{{ __('enable') }}" data-off-color="default"
                                    data-off-text="{{ __('disable') }}" data-size="small" value="1">
                                <x-forms.error name="pwa_enable" />
                            </div>
                        </div>

                    </div>
                </div>
        </div>
        @if (userCan('setting.update'))
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary w-25">
                    <i class="fas fa-sync"></i>
                    {{ __('update') }}
                </button>
            </div>
        @endif
    </form>
</div>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />

    <!-- For switch button -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <style>
        .custom-file-label::after {
            left: 0;
            right: auto;
            border-left-width: 0;
            border-right: inherit;
        }
    </style>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify();
    </script>

<!-- For switch button -->
<script src="{{ asset('backend') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script>
    $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script>
    $('.custom-file input').change(function(e) {
        var files = [];
        for (var i = 0; i < $(this)[0].files.length; i++) {
            files.push($(this)[0].files[i].name);
        }
        $(this).next('.custom-file-label').html(files.join(', '));
    });
</script>

@endsection
