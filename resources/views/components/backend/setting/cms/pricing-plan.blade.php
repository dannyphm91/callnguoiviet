<div class="row">
    <div class="col-md-6">
        <form class="form-horizontal" action="{{ route('admin.pricingplan.update') }}" method="POST"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card">
                {{-- <div class="card-header">{{ __('price_plan') }}</div> --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-forms.label name="pricing_plan_background" />
                                <input type="file" class="form-control dropify"
                                    data-default-file="{{ $cms->pricing_plan_background }}"
                                    name="pricing_plan_background" autocomplete="image"
                                    data-allowed-file-extensions="jpg png jpeg"
                                    accept="image/png, image/jpg, image/jpeg">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-sync"></i> {{ __('update_pricing_plan_settings') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <form class="form-horizontal" action="{{ route('admin.pricingplanimage.update') }}" method="POST"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-forms.label name="pricing_plan_image" />
                                <input type="file" class="form-control dropify"
                                    data-default-file="{{ $cms->pricing_plan_image }}" name="pricing_plan_image"
                                    autocomplete="image" data-allowed-file-extensions="jpg png jpeg"
                                    accept="image/png, image/jpg, image/jpeg">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-sync"></i> {{ __('update_pricing_plan_image_settings') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@php
    $editData = null;
    if (session()->has('editData')) {
        $editData = session('editData');
    }
@endphp
<div class="row">
    <div class="col-md-8">
        <!-- Show Price Plan Service list -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title text-dark" style="line-height: 36px;">
                            {{ __('pricing_plan_service_list') }}</h3>
                    </div>
                    <div class="card-body table-responsive mb-2">
                        <table class="table table-bordered text-center mb-3">
                            <thead class="text-dark">
                                <tr>
                                    <th width="1%">{{ __('no') }}</th>
                                    <th width="15%">{{ __('icon') }}</th>
                                    <th width="20%">{{ __('pricing_plan_service_title') }}</th>
                                    <th width="25%">{{ __('pricing_plan_service_description') }}</th>
                                    <th width="15%">{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="sortablePricing">
                                @forelse($pricePlanServices as $key => $PricePlanService)
                                    <tr data-id="{{ $PricePlanService->id }}">
                                        <td>
                                            <div class="handle btn mt-0 text-left cursor-move">
                                                <x-svg.drag-icon fill="black" />
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <img src="{{ asset($PricePlanService->service_icon) }}" alt=""
                                                width="60px" height="60px">
                                        </td>
                                        <td class="text-center">
                                            {{ $PricePlanService->title }}
                                        </td>
                                        <td class="text-center">
                                            {{ $PricePlanService->description }}
                                        </td>
                                        <td class="text-center">
                                            <a title="{{ __('edit') }}"
                                                href="{{ route('admin.pricingplanservice.edit', $PricePlanService->id) }}"
                                                class="btn bg-info mr-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form
                                                action="{{ route('admin.pricingplanservice.delete', $PricePlanService->id) }}"
                                                method="POST" class="d-inline">
                                                @method('DELETE')
                                                @csrf
                                                <button title="{{ __('delete') }}"
                                                    onclick="return confirm('{{ __('are_you_sure') }}?');"
                                                    class="btn bg-danger">
                                                    <i class="fas fa-trash text-light"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('nothing_found') }}.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">

        @isset($editData)
            <form class="form-horizontal" action="{{ route('admin.pricingplanservice.update', $editData->id) }}"
                method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card">
                    <div class="card-header">{{ __('edit_pricing_plan_service') }}</div>
                @else
                    <form class="form-horizontal" action="{{ route('admin.pricingplanservice.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="card">
                            <div class="card-header">{{ __('add_pricing_plan_service') }}</div>
                        @endisset
                        <div class="card-body">
                            <div class="form-group">
                                <x-forms.label name="pricing_plan_service_title" :required="true" />
                                <input type="text" name="pricing_plan_service_title" class="form-control"
                                    value="{{ isset($editData) ? $editData->title : null }}">
                            </div>
                            <div class="form-group">
                                <x-forms.label name="pricing_plan_service_description" :required="true" />
                                <textarea name="pricing_plan_service_description" class="form-control" cols="10" rows="8">{{ isset($editData) ? $editData->description : null }}</textarea>
                            </div>
                            <div class="form-group">
                                <x-forms.label name="pricing_plan_service_icon" />
                                <input type="file" class="form-control dropify" data-default-file=""
                                    name="pricing_plan_service_icon" autocomplete="image"
                                    data-allowed-file-extensions="jpg png jpeg"
                                    accept="image/png, image/jpg, image/jpeg">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-sync"></i>
                                    {{ isset($editData) ? __('update') : __('add_pricing_plan_service_settings') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </div>

    @push('script')
        <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript">
            // sortablePricing
            $(function() {
                $("#sortablePricing").sortable({
                    items: 'tr',
                    cursor: 'move',
                    opacity: 0.4,
                    scroll: false,
                    dropOnEmpty: false,
                    update: function() {
                        sendTaskOrderToServer('#sortablePricing tr');
                    },
                    classes: {
                        "ui-sortable": "highlight"
                    },
                });
                $("#sortablePricing").disableSelection();

                function sendTaskOrderToServer(selector) {
                    var order = [];
                    $(selector).each(function(index, element) {
                        order.push({
                            id: $(this).attr('data-id'),
                            position: index + 1
                        });
                    });

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('admin.pricePlan.sorting') }}",
                        data: {
                            order: order,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            toastr.success(response.message, 'Success');
                        }
                    });
                }
            });
        </script>
    @endpush
