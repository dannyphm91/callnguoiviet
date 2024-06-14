@extends('admin.settings.setting-layout')
@section('title')
    {{ __('advertisement_settings') }}
@endsection

@section('breadcrumbs')
    <div class="row mb-2 mt-4">
        <div class="col-sm-6">
            <h1 class="m-0">{{ __('settings') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('home') }}</a></li>
                <li class="breadcrumb-item">{{ __('settings') }}</li>
                <li class="breadcrumb-item active">{{ __('advertisement') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('website-settings')

    <div class="alert alert-warning mb-3">
        <h5>{{ __('place_your_advertising_networks_code') }}</h5>
        <hr class="my-2">
        {{ __('ad_code_is_a_piece_of_html_or_javascript_that_you_can_place_on_your_website_to_display_advertisements_with_ad_code_you_can_earn_revenue_by_displaying_ads_from_various_advertising_networks_like_google_adsense_which_matches_relevant_ads_to_the_content_on_your_website') }}. <strong>{{ __('click_the_eye_icon_to_see_position_place') }}</strong>.
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title" style="line-height: 36px;">{{ __('advertisement_settings') }}</h3>
        </div>
        <form action="{{ route('advertisement.update', 1) }}" class="card-body" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row justify-content-center">
                @foreach ($ads as $ad)
                    <input type="hidden" class="d-none" name="page_slug[]" value="{{ $ad->page_slug }}">
                    <div class="col-12 col-md-6 mb-4">
                        <div class="row mb-2">
                            <div class="col-lg-6">
                                <label for="" class="">
                                    <span id="span_text">
                                        {{ Str::ucfirst(str_replace('_', ' ', $ad->page_slug)) }}
                                    </span>
                                    <span onclick="showPlaceDemo('{{ Str::ucfirst(str_replace('_', ' ', $ad->page_slug)) }}','{{ $ad->example_image_url }}')" class="mt-2 ml-2">
                                        <i class="fas fa-eye fa-lg p-1 text-info cursor-pointer"></i>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-6 text-right">
                                <input type="checkbox" style="float:right;" 
                                 name="{{$ad->page_slug}}"
                                data-id="{{$ad->id}}" {{($ad->status == 0 ) ? '' : 'checked'}}
                                    data-bootstrap-switch>
                            </div>
                        </div>
                        <textarea name="ad_code[]" rows="4" class="form-control">{{ $ad->ad_code }}</textarea>
                    </div>
                @endforeach
            </div>
            <div class="row justify-content-center">
                <div class="col-4 text-center">
                    <button type="submit" class="btn btn-primary mt-3" style="width: 200px; height: 50px;">
                        <x-svg.check-icon height="24px" width="24px" />
                        {{ __('save') }}
                    </button>
                </div>
            </div>
        </form>
        <!-- example image show modal  -->
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="advertise_ttile">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <img id="place_image" src="" alt="" style="width:400px;height:500px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- example image show modal  -->
    </div>
@endsection
@section('style')
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@endsection
@section('script')
    <script>
        function showPlaceDemo(title,image) {
            $('#advertise_ttile').text('');
            $('#advertise_ttile').text(title);
            if(title=='Home page inside ad'){
                document.getElementById("place_image").src = 
                '{{ URL::to('/') }}' + '/'+'dummy/adsense/modal_home_page.png';
            }else if(title=='Home page center'){
                document.getElementById("place_image").src = 
                '{{ URL::to('/') }}' + '/'+'dummy/adsense/modal_home_center.png';
            }
            else if(title=='Ad listing page left'){
                document.getElementById("place_image").src = 
                '{{ URL::to('/') }}' + '/'+'dummy/adsense/modal_ad_left.png';
            }
            else if(title=='Ad listing page inside ad'){
                document.getElementById("place_image").src = 
                '{{ URL::to('/') }}' + '/'+'dummy/adsense/modal_ad_pageright.png';
            }else if(title=='Ad listing page right '){
                document.getElementById("place_image").src = 
                '{{ URL::to('/') }}' + '/'+'dummy/adsense/modal_ad_left.png';
            }else if(title=='Blog page left'){
                document.getElementById("place_image").src = 
                '{{ URL::to('/') }}' + '/'+'dummy/adsense/modal_blogleft.png';
            }else if(title=='Blog page inside blog'){
                document.getElementById("place_image").src = 
                '{{ URL::to('/') }}' + '/'+'dummy/adsense/modal_blog_inside.png';
            }else if(title=='Blog detail page right'){
                document.getElementById("place_image").src = 
                '{{ URL::to('/') }}' + '/'+'dummy/adsense/modal_blogdetail.png';
                
            }
            
           
          
            $('#staticBackdrop').modal('show');
        }
    </script>
    <script src="{{ asset('backend') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script>
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('#buttonOne').prop('disabled', true);
        $('#buttonTwo').prop('disabled', true);
        $('#buttonThree').prop('disabled', true);
        $('#buttonFour').prop('disabled', true);
        $('#buttonFive').prop('disabled', true);

        function ButtonDisabled(id, input, data) {
            let inputVal = $('[name=' + input + ']').val();
            if (inputVal == data) {
                $('#' + id).prop('disabled', true);
            } else {
                $('#' + id).prop('disabled', false);
            }
        }

        $("input[data-bootstrap-switch]").on('switchChange.bootstrapSwitch', function(event, state) {
            var text ;
            let input = $(this).attr('name');
            let status = state ? 1 : 0;
            //var text= $("input[name=" + input + "]").val();
            var id = $(this).data('id'); ;
            console.log(input+status+text+id);
           
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.adstatus.update') }}",
                data: {
                    _method:'PUT',
                    'id': id,
                    'status': status,
                    _token: '{!! csrf_token() !!}'
                },
                success: function(response) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            });
        });
        
    </script>
@endsection
