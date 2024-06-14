@extends('admin.layouts.app')
@section('title')
    {{ __('balance_request') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ad-report-card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="card-title" style="line-height: 36px;">{{ __('balance_request') }}</h3>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0 table-bordered">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('serial') }}</th>
                                    <th>{{ __('name') }}</th>
                                    <th>{{ __('email') }}</th>
                                    <th>{{ __('points') }}</th>
                                    <th>{{ __('pricing') }}</th>
                                    <th>{{ __('date') }}</th>
                                    <th>{{ __('status') }}</th>
                                    <th>{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($balanceRequests as $key => $data)
                                    <tr class="">
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $data->user->name ?? '' }}</td>                                        
                                        <td>{{ $data->user->email ?? '' }}</td>                                        
                                        <td>{{ $data->points ?? '' }}</td>                                        
                                        <td>{{ number_format($data->pricing ,2) ?? '' }}</td>   
                                        <td>{{date('d M, Y', strtotime($data->created_at ?? ''))}}</td> 
                                        <td>
                                            <span class="badge {{ $data->status == 0 ? 'bg-primary' : 'bg-success' }}">
                                                {{ $data->status == 0 ? 'Pending' : 'Completed' }}
                                            </span>
                                        </td>                                    
                                        <td>
                                            @if ($data->status == 0)
                                                <a href="{{ route('affiliate.balance.request.confirm', $data->id) }}" 
                                                    onclick="return confirm('Are you sure you want to confirm the balance request?')" 
                                                    class="btn btn-sm btn-success">
                                                    Confirm
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-sm btn-secondary" disabled>
                                                    Confirmed
                                                </a>
                                            @endif
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
                        {{ $balanceRequests->links() }}
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection
