@extends('admin.settings.setting-layout')
@section('title')
    {{ __('social_login_setting') }}
@endsection

@section('website-settings')
    <div class="alert alert-warning mb-3">
        <h5>
            {{ __('enable_social_media_login_to_your_website') }}
        </h5>
        <hr class="my-2">
        {{ __('65_of_users_prefer_social_logins_but_60_believe_that_companies_offering_social_logging_are_more_up_to_date_and_innovative_not_only_do_they_benefit_the_user_they_benefit_your_brand_logic_and_these_statistics_dictate_that_social_login_is_a_no_brainer') }}
    </div>
    <div class="row">
        <div class="col-sm-6">
            {{-- Google Login Credential Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('google_login_credential') }}</h3>
                        <div class="form-group row">
                            <input {{ config('services.google.active') ? 'checked' : '' }} type="checkbox" name="google"
                                data-bootstrap-switch value="1">
                        </div>
                    </div>
                </div>
                @if (config('services.google.active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.social.login.update') }}" method="POST"
                            id="google-social-form">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="google" name="type">
                            <input type="hidden" value="{{ config('services.google.active') }}" name="status">
                            <div class="form-group row">
                                <x-forms.label name="Google Client Id" class="col-sm-5" />
                                <div class="col-sm-7">
                                    <input
                                        onkeyup="ButtonDisabled('buttonOne', 'google_client_id' , '{{ config('services.google.client_id') }}')"
                                        value="{{ config('services.google.client_id') }}" name="google_client_id" type="text"
                                        class="form-control @error('google_client_id') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('google_client_id')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="Google Client Secret" class="col-sm-5" />
                                <div class="col-sm-7">
                                    <input
                                        onkeyup="ButtonDisabled('buttonOne', 'google_client_secret' , '{{ config('services.google.client_secret') }}')"
                                        value="{{ config('services.google.client_secret') }}" name="google_client_secret"
                                        type="text"
                                        class="form-control @error('google_client_secret') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('google_client_secret')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-5 col-sm-7">
                                        <button id="buttonOne" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('Update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif
            </div>

            {{-- Facebook Login Credential Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('facebook_login_credential') }}</h3>
                        <div class="form-group row">
                            <input {{ config('services.facebook.active') ? 'checked' : '' }} type="checkbox" name="facebook"
                                data-bootstrap-switch value="1">
                        </div>
                    </div>
                </div>
                @if (config('services.facebook.active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.social.login.update') }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="facebook" name="type">
                            <div class="form-group row">
                                <x-forms.label name="Facebook Client Id" class="col-sm-5" />
                                <div class="col-sm-7">
                                    <input
                                        onkeyup="ButtonDisabled('buttonTwo', 'facebook_client_id' , '{{ config('services.facebook.client_id') }}')"
                                        value="{{ config('services.facebook.client_id') }}" name="facebook_client_id" type="text"
                                        class="form-control @error('facebook_client_id') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('facebook_client_id')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="Facebook Client Secret" class="col-sm-5" />
                                <div class="col-sm-7">
                                    <input
                                        onkeyup="ButtonDisabled('buttonTwo', 'facebook_client_secret' , '{{ config('services.facebook.client_secret') }}')"
                                        value="{{ config('services.facebook.client_secret') }}" name="facebook_client_secret"
                                        type="text"
                                        class="form-control @error('facebook_client_secret') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('facebook_client_secret')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-5 col-sm-7">
                                        <button id="buttonTwo" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('Update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif
            </div>
            {{-- Twitter Login Credential Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('twitter_login_credential') }}</h3>
                        <div class="form-group row">
                            <input {{ config('services.twitter.active') ? 'checked' : '' }} type="checkbox" name="twitter"
                                data-bootstrap-switch value="1">
                        </div>
                    </div>
                </div>
                @if (config('services.twitter.active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.social.login.update') }}"
                            method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="twitter" name="type">
                            <div class="form-group row">
                                <x-forms.label name="Twitter Client Id" class="col-sm-5" />
                                <div class="col-sm-7">
                                    <input
                                        onkeyup="ButtonDisabled('buttonThree', 'twitter_client_id' , '{{ config('services.twitter.client_id') }}')"
                                        value="{{ config('services.twitter.client_id') }}" name="twitter_client_id" type="text"
                                        class="form-control @error('twitter_client_id') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('twitter_client_id')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="Twitter Client Secret" class="col-sm-5" />
                                <div class="col-sm-7">
                                    <input
                                        onkeyup="ButtonDisabled('buttonThree', 'twitter_client_secret' , '{{ config('services.twitter.client_secret') }}')"
                                        value="{{ config('services.twitter.client_secret') }}" name="twitter_client_secret"
                                        type="text"
                                        class="form-control @error('twitter_client_secret') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('twitter_client_secret')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-5 col-sm-7">
                                        <button id="buttonThree" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('Update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-sm-6">
            {{-- Linkedin Login Credential Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('linkedin_login_credential') }}</h3>
                        <div class="form-group row">
                            <input {{ config('services.linkedin.active') ? 'checked' : '' }} type="checkbox" name="linkedin"
                                data-bootstrap-switch value="1">
                        </div>
                    </div>
                </div>
                @if ( config('services.linkedin.active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.social.login.update') }}"
                            method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="linkedin" name="type">
                            <div class="form-group row">
                                <x-forms.label name="Linkedin Client Id" class="col-sm-5" for="linkedin_client_id" />
                                <div class="col-sm-7">
                                    <input
                                        onkeyup="ButtonDisabled('buttonFour', 'linkedin_client_id' , '{{ config('services.linkedin.client_id') }}')"
                                        value="{{ config('services.linkedin.client_id') }}" name="linkedin_client_id" type="text"
                                        class="form-control @error('linkedin_client_id') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('linkedin_client_id')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="Linkedin Client Secret" class="col-sm-5"
                                    for="linkedin_client_secret" />
                                <div class="col-sm-7">
                                    <input
                                        onkeyup="ButtonDisabled('buttonFour', 'linkedin_client_secret' , '{{ config('services.linkedin.client_secret') }}')"
                                        value="{{ config('services.linkedin.client_secret') }}" name="linkedin_client_secret"
                                        type="text"
                                        class="form-control @error('linkedin_client_secret') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('linkedin_client_secret')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-5 col-sm-7">
                                        <button id="buttonFour" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('Update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif
            </div>

            {{-- Github Login Credential Setting --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('github_login_credential') }}</h3>
                        <div class="form-group row">
                            <input {{ config('services.github.active') ? 'checked' : '' }} type="checkbox" name="github"
                                data-bootstrap-switch value="1">
                        </div>
                    </div>
                </div>
                @if ( config('services.github.active'))
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.social.login.update') }}"
                            method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="github" name="type">
                            <div class="form-group row">
                                <x-forms.label name="Github Client Id" for="github_client_id" class="col-sm-5" />
                                <div class="col-sm-7">
                                    <input
                                        onkeyup="ButtonDisabled('buttonFive', 'github_client_id' , '{{ config('services.github.client_id') }}')"
                                        value="{{ config('services.github.client_id') }}" name="github_client_id" type="text"
                                        class="form-control @error('github_client_id') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('github_client_id')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <x-forms.label name="Github Client Secret" for="github_client_secret" class="col-sm-5" />
                                <div class="col-sm-7">
                                    <input
                                        onkeyup="ButtonDisabled('buttonFive', 'github_client_secret' , '{{ config('services.github.client_secret') }}')"
                                        value="{{ config('services.github.client_secret') }}" name="github_client_secret"
                                        type="text"
                                        class="form-control @error('github_client_secret') is-invalid @enderror"
                                        autocomplete="off">
                                    @error('github_client_secret')
                                        <span class="invalid-feedback" role="alert"><span>{{ $message }}</span></span>
                                    @enderror
                                </div>
                            </div>
                            @if (userCan('setting.update'))
                                <div class="form-group row">
                                    <div class="offset-sm-5 col-sm-7">
                                        <button id="buttonFive" type="submit" class="btn btn-success"><i
                                                class="fas fa-sync"></i>
                                            {{ __('Update') }}</button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('backend') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script>
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('#buttonOne').prop('disabled', true);
        $('#buttonTwo').prop('disabled', true);
        $('#buttonThree').prop('disabled', true);
        $('#buttonFour').prop('disabled', true);
        $('#buttonFive').prop('disabled', true);

        function ButtonDisabled(id, input, data) {
            let inputVal = $('[name=' + input + ']').val();
            if (inputVal == data) {
                $('#' + id).prop('disabled', true);
            } else {
                $('#' + id).prop('disabled', false);
            }
        }

        $("input[data-bootstrap-switch]").on('switchChange.bootstrapSwitch', function(event, state) {
            let input = $(this).attr('name');
            let status = state ? 1 : 0;
            $("input[name=" + input + "]").val(status);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('settings.social.login.status.update') }}",
                data: {
                    'type': input,
                    'status': status
                },
                success: function(response) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            });
        });
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@endsection
