<div class="card">
    <div class="card-header">{{ __('about') }}</div>
    <div class="card-body">

        <!-- Upload slider image -->
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title text-dark" style="line-height: 36px;">{{ __('upload_about_page_slider') }}
                        </h3>
                    </div>
                    <div class="card-body mb-2">

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form id="dropzoneFormAbout" class="dropzone"
                                    action="{{ route('about_store_gallery') }}">
                                    @csrf
                                </form>
                                <p class="text-black-50 text-center mt-2"><strong class="text-danger">Note:</strong>
                                    Image size width:120px,
                                    height:45px</p>
                                <div align="center">
                                    <button type="button" class="btn btn-success mt-3" id="submit-about-img">
                                        <i class="fas fa-sync"></i> {{ __('update_about_slider') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="panel panel-default">
                            <div class="panel-body" id="uploaded_image_about">
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
                            {{ __('about_page_slider_image_list') }}</h3>
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
                            <tbody id="sortableAbout">
                                @forelse($aboutSliders as $aboutSlider)
                                    <tr data-id="{{ $aboutSlider->id }}">
                                        <td>
                                            <div class="handle btn mt-0 text-left cursor-move">
                                                <x-svg.drag-icon fill="black" />
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <img src="{{ $aboutSlider->ImageUrl }}" alt="" width="60px"
                                                height="60px">
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('about_delete_gallery', $aboutSlider->id) }}"
                                                method="POST" class="d-inline">
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

        <div class="card">
            <div class="card-body">

                <form class="form-horizontal" action="{{ route('admin.about.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="row">

                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <x-forms.label name="about_video_url" required="false" />

                                    <div class="">
                                        <input type="url" name="about_video_url" id="about_video_url"
                                            class="form-control" value="{{ $aboutVideoUrl }}">
                                        @error('about_video_url')
                                            <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">

                                    <div
                                        class="about-video-thumb-remove d-flex justify-content-between align-items-center ">
                                        <x-forms.label name="about_video_thumb" required="false" />

                                        <button title="{{ __('delete_image') }}"
                                            onclick="deleteAboutBackgroundThumb('{{ urlencode($cms->about_video_thumb) }}');"
                                            class="bg-transparent  border-0 text-decoration-underline nav-underline font-weight-bold text-info mb-2">
                                            <u>{{ __('delete_image') }}</u>
                                        </button>
                                    </div>

                                    <div class="">
                                        <input type="file" class="form-control dropify"
                                            data-default-file="{{ $aboutVideoThumb }}" name="about_video_thumb"
                                            autocomplete="image" data-allowed-file-extensions="jpg png jpeg"
                                            accept="image/png, image/jpg, image/jpeg">
                                        <p class="text-black-50"><strong class="text-danger">Note:</strong> Please keep
                                            in mind this thubnail/poster is for the video url. If you don't like to
                                            upload video url, then please skip uploading thumbnail/poster!</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <x-forms.label name="about_body" required="false" />
                                <div class="">
                                    <textarea id="about_ck" class="form-control" name="about_body" placeholder="{{ __('write_the_answer') }}">{{ $aboutcontent }}</textarea>
                                    @error('about_body')
                                        <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-sync"></i> {{ __('update_about_setting') }}
                            </button>
                        </div>
                    </div>
                </form>

                <!-- About Video Thumb delete form -->
                <form id="deleteAboutBackgroundThumb" action="{{ route('about_video_thumb_delete') }}"
                    method="POST" class="d-inline">
                    @method('DELETE')
                    @csrf
                </form>

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

        // Destroy existing Dropzone instances for About Setting
        if (Dropzone.instances.length > 0) {
            Dropzone.instances.forEach(function(instance) {
                // Disable autoDiscover to prevent automatic initialization
                Dropzone.autoDiscover = false;
                instance.destroy();
            });
        }

        // Initialize Dropzone for About Setting
        var myDropzoneAbout = new Dropzone("#dropzoneFormAbout", {
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
                myDropzone = this;
                $('#submit-about-img').on('click', function() {
                    myDropzone.processQueue();
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
            $("#sortableAbout").sortable({
                items: 'tr',
                cursor: 'move',
                opacity: 0.4,
                scroll: false,
                dropOnEmpty: false,
                update: function() {
                    sendTaskOrderToServer('#sortableAbout tr');
                },
                classes: {
                    "ui-sortable": "highlight"
                },
            });
            $("#sortableAbout").disableSelection();

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
                    url: "{{ route('admin.about.slider.sorting') }}",
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

    <!-- About Video Thumb delete Script -->
    <script>
        function deleteAboutBackgroundThumb(encodedImage) {
            if (confirm('{{ __('are_you_sure') }}?')) {
                var deleteForm = document.getElementById('deleteAboutBackgroundThumb');
                deleteForm.action = '{{ route('about_video_thumb_delete') }}?image=' + encodedImage;

                // Submit the form
                deleteForm.submit();
            }
        }
    </script>
    <!-- About Video Thumb delete Script -->
@endpush
