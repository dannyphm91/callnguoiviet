@extends('admin.settings.pages.general.layout')

@section('general-setting')
    <div class="alert alert-warning mb-3">
        "{{ __('featured_ad_limit') }}"! {{ __('discover_how_many_featured_ads_will_be_displayed_in_home_page') }}.
        <hr>
        "{{ __('latest_ad_limit') }}"! {{ __('discover_how_many_latest_ads_will_be_displayed_in_home_page') }}.
    </div>
    <div class="card">
        <form action="{{ route('settings.general.app.config.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <h6>{{ __('app_configuration') }}</h6>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <x-forms.label name="{{ __('timezone') }}" />
                            <select name="timezone"
                                class="select2bs4 @error('timezone') is-invalid @enderror timezone-select form-control">
                                @foreach ($timezones as $timezone)
                                    <option {{ config('app.timezone') == $timezone->value ? 'selected' : '' }}
                                        value="{{ $timezone->value }}">
                                        {{ $timezone->value }}
                                    </option>
                                @endforeach
                                @error('timezone')
                                    <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                @enderror
                            </select>
                        </div>
                        <div class="form-group">
                            <x-forms.label name="{{ __('set_default_language') }}" />
                            <select class="select2bs4 form-control @error('code') is-invalid @enderror" name="code"
                                id="default_language">
                                @foreach ($languages as $language)
                                    <option {{ $language->code == config('templatecookie.default_language') ? 'selected' : '' }}
                                        value="{{ $language->code }}">
                                        {{ $language->name }}({{ $language->code }})
                                    </option>
                                @endforeach
                                @error('code')
                                    <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                @enderror
                            </select>
                        </div>
                        <div class="form-group">
                            <x-forms.label name="{{ __('set_default_currency') }}" for="inlineFormCustomSelect" />
                            <select name="currency" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                <option value="" disabled selected>{{ __('Currency') }}
                                </option>
                                @foreach ($currencies as $key => $currency)
                                    <option {{ config('templatecookie.currency') == $currency->code ? 'selected' : '' }}
                                        value="{{ $currency->id }}">
                                        {{ $currency->name }} ( {{ $currency->code }} )
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <x-forms.label name="maximum_ad_image_limit" required="true" />
                            <x-forms.input type="number" name="maximum_ad_image_limit"
                                value="{{ $setting->maximum_ad_image_limit }}"
                                placeholder="{{ __('maximum_ad_image_limit') }}" />
                        </div>
                        <div class="form-group">
                            <x-forms.label name="featured_ad_limit" required="true" />
                            <input type="number" value="{{ $setting->featured_ad_limit }}"
                                placeholder="{{ __('featured_ad_limit') }}"
                                class="form-control @error('featured_ad_limit') is-invalid @enderror" step="any"
                                name="featured_ad_limit" id="featured_ad_limit">
                            @error('featured_ad_limit')
                                <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <x-forms.label name="latest_ad_limit" required="true" />
                            <input type="number" value="{{ $setting->latest_ad_limit }}"
                                placeholder="{{ __('latest_ad_limit') }}"
                                class="form-control @error('latest_ad_limit') is-invalid @enderror" step="any"
                                name="latest_ad_limit" id="latest_ad_limit">
                            @error('latest_ad_limit')
                                <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <x-forms.label name="{{ __('app_debug') }}" />
                            <div>
                                <input type="hidden" name="app_debug" value="0" />
                                <input type="checkbox" id="app_debug" {{ env('APP_DEBUG') ? 'checked' : '' }}
                                    name="app_debug" data-bootstrap-switch data-on-color="success"
                                    data-on-text="{{ __('on') }}" data-off-color="default"
                                    data-off-text="{{ __('off') }}" data-size="small" value="1">
                                <x-forms.error name="app_debug" />
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <x-forms.label name="map_visibility" required="true" class="d-block" />
                                <input type="hidden" name="map_show" value="0" />
                                <input type="checkbox" id="map_show" {{config('templatecookie.map_show') ? 'checked' : '' }}
                                    name="map_show" data-bootstrap-switch data-on-color="success"
                                    data-on-text="{{ __('show') }}" data-off-color="default"
                                    data-off-text="{{ __('hide') }}" data-size="small" value="1">
                        </div>
                        <div class="form-group mt-4">
                            <x-forms.label name="{{ __('frontend_language_switcher') }}" :required="true" />
                            <div>
                                <input type="hidden" name="language_changing" value="0" />
                                <input type="checkbox" id="language_changing"
                                    {{ $setting->language_changing ? 'checked' : '' }} name="language_changing"
                                    data-on-color="success" data-bootstrap-switch data-on-text="{{ __('show') }}"
                                    data-off-color="default" data-off-text="{{ __('hide') }}" data-size="small"
                                    value="1">
                                <x-forms.error name="language_changing" />
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <x-forms.label name="{{ __('frontend_currency_switcher') }}" :required="true" />
                            <div>
                                <input type="hidden" name="currency_changing" value="0" />
                                <input type="checkbox" id="currency_changing"
                                    {{ $setting->currency_changing ? 'checked' : '' }} name="currency_changing"
                                    data-on-color="success" data-bootstrap-switch data-on-text="{{ __('show') }}"
                                    data-off-color="default" data-off-text="{{ __('hide') }}" data-size="small"
                                    value="1">
                                <x-forms.error name="currency_changing" />
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <x-forms.label name="{{ __('customer_email_verification') }}" :required="true" />
                            <div>
                                <input type="hidden" name="customer_email_verification" value="0" />
                                <input type="checkbox" id="customer_email_verification"
                                    name="customer_email_verification"
                                    {{ $setting->customer_email_verification ? 'checked' : '' }} data-on-color="success"
                                    data-bootstrap-switch data-on-text="{{ __('on') }}" data-off-color="default"
                                    data-off-text="{{ __('off') }}" data-size="small" value="1">
                                <x-forms.error name="customer_email_verification" />
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <x-forms.label name="website_loader" required="true" class="d-block" />
                            <input type="checkbox" name="website_loader" {{ $setting->website_loader ? 'checked' : '' }}
                                data-bootstrap-switch value="1">
                        </div>
                        <div class="form-group mt-4">
                            <x-forms.label name="show_featured_ads_on_homepage" required="true" class="d-block" />
                            <input type="checkbox" name="featured_ads_homepage"
                                {{ $setting->featured_ads_homepage ? 'checked' : '' }} data-bootstrap-switch
                                value="1">
                        </div>
                        <div class="form-group mt-4">
                            <x-forms.label name="show_latest_ads_on_homepage" required="true" class="d-block" />
                            <input type="checkbox" name="regular_ads_homepage"
                                {{ $setting->regular_ads_homepage ? 'checked' : '' }} data-bootstrap-switch
                                value="1">
                        </div>
                        <div class="form-group mt-4">
                            <x-forms.label name="ads_admin_approval" required="true" class="d-block" />
                            <input type="checkbox" name="ads_admin_approval"
                                {{ $setting->ads_admin_approval ? 'checked' : '' }} data-bootstrap-switch value="1">
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
