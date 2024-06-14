<div class="card">
    <div class="card-header">
        {{ __('home') }}
    </div>
    <div class="card-body">

        <!-- Upload slider image -->
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title text-dark" style="line-height: 36px;">{{ __('upload_home_page_slider') }}
                        </h3>
                    </div>
                    <div class="card-body mb-2">

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form id="dropzoneForm" class="dropzone" action="{{ route('store_gallery') }}">
                                    @csrf
                                </form>
                                <div align="center">
                                    <button type="button" class="btn btn-success mt-3" id="submit-all">
                                        <i class="fas fa-sync"></i> {{ __('update_home_slider') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="panel panel-default">
                            <div class="panel-body" id="uploaded_image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Show slider image list -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title text-dark" style="line-height: 36px;">
                            {{ __('home_page_slider_image_list') }}</h3>
                    </div>
                    <div class="card-body mb-2">
                        <table class="table table-bordered text-center mb-3">
                            <thead class="text-dark">
                                <tr>
                                    <th width="1%">{{ __('sort') }}</th>
                                    <th width="10%">{{ __('slider_image') }}</th>
                                    <th width="15%">{{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @forelse($sliders as $slider)
                                    <tr data-id="{{ $slider->id }}">
                                        <td>
                                            <div class="handle btn mt-0 text-left cursor-move">
                                                <x-svg.drag-icon fill="black" />
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <img src="{{ $slider->ImageUrl }}" alt="" width="60px"
                                                height="60px">
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('delete_gallery', $slider->id) }}" method="POST"
                                                class="d-inline">
                                                @method('DELETE')
                                                @csrf
                                                <button title="{{ __('delete_slider') }}"
                                                    onclick="return confirm('{{ __('are_you_sure') }}?');"
                                                    class="btn bg-danger">
                                                    <i class="fas fa-trash text-light"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">{{ __('nothing_found') }}.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
    <style>
        .dropzone {
            background: white;
            border-radius: 5px;
            border: 2px dashed rgb(0, 135, 247);
            border-image: none;
            max-width: 805px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endsection

@push('script')
    <script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
    <script type="text/javascript">
        // In your Dropzone initialization script
        Dropzone.autoDiscover = false;

        // Destroy existing Dropzone instances
        if (Dropzone.instances.length > 0) {
            Dropzone.instances.forEach(function(instance) {
                // Disable autoDiscover to prevent automatic initialization
                Dropzone.autoDiscover = false;
                instance.destroy();
            });
        }

        // Initialize Dropzone for Home Setting
        var myDropzoneHome = new Dropzone("#dropzoneForm", {
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 10,
            thumbnailHeight: 120,
            thumbnailWidth: 120,
            maxFilesize: 3,
            filesizeBase: 1000,
            addRemoveLinks: true,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            init: function() {
                myDropzoneHome = this;
                $('#submit-all').on('click', function() {
                    myDropzoneHome.processQueue();
                });

                this.on("complete", function() {
                    if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                        var _this = this;
                        _this.removeAllFiles();
                        console.log()
                    }
                });
            },
            success: function(file, response) {
                window.location.href = response.url;
                toastr.success(response.message, 'Success');
            },
            error: function(file, response) {
                toastr.failed('Image upload failed', 'Failed');
            }
        });

        // sortable
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
                $(selector).each(function(index, element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index + 1
                    });
                });
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.home.slider.sorting') }}",
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
