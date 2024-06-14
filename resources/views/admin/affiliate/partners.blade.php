@extends('admin.layouts.app')
@section('title')
    {{ __('affiliate_partners') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ad-report-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="card-title" style="line-height: 36px;">{{ __('affiliate_partners') }}</h3>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0 table-bordered">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('serial') }}</th>
                                    <th>{{ __('name') }}</th>
                                    <th>{{ __('email') }}</th>
                                    <th>{{ __('total_points') }}</th>
                                    <th>{{ __('balance') }}</th>
                                    <th>{{ __('invites') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($partners as $key => $partner)
                                    <tr class="">
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $partner->user->name ?? '' }}</td>                                        
                                        <td>{{ $partner->user->email ?? '' }}</td>                                        
                                        <td>{{ $partner->total_points ?? '' }}</td>                                        
                                        <td>${{ $partner->balance ?? '' }}</td>                                        
                                        <td>{{ $partner->user->affiliateInvites->count() ?? '' }}</td>                                        
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
                        {{ $partners->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
