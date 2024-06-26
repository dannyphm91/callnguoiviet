@extends('admin.layouts.app')

@section('title')
    {{ __('sorting_custom_fields') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title" style="line-height: 36px;">{{ __('sorting_custom_fields') }}</h3>
                            <div>
                                <a href="{{ route('module.ad.index', $ad->id) }}" class="mr-2 btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i>
                                    <span class="ml-2">{{ __('ad_list') }}</span>
                                </a>
                                {{-- <a href="{{ route('module.category.custom.field.attach', $category->id) }}"
                                    class="btn btn-success">
                                    <i class="fas fa-plus"></i>
                                    <span class="ml-1">{{ __('add') }}</span>
                                </a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap table-bordered">
                            <thead>
                                <tr class="text-left">
                                    <th width="5%"></th>
                                    <th width="15%">{{ __('type') }}</th>
                                    <th width="15%">{{ __('group') }}</th>
                                    <th>{{ __('name') }}</th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @forelse ($fields as $item)
                                    <tr class="custom-field" data-id="{{ $item->id }}">
                                        <td class="text-center">
                                            <div class="handle btn mt-0 text-left cursor-move">
                                                <x-svg.drag-icon fill="black" />
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{ Str::replaceFirst('_', ' ', ucfirst($item->customField->type)) }}
                                        </td>
                                        <td class="text-left">
                                            {{ $item->group }}
                                        </td>
                                        <td class="text-left">
                                            {{ ucfirst($item->customField->name) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            <div class="empty py-5">
                                                <div class="empty-img">
                                                    <img src="{{ asset('backend/image') }}/not-found.svg" height="128px"
                                                        width="208px" alt="">
                                                </div>
                                                <h5 class="mt-4">{{ __('no_results_found') }}</h5>
                                                <p class="empty-subtitle text-muted">
                                                    {{ __('there_is_no') }} {{ __('found_in_the_page') }}
                                                </p>
                                                <div class="empty-action">
                                                    <a href="{{ route('module.category.custom.field.add', $ad->id) }}"
                                                        class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                            width="24" height="24" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <line x1="12" y1="5" x2="12"
                                                                y2="19"></line>
                                                            <line x1="5" y1="12" x2="19"
                                                                y2="12"></line>
                                                        </svg>
                                                        {{ __('add_your_first') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#sortable").sortable({
                items: 'tr',
                cursor: 'move',
                opacity: 0.4,
                scroll: false,
                dropOnEmpty: false,
                update: function() {
                    sendTaskOrderToServer('#sortable tr');
                },
                classes: {
                    "ui-sortable": "highlight"
                },
            });
            $("#sortable").disableSelection();

            function sendTaskOrderToServer(selector) {
                var order = [];
                var ad = {!! $ad !!};
                $(selector).each(function(index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('module.ad.custom.field.value.sorting.store') }}",
                    data: {
                        order: order,
                        ad: ad.id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        toastr.success(response.message, 'Success');
                    }
                });
            }
        });
    </script>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <style>
        table td {
            vertical-align: middle !important;
        }

        table td:first-of-type {
            padding-left: 1rem !important;
        }
    </style>
@endsection
