<form class="form-horizontal" action="{{ route('admin.ads.update') }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="card">
        <div class="card-header">
            {{ __('ads') }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <x-forms.label name="ads_background" />
                        <input type="file" class="form-control dropify"
                            data-default-file="{{ $cms->ads_background }}" name="ads_background" autocomplete="image"
                            data-allowed-file-extensions="jpg png jpeg" accept="image/png, image/jpg, image/jpeg">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <x-forms.label name="ads_safety_msg" :required="false" />
                        <textarea name="ads_safety_msg" class="form-control" cols="10" rows="8">{{ $cms->ads_safety_msg }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-sync"></i> {{ __('update_ads_settings') }}
                </button>
            </div>
        </div>
    </div>
</form>
