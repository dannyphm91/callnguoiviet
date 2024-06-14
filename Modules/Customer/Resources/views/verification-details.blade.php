@extends('admin.layouts.app')
@section('title')
    {{ __('verification_details') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-3">
                <div class="card card-widget widget-user shadow">
                    <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username text-capitalize">{{ $request->user->name }}</h3>
                        <h5 class="widget-user-desc text-capitalize">{{ $request->user->email }}</h5>
                    </div>
                    <div class="widget-user-image">
                        @if ($request->user->image)
                            <img class="position-relative img-circle elevation-2" src="{{ asset($request->user->image) }}"
                                alt="Customer Image">
                        @else
                            <img class="position-relative img-circle elevation-2"
                                src="{{ asset('backend/image/thumbnail.jpg') }}" alt="Customer Image">
                        @endif
                        <div
                            class="{{ $request->status == 'approved' ? 'bg-success' : ($request->status == 'rejected' ? 'bg-danger' : 'bg-secondary') }} verify-status px-2 rounded position-absolute top-3">
                            {{ Str::ucfirst($request->status) }}
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header text-capitalize">{{ __('username') }}</h5>
                                    <span class="description-text text-capitalize">{{ $request->user->username }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ __('phone') }}</h5>
                                    <span class="description-text">{{ $request->user->phone }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ __('website') }}</h5>
                                    <span
                                        class="description-text">{{ $request->user->web ? $request->user->web : '-' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="description-block">
                                    <h5 class="description-header">{{ __('registered_at') }}</h5>
                                    <span
                                        class="description-text">{{ date('M d, Y', strtotime($request->user->created_at)) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <-- ===============  --> --}}
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-2">
                <div class="card">
                    <div class="mt-3 tab-pane active documents documents-panel">
                        <form action="{{ route('module.customer.verification.request.download', $request->id) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" class="d-none" name="doc_type" value="passport">
                            <button type="submit" class="document success p-0" method="POST">
                                <div class="document-body">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <div class="document-footer">
                                    <span class="document-name">
                                        {{ __('passport') }} / {{ __('national_id') }}
                                    </span>
                                    <span class="document-description"> {{ __('click_to_download') }} </span>
                                </div>
                            </button>
                        </form>
                    </div>
                    <form id="status-change-form"
                        action="{{ route('module.customer.verification.request.status', $request->id) }}" method="POST"
                        class="d-flex mb-2">
                        @csrf
                        <input type="hidden" value="" id="status" name="status" readonly class="d-none">
                        <input type="hidden" value="" name="rejected_reason" readonly id="rejected_reason">
                        <button type="button" onclick="statusChange('rejected','{{ $request->id }}')"
                            class="mt-0 p-1 ml-2 mr-2 btn-block btn btn-danger btn-md">
                            <i class="fas fa-times mr-2"></i>
                            {{ __('reject') }}
                        </button>
                        <button type="button" onclick="statusChange('approved')"
                            class="mt-0 p-1 ml-2 mr-2 btn btn-block btn-success btn-md">
                            <i class="fas fa-check mr-2"></i>
                            {{ __('approve') }}
                        </button>
                    </form>
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
        .widget-user .widget-user-image>img {
            width: 110px;
        }

        .widget-user .card-footer {
            padding-top: 80px;
        }


        .documents {
            padding: 20px;
        }

        .document {
            float: left;
            width: calc(33% - 20px);
            max-width: 240px;
            margin: 0px 10px 20px;
            background-color: #fff;
            border-radius: 3px;
            border: 1px solid #dce2e9;
            cursor: pointer;
        }

        .document .document-body {
            height: 130px;
            text-align: center;
            border-radius: 3px 3px 0 0;
            background-color: #fdfdfe;
        }

        .document .document-body i {
            font-size: 45px;
            line-height: 120px;
        }

        .document .document-body img {
            width: 100%;
            height: 100%;
        }

        .document .document-footer {
            border-top: 1px solid #ebf1f5;
            height: 46px;
            ;
            padding: 5px 12px;
            border-radius: 0 0 2px 2px;
        }

        .document .document-footer .document-name {
            display: block;
            margin-bottom: 0;
            font-size: 15px;
            font-weight: 600;
            width: 100%;
            line-height: normal;
            overflow-x: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .document .document-footer .document-description {
            display: block;
            margin-top: -1px;
            font-size: 11px;
            font-weight: 600;
            color: #8998a6;
            width: 100%;
            line-height: normal;
            overflow-x: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .document.info .document-footer>*,
        .document.success .document-footer>*,
        .document.danger .document-footer>*,
        .document.warning .document-footer>*,
        .document.dark .document-footer>* {
            color: #fff;
        }

        .document.info .document-footer {
            background-color: #2da9e9;
        }

        .document.success .document-footer {
            background-color: #0ec8a2;
        }

        .document.warning .document-footer {
            background-color: #ff9e2a;
        }

        .document.danger .document-footer {
            background-color: #f95858;
        }

        .document.dark .document-footer {
            background-color: #314557;
        }

        .folders {
            width: 100%;
        }

        .folders li {
            font-size: 14px;
            padding: 3px 4px 3px 12px;
        }

        .folders li a {
            text-decoration: none;
            color: #4a4d56;
        }

        .folders li a i {
            color: #5e6168;
            font-size: 16px;
            margin-right: 5px;
        }

        @media screen and (max-width: 600px) {
            .document {
                width: 100%;
                margin: 5px 0;
                max-width: none;
            }
        }

        .verify-status {
            margin-top: -64%;
            right: -70px;
        }
    </style>
@endsection

@section('script')
    <script>
        function statusChange(arg, id) {
            if (arg == 'rejected') {
                $('#reject_reason_id').val(id);
                $('#reject_reasonModalCenter').modal('show');
            } else {
                $('#status').val(arg);
                $('#status-change-form').submit();
            }
        }

        function submitReject() {

            let id = $('#reject_reason_id').val();

            let text = $('#reject-reason').val();
            $('#status').val('rejected');
            $('#rejected_reason').val(text);

            $('#status-change-form').submit();
        }
    </script>
@endsection
