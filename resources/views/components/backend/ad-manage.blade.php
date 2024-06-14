<table class="table table-hover text-nowrap table-bordered">
    <thead>
        <tr class="text-center">
            <th width="5%">{{ __('thumbnail') }}</th>
            <th width="30%">{{ __('name') }}</th>
            <th>{{ __('price') }}</th>
            @if ($showCategory)
                <th>{{ __('category') }}</th>
            @endif
            @if ($showCity)
                <th>{{ __('country') }}</th>
            @endif
            @if ($showCustomer)
                <th>{{ __('author') }}</th>
            @endif
            <th>{{ __('status') }}</th>
            <th width="5%">{{ __('action') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($ads as $key =>$ad)
            <tr>
                <td class="text-center">
                    <img src="{{ $ad->image_url }}" class="rounded" height="50px" width="50px" alt="image">
                </td>
                <td class="text-center">
                    {{ $ad->title }}
                    @if ($ad->featured)
                        <span class="badge badge-warning">
                            {{ __('featured') }}
                        </span>
                    @endif

                    @if ($ad->resubmission)
                        <span class="badge badge-danger">
                            {{ __('resubmission') }}
                        </span>
                        @if (isset($ad->customer_edit_time))
                            <span class="badge badge-warning">
                                {{ __('customer_resubmitted') }}
                            </span>
                        @endif
                    @endif
                </td>
                <td class="text-center">
                    {{ changeCurrency($ad->price) }}
                </td>
                @if ($showCategory)
                    <td class="text-center">
                        <a
                            href="{{ route('module.category.show', $ad->category->slug) }}">{{ $ad->category->name }}</a>
                    </td>
                @endif
                @if ($showCity)
                    <td class="text-center">
                        <a href="{{ route('module.ad.index', ['country' => $ad->country]) }}">
                            {{ $ad->country }}
                        </a>
                    </td>
                @endif
                @if ($showCustomer)
                    <td class="text-center">
                        <a href="{{ route('module.customer.show', ['customer' => $ad->customer->username]) }}">
                            {{ $ad->customer->username }}
                        </a>
                    </td>
                @endif
                <td class="text-center">
                    <button type="button"
                        class="dropdown-toggle btn-sm btn btn-{{ $ad->status == 'active' ? 'success' : ($ad->status == 'pending' ? 'warning' : 'secondary') }}"
                        data-toggle="dropdown" aria-expanded="false">
                        {{ ucfirst($ad->status) }}
                    </button>
                    <ul class="dropdown-menu" x-placement="bottom-start"
                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">

                        @if ($ad->status == 'active')
                            <li><a onclick="return confirm('Are you sure to perform this action?')"
                                    class="dropdown-item" href="{{ route('module.ad.status', [$ad->slug, 'sold']) }}">
                                    <i class="fas fa-hourglass-end text-danger"></i> {{ __('mark_as_sold') }}
                                </a>
                            </li>
                        @endif
                        @if ($ad->status == 'pending' && $setting->ads_admin_approval)
                            <li><a onclick="return confirm('Are you sure to perform this action?')"
                                    class="dropdown-item"
                                    href="{{ route('module.ad.status', [$ad->slug, 'declined']) }}">
                                    <i class="fas fa-times text-danger"></i> {{ __('mark_as_declined') }}
                                </a>
                            </li>
                        @endif
                        @if ($ad->status == 'pending' && $setting->ads_admin_approval)
                            <li><a onclick="return confirm('Are you sure to perform this action?')"
                                    class="dropdown-item"
                                    href="{{ route('module.ad.status', [$ad->slug, 'active']) }}">
                                    <i class="fas fa-check text-success"></i> {{ __('mark_as_active') }}
                                </a>
                            </li>
                        @endif
                        @if ($ad->status == 'pending' && $ad->resubmission == false && $setting->ads_admin_approval)
                            <li><a class="dropdown-item" data-toggle="modal"
                                    data-target="#resubmission{{ $ad->slug }}"
                                    href="#resubmission{{ $ad->slug }}">
                                    <i class="fas fa-sync-alt text-danger"></i> {{ __('mark_as_resubmission') }}
                                </a>
                            </li>
                        @endif
                        @if ($ad->status == 'pending' && $ad->resubmission == true && $setting->ads_admin_approval)
                            <li><a class="dropdown-item" data-toggle="modal"
                                    data-target="#resubmission{{ $ad->slug }}"
                                    href="#resubmission{{ $ad->slug }}">
                                    <i class="fas fa-sync-alt text-danger"></i> {{ __('mark_as_resubmission') }}
                                </a>
                            </li>
                        @endif
                        @if ($ad->status == 'sold' || ($ad->status == 'declined' && $setting->ads_admin_approval))
                            <li><a onclick="return confirm('Are you sure to perform this action?')"
                                    class="dropdown-item"
                                    href="{{ route('module.ad.status', [$ad->slug, 'active']) }}">
                                    <i class="fas fa-check text-success"></i> {{ __('mark_as_active') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                        {{ __('options') }}
                    </button>
                    <ul class="dropdown-menu" x-placement="bottom-start"
                        style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                        <li><a class="dropdown-item" href="{{ route('module.ad.show', $ad->slug) }}">
                                <i class="fas fa-eye text-info"></i> {{ __('view_details') }}
                            </a></li>
                        <li><a class="dropdown-item" href="{{ route('frontend.addetails', $ad->slug) }}">
                                <i class="fas fa-link text-secondary"></i> {{ __('website_link') }}
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('module.ad.edit', $ad->id) }}">
                                <i class="fas fa-edit text-success"></i> {{ __('edit_listing') }}
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('module.ad.show_gallery', $ad->id) }}">
                                <i class="fas fa-images text-warning"></i></i> {{ __('listing_gallery') }}
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('module.ad.custom.field.value.edit', $ad->id) }}">
                                <i class="fas fa-edit text-info"></i> {{ __('edit_custom_fields') }}
                            </a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{ route('module.ad.custom.field.value.sorting', $ad->id) }}">
                                <i class="fas fa-arrows-alt text-warning"></i> {{ __('sorting_custom_fields') }}
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('module.ad.destroy', $ad->id) }}" method="POST" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="dropdown-item"
                                    onclick="return confirm('{{ __('are_you_sure_want_to_delete_this_item') }}?');">
                                    <i class="fas fa-trash text-danger"></i> {{ __('delete_listing') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade  bd-example-modal-lg" id="resubmission{{ $ad->slug }}" tabindex="-1"
                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('describe_resubmission_feedback') }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('module.ad.ResubmissionStatus', $ad->slug) }}" method="POST"
                                enctype="multipart/form-data" class="d-inline">
                                @method('POST')
                                @csrf
                                <textarea rows="10" id="ck_editor_{{ $ad->slug }}" type="text" class="form-control" name="comment"
                                    placeholder="{{ __('description') }}... ">{{ old('comment', $ad->comment ?? '') }}</textarea>

                                <div class="mb-3">
                                    <label for="formFileMultiple" class="form-label">{{__('select_images') }}</label>
                                    <input class="form-control-file" id="file1" type="file" name="photos[]"
                                        multiple>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{ __('close') }}</button>
                                    <button type="submit"
                                        onclick="return confirm('{{__('are_you_sure_to_perform_this_action') }}')"
                                        class="btn btn-primary">{{ __('save') }}</button>
                                </div>
                            </form>
                            @if (count($ad->resubmissionGalleries) > 0)
                                <h5>{{__('image_list') }}</h5>
                                <ul class="resubmission-gallery">
                                    @foreach ($ad->resubmissionGalleries as $imageData)
                                        <li id="image-{{ $imageData->id }}">
                                            <a href="{{ $imageData->image }}" data-gall="gallery" class="venobox">
                                                <img src="{{ $imageData->image }}" alt="Image">
                                            </a>
                                            <button type="button" onclick="deleteImage({{ $imageData->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        @empty
            <tr>
                <td colspan="10" class="text-center">
                    <x-not-found word="Ad" route="module.ad.create" />
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@section('style')
    <style>
        .ck-editor__editable_inline {
            min-height: 170px;
        }

        .c-btn {
            padding-left: 22px;
            padding-right: 22px;
            border-radius: 15px;
        }

        .custom-control {
            position: relative;
            z-index: 1;
            display: block;
            min-height: 1.5rem;
            padding-left: 0;
            padding-right: 1.5rem;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }

        .resubmission-gallery {
            list-style: none;
            padding: 0px;
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 20px;
        }
        .resubmission-gallery li {
            position: relative;
            margin: 0px;
        }
        .resubmission-gallery button {
            color: red;
            border: none;
            background: #dddddd64;
            position: absolute;
            top: 0px;
            right: 0px;
            border: 1px solid #ddd;
            border-radius: 0px 6px 0px 0px;
        }
        .resubmission-gallery img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        table td {
            max-width: 300px;
            white-space: normal;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}" type="text/css" />
@endsection
@push('script')
    <script src="{{ asset('backend') }}/dist/js/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @forelse ($ads as $ad)
                ClassicEditor
                    .create(document.querySelector('#ck_editor_{{ $ad->slug }}'), {


                    })
                    .catch(error => {
                        console.error(error);
                    });
            @empty
                // Handle the case where there are no ads
            @endforelse
        });
    </script>
    <script>
        function deleteImage(id) {
            var message = "{{ __('are_you_sure_to_perform_this_action') }}";
            if (confirm(message)) {
                fetch(`{{ route('module.ad.resubmissionImage', '') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the image from the list
                            const imageElement = document.querySelector(`#image-${id}`);
                            imageElement.parentNode.removeChild(imageElement);
                        } else {
                            console.error('Error:', data.error);
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            }
        }
    </script>
    <script type="text/javascript" src="{{ asset('frontend/js/venobox.min.js') }}"></script>
    <script>
        new VenoBox({
            selector: '.venobox',
            numeration: true,
            infinigall: true,
            share: true,
            spinner: 'rotating-plane'
        });
    </script>
@endpush
