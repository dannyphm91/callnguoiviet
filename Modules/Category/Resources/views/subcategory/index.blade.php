@php
    $user = auth()->user();
@endphp

@extends('admin.layouts.app')

@section('title')
    {{ __('subcategory_list') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="line-height: 36px;">{{ __('add_subcategory') }}</h3>
                        @if (userCan('subcategory.create'))
                            <a href="{{ route('module.subcategory.create') }}"
                                class="btn bg-primary float-right d-flex align-items-center justify-content-center">
                                <i class="fas fa-plus"></i>&nbsp; {{ __('add_subcategory') }}
                            </a>
                        @endif
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th width="30%">
                                        {{ __('name') }} ({{ __('ads_count') }})
                                    </th>
                                    <th>
                                        {{ __('category_name') }}
                                    </th>
                                    <th>
                                        {{ __('status') }}
                                    </th>
                                    @if (userCan('subcategory.update') || userCan('subcategory.delete'))
                                        <th width="18%">
                                            {{ __('action') }}
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sub_categories as $subcategory)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1 text-center" tabindex="0">
                                            <a href="{{ route('module.subcategory.show', $subcategory->slug) }}">
                                                {{ $subcategory->name }} ({{ $subcategory->ads_count }})
                                            </a>
                                        </td>
                                        <td class="sorting_1 text-center" tabindex="0">
                                            <a href="{{ route('module.category.show', $subcategory->category->slug) }}">
                                                {{ $subcategory->category->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div>
                                                <label class="switch ">
                                                    <input data-id="{{ $subcategory->id }}" type="checkbox"
                                                        class="success subcat-status-change"
                                                        {{ $subcategory->status == 1 ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </td>
                                        @if (userCan('subcategory.update') || userCan('subcategory.delete'))
                                            <td class="sorting_1 text-center" tabindex="0">
                                                @if (userCan('subcategory.update'))
                                                    <a data-toggle="tooltip" data-placement="top"
                                                        title="{{ __('edit_subcategory') }}"
                                                        href="{{ route('module.subcategory.edit', $subcategory->id) }}"
                                                        class="btn bg-info"><i class="fas fa-edit"></i></a>
                                                @endif
                                                @if (userCan('subcategory.delete'))
                                                    <form
                                                        action="{{ route('module.subcategory.destroy', $subcategory->id) }}"
                                                        method="POST" class="d-inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button data-toggle="tooltip" data-placement="top"
                                                            title="{{ __('delete_subcategory') }}"
                                                            onclick="return confirm('{{ __('are_you_sure_want_to_delete_this_item') }}');"
                                                            class="btn bg-danger"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">
                                            <x-not-found word="subcategory" route="module.subcategory.create" />
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($sub_categories->total() > $sub_categories->count())
                        <div class="card-footer ">
                            <div class="d-flex justify-content-center">
                                {{ $sub_categories->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 35px;
            height: 19px;
            /* width: 60px;
                                height: 34px; */
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
    <script src="{{ asset('backend') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        $('.subcat-status-change').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var id = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('module.subcategory.status.change') }}',
                data: {
                    'status': status,
                    'id': id
                },
                success: function(response) {
                    toastr.success(response.message, 'Success');
                }
            });
        })
    </script>
@endsection
