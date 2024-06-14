@extends('admin.layouts.app')

@section('title')
    {{ __('verification_request_list') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('verification_request_list') }}</h3>
                        <a href="{{ route('module.customer.index') }}"
                            class="btn bg-primary float-right d-flex align-items-center justify-content-center"><i
                                class="fas fa-plus"></i>&nbsp; {{ __('customers') }}</a>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <form action="{{ route('module.customer.verification.request') }}" method="GET">
                            <div class="row justify-content-between my-3">
                                <div class="col-sm-12 col-md-12 col-lg-7 ml-4 mr-4">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-4 mt-1 mt-lg-0">
                                            <input type="text" value="{{ request('keyword') }}" class="form-control"
                                                placeholder="{{ __('name') }} , {{ __('username') }} , {{ __('email') }}"
                                                name="keyword" aria-label="{{ __('search') }}">
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-4 mt-1 mt-lg-0">
                                            <div class="d-flex">
                                                <a href="{{ route('module.customer.verification.request', ['data' => 'approved']) }}"
                                                    class="a-color">
                                                    <div class="filtertags close-tag pointer mr-2">
                                                        <div
                                                            class="single-tag {{ request('data') == 'approved' ? 'single-tag-active' : '' }}">
                                                            Approved
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="{{ route('module.customer.verification.request', ['data' => 'pending']) }}"
                                                    class="a-color">
                                                    <div class="filtertags close-tag pointer mr-2">
                                                        <div
                                                            class="single-tag {{ !request('data') || request('data') == 'pending' ? 'single-tag-active' : '' }}">
                                                            Pending
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="{{ route('module.customer.verification.request', ['data' => 'rejected']) }}"
                                                    class="a-color">
                                                    <div class="filtertags close-tag pointer mr-2">
                                                        <div
                                                            class="single-tag {{ !request('data') || request('data') == 'rejected' ? 'single-tag-active' : '' }}">
                                                            Rejected
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-4 mt-1 mt-lg-0">
                                            <button class="btn btn-primary px-4" type="submit">{{ __('filter') }}
                                            </button>
                                            @if (request('keyword') || request('filter_by') || request('sort_by') || request('perpage'))
                                                <a href="{{ route('module.customer.verification.request') }}"
                                                    class="btn btn-danger px-4 ml-1">
                                                    {{ __('clear') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-hover text-nowrap table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="2%">#</th>
                                            <th width="5%">{{ __('image') }}</th>
                                            <th width="10%">{{ __('name') }}</th>
                                            <th width="10%">{{ __('email') }}</th>
                                            <th width="10%">{{ __('username') }}</th>
                                            <th width="10%">{{ __('status') }}</th>
                                            <th width="5%">{{ __('action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($requests as $key =>$request)
                                            <tr>
                                                <td class="text-center" tabindex="0">{{ $key + 1 }}
                                                </td>
                                                <td class="text-center" tabindex="0">
                                                    <a
                                                        href="{{ route('module.customer.show', $request->user->username) }}">
                                                        <img src="{{ $request->user->image_url }}" class="rounded"
                                                            height="50px" width="50px" alt="image">
                                                    </a>
                                                </td>
                                                <td class="text-center" tabindex="0">
                                                    <a
                                                        href="{{ route('module.customer.show', $request->user->username) }}">
                                                        {{ $request->user->name }}
                                                    </a>
                                                </td>
                                                <td class="text-center text-capitalize" tabindex="0">
                                                    {{ $request->user->email }}</td>
                                                <td class="text-center text-capitalize" tabindex="0">
                                                    {{ $request->user->username }}</td>
                                                <td class="text-center" tabindex="0">
                                                    <button type="button"
                                                        class="text-capitalize btn btn-info dropdown-toggle"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                        {{ $request->status }}
                                                    </button>
                                                    <form id="status-change-form{{ $request->id }}"
                                                        action="{{ route('module.customer.verification.request.status', $request->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" value="" name="status" readonly
                                                            id="status{{ $request->id }}">
                                                        <input type="hidden" value="" name="rejected_reason" readonly
                                                            id="rejected_reason{{ $request->id }}">
                                                        <ul class="dropdown-menu" x-placement="bottom-start"
                                                            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                                                            <li
                                                                class="{{ $request->status == 'pending' ? 'd-none' : '' }}">
                                                                <button
                                                                    onclick="statusChange('pending','{{ $request->id }}')"
                                                                    type="button" class="dropdown-item">
                                                                    <i class="fas fa-hourglass-start text-info mr-2"></i>
                                                                    {{ __('pending') }}
                                                                </button>
                                                            </li>
                                                            <li
                                                                class="{{ $request->status == 'rejected' ? 'd-none' : '' }}">
                                                                <button
                                                                    onclick="statusChange('rejected','{{ $request->id }}')"
                                                                    type="button" class="dropdown-item">
                                                                    <i class="fas fa-times text-danger mr-2"></i>
                                                                    {{ __('reject') }}
                                                                </button>
                                                            </li>
                                                            <li
                                                                class="{{ $request->status == 'approved' ? 'd-none' : '' }}">
                                                                <button
                                                                    onclick="statusChange('approved','{{ $request->id }}')"
                                                                    type="button" class="dropdown-item">
                                                                    <i class="fas fa-check text-success mr-2"></i>
                                                                    {{ __('approve') }}
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </form>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a class="btn btn-sm"
                                                            href="{{ route('module.customer.verification.request.show', $request->id) }}">
                                                            <i class="fas fa-eye text-info text-lg"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('module.customer.verification.request.destroy', $request->id) }}"
                                                            method="POST" class="d-inline">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button title="{{ __('delete') }}" type="submit"
                                                                class="btn btn-sm"
                                                                onclick="return confirm('{{ __('are_you_sure_want_to_delete_this_item') }}');">
                                                                <i class="fas fa-trash text-danger text-lg"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">
                                                    <x-not-found word="{{ __('requests') }}" route="" />
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if (request('perpage') != 'all' && $requests->total() > $requests->count())
                        <div class="card-footer ">
                            <div class="d-flex justify-content-center">
                                {{ $requests->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="reject_reasonModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="reject_reasonModalCenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        {{ __('reject_reason') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" value="" readonly id="reject_reason_id">
                <div class="modal-body">
                    <textarea placeholder="{{ __('reject_reason') }}" id="reject-reason" class="form-control" cols="2"
                        rows="2"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ __('close') }}
                    </button>
                    <button onclick="submitReject()" type="button" class="btn btn-primary">
                        {{ __('reject') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .page-link.page-navigation__link.active {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 35px;
            height: 19px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            display: none;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 3px;
            bottom: 2px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input.success:checked+.slider {
            background-color: #28a745;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(15px);
            -ms-transform: translateX(15px);
            transform: translateX(15px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection

@section('script')
    <script>
        function statusChange(status, id) {
            if (status == 'rejected') {
                $('#reject_reason_id').val(id);
                $('#reject_reasonModalCenter').modal('show');

            } else {
                $('#status' + id).val(status);
                $('#status-change-form' + id).submit();
            }
        }

        function submitReject() {
            let id = $('#reject_reason_id').val();

            let text = $('#reject-reason').val();
            $('#status' + id).val('rejected');
            $('#rejected_reason' + id).val(text);

            $('#status-change-form' + id).submit();
        }
    </script>
@endsection
