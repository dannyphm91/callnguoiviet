@extends('admin.layouts.app')

@section('title')
    {{ __('affiliate_settings') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('affiliate_settings') }}</h3>
                    </div>
                    <form action="{{route('affiliate-settings.update', $affiliateSettings->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="affiliate_feature">{{ __('invite_points') }}</label>
                                        <input value="{{ $affiliateSettings->invite_points ?? 0 }}" name="invite_points" type="text"
                                        class="form-control @error('invite_points') is-invalid @enderror"
                                        placeholder="{{ __('enter_invite_points') }}" >
                                        @error('invite_points')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="point_convert_permission">{{ __('point_convert_permission') }}</label>
                                        <select name="point_convert_permission" class="select2bs4 form-control">
                                            <option value="1" @if ($affiliateSettings->point_convert_permission == 1) selected @endif>User Access</option>
                                            <option value="2" @if ($affiliateSettings->point_convert_permission == 2) selected @endif>Admin Approval</option>
                                        </select>
                                        @error('point_convert_permission')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="affiliate_feature">{{ __('affiliate_feature') }}</label>
                                        <select name="affiliate_feature" class="select2bs4 form-control" disabled>
                                            <option value="1" @if ($affiliateSettings->affiliate_feature == 1) selected @endif>Active</option>
                                            <option value="0" @if ($affiliateSettings->affiliate_feature == 0) selected @endif>Inactive</option>
                                        </select>
                                        @error('affiliate_feature')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
