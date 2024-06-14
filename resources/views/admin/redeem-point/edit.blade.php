@extends('admin.layouts.app')
@section('title')
    {{ __('edit_redeem_points') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('edit_redeem_points') }}</h3>
                        <a href="{{ route('redeem-points.index') }}"
                            class="btn bg-primary float-right d-flex align-items-center justify-content-center">
                            <i class="fas fa-arrow-left mr-1"></i>
                            {{ __('back') }}
                        </a>
                    </div>
                    <div class="row pt-3 pb-4">
                        <div class="col-md-6 offset-md-3">
                            <form class="form-horizontal" action="{{ route('redeem-points.update', $redeemPoint->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <x-forms.label name="{{ __('points') }}" class="col-sm-3" />
                                    <div class="col-sm-9">
                                        <input value="{{ $redeemPoint->points }}" name="points" type="number"
                                            class="form-control @error('points') is-invalid @enderror"
                                            placeholder="{{ __('enter_new_points') }}">
                                        @error('points')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <x-forms.label name="{{ __('redeem_balance') }} ($)" class="col-sm-3" />
                                    <div class="col-sm-9">
                                        <input value="{{ number_format($redeemPoint->redeem_balance , 2) }}" name="redeem_balance" type="text"
                                            class="form-control @error('redeem_balance') is-invalid @enderror"
                                            placeholder="{{ __('enter_new_redeem_balance') }}">
                                        @error('redeem_balance')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i>
                                            {{ __('update') }}</button>
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
