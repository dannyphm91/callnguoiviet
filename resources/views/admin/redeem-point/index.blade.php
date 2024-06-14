@extends('admin.layouts.app')
@section('title')
    {{ __('redeem_points_list') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ad-report-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="card-title" style="line-height: 36px;">{{ __('redeem_points_list') }}</h3>
                            <div class="d-flex align-items-center gap-20px">
                                <div>
                                    <a href="{{ route('redeem-points.create') }}" class="btn bg-primary">
                                        <i class="fas fa-plus"></i>
                                        <span class="ml-2">{{ __('add_redeem_points') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0 table-bordered">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('serial') }}</th>
                                    <th>{{ __('points') }}</th>
                                    <th>{{ __('balance') }}</th>
                                    <th><span class="sr-only">{{ __('action') }}</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($redeemPoints as $key => $redeemPoint)
                                    <tr class="">
                                        <td>{{ $key+1 }}</td>
                                        <td> {{ number_format($redeemPoint->points) }} </td>
                                        <td> ${{ number_format($redeemPoint->redeem_balance, 2) }} </td>
                                        
                                        <td>
                                            <a href="{{ route('redeem-points.edit', $redeemPoint) }}" class="mr-1 btn btn-sm bg-secondary"
                                                data-toggle="tooltip" data-placement="top" title="{{ __('edit_tag') }}">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <form action="{{ route('redeem-points.destroy', $redeemPoint) }}"
                                                method="POST" class="d-inline mt-2">
                                                @method('DELETE')
                                                @csrf
                                                <button data-toggle="tooltip" data-placement="top"
                                                    title="{{ __('delete_tag') }}"
                                                    onclick="return confirm('Are you sure to delete this item?')"
                                                    class="mr-1 btn btn-sm btn-danger">
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
                        {{ $redeemPoints->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
