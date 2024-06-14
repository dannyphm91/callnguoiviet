@extends('admin.layouts.app')
@section('title')
    {{ __('ad_report_list') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ad-report-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="card-title" style="line-height: 36px;">{{ __('ad_report_list') }}</h3>
                            <div class="d-flex align-items-center gap-20px">
                                <div>
                                    <a href="{{ route('ad-report-category.index') }}" class="btn bg-primary">
                                        <i class="fas fa-plus"></i>
                                        <span class="ml-2">{{ __('ad_report_category') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0 table-bordered">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('report_to') }}</th>
                                    <th>{{ __('report_from') }}</th>
                                    <th>{{ __('type') }}</th>
                                    <th>{{ __('description') }}</th>
                                    <th><span class="sr-only">{{ __('action') }}</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reports as $report)
                                    <tr class="">
                                        <td>
                                            <a href="{{ route('module.ad.show', $report->reportTo->slug) }}">
                                                <div class="text-capitalize">
                                                    {{ $report->reportTo->title }}
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('module.customer.show', $report->reportFrom->username) }}">
                                                <div class="text-capitalize">{{ $report->reportFrom->name }}</div>
                                            </a>
                                        </td>
                                        <td>
                                            {{ $report->reportCategory->name }}
                                        </td>
                                        <td>
                                            {{ $report->report_description }}
                                        </td>
                                        <td>
                                            <form action="{{ route('report-ad.destroy', $report) }}"
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
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            <x-not-found2 />
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
