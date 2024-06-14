@extends('admin.layouts.app')
@section('title')
    {{ __('ad_report_category_list') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('ad_report_category_list') }}</h3>
                    </div>
                    <div class="p-4">
                        <div class="row">
                            @forelse ($adReportCategories as $adReportCategory)
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="card card-margin">
                                        <div class="card-body pt-0">
                                            <div class="widget-49">
                                                <div class="widget-49-title-wrapper mt-4 items-align-center">
                                                    <!--// image tag was -->
                                                    <div class="widget-49-meeting-info">
                                                        <span class="text-capitalize text--xl">
                                                            {{ $adReportCategory->name }}
                                                        </span>
                                                        <span class="widget-49-meeting-time -mt-5">
                                                            {{ date('M d, Y', strtotime($adReportCategory->created_at)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="widget-49-meeting-action">
                                                    @if (userCan('ad_report_category.edit'))
                                                        <a href="{{ route('ad-report-category.edit', $adReportCategory->slug) }}"
                                                            class="btn btn-sm btn-outline-primary mr-1">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                    @if (userCan('ad_report_category.delete'))
                                                        <form action="{{ route('ad-report-category.destroy', $adReportCategory->slug) }}"
                                                            method="POST" class="d-inline mt-2">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button data-toggle="tooltip" data-placement="top"
                                                                title="{{ __('delete_tag') }}"
                                                                onclick="return confirm('Are you sure to delete this item?')"
                                                                class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center">
                                    <x-not-found route="" word="ad_report_category" />
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-footer ">
                        <div class="d-flex justify-content-center">
                            {{ $adReportCategories->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="line-height: 36px;">
                            @if (request()->routeIs('ad-report-category.edit'))
                                <span>{{ __('edit_ad_report_category') }}</span>
                            @else
                                <span>{{ __('create_ad_report_category') }}</span>
                            @endif
                        </h3>
                    </div>
                    <div class="card-body">
                        @if (request()->routeIs('ad-report-category.edit'))
                            <form class="form-horizontal" action="{{ route('ad-report-category.update', $category->slug) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group row">
                                    <x-forms.label name="name" required="true" class="col-sm-3" />
                                    <div class="col-sm-9">
                                        <input value="{{ $category->name }}" name="name" type="text"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            placeholder="{{ __('enter_name') }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-12">
                                        <button type="submit" class="btn btn-success"><i class="fas fa-sync"></i>&nbsp;
                                            {{ __('update') }}</button>
                                        <a href="{{ route('ad-report-category.index') }}" class="btn btn-danger"><i
                                                class="fas fa-times"></i>&nbsp; {{ __('cancel') }}</a>
                                    </div>
                                </div>
                            </form>
                        @else
                            <form class="form-horizontal" action="{{ route('ad-report-category.store') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <x-forms.label name="name" required="true" class="col-sm-3" />
                                    <div class="col-sm-9">
                                        <input value="{{ old('name') }}" name="name" type="text"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            placeholder="{{ __('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-3 col-sm-4">
                                        <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i>&nbsp;
                                            {{ __('create') }}</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <x-admin.simple-card-design />
    <style>
        .text--xl {
            font-size: 30px;
            margin: 0;
        }

        .-mt-5 {
            margin-top: -5px;
        }

        .text--xl {
            font-size: 1.5rem !important;
        }
    </style>
@endsection
