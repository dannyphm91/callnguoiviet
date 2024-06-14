<div class="product-item__sidebar-item user-details">
    <div class="d-flex justify-content-between">

        <div class="user">
            <div class="img position-relative">
                @if ($customer->image)
                    <img src="{{ asset($customer->image) }}" alt="">
                @else
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/1024px-User-avatar.svg.png"
                        alt="user-photo" />
                @endif
                @if ($customer->document_verified && $customer->document_verified->status == 'approved')
                    <span style="width: 20px; height:20px" class="verify-badge3">
                        <x-svg.account-verification.verified-badge />
                    </span>
                @endif
            </div>
            <div class="info">
                <span class="text--body-4">{{ __('added_by') }}:</span>
                <h2 class="text--body-3-600">
                    {{ $customer->name }}
                    @if (hasMemberBadge($customer->id))
                        <x-svg.verified-seller-badge-icon />
                    @endif
                </h2>
            </div>
        </div>
        <a href="{{ route('frontend.seller.profile', $customer->username) }}">{{ __('view_profile') }}</a>
    </div>
    <ul class="contact">
        <li class="contact-item">
            <span class="icon">
                <x-svg.envelope-icon />
            </span>
            <h6 class="text--body-3">{{ $customer->email }}</h6>
        </li>
        <li class="contact-item">
            <span class="icon">
                <x-svg.address-icon />
            </span>
            <h6 class="text--body-3">{{ $ad->region }} {{ $ad->region ? ', ' : '' }} {{ $ad->country }}</h6>
        </li>
        @if (!is_null($link))
            <li class="contact-item">
                <span class="icon">
                    <x-svg.globe-icon />
                </span>
                <a target="_blank" href="{{ $link }}" class="text--body-3">
                    {{ $link }}
                    <span class="icon">
                        <x-svg.target-blank-icon />
                    </span>
                </a>
            </li>
        @endif
    </ul>

    <!-- Report Ad Modal Button Start -->
    @if (auth('user')->check() && $ad->user_id !== auth('user')->user()->id)
        <hr>
        <div class="dashboard__navigation-report seller-dashboard__navigation-bottom">
            <div class="report">
                <button class="seller-dashboard__nav-link" data-bs-toggle="modal" data-bs-target="#reportAdModal">
                    <span class="icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 9.75V13.5" stroke="#767E94" stroke-width="1.6" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M10.7018 3.74857L2.45399 17.9978C2.32201 18.2258 2.25242 18.4846 2.2522 18.748C2.25198 19.0115 2.32115 19.2703 2.45275 19.4986C2.58434 19.7268 2.77373 19.9163 3.00184 20.0481C3.22996 20.1799 3.48876 20.2493 3.7522 20.2493H20.2477C20.5112 20.2493 20.77 20.1799 20.9981 20.0481C21.2262 19.9163 21.4156 19.7268 21.5472 19.4986C21.6788 19.2703 21.748 19.0115 21.7478 18.748C21.7475 18.4846 21.6779 18.2258 21.546 17.9978L13.2982 3.74857C13.1664 3.52093 12.9771 3.33193 12.7493 3.20055C12.5214 3.06916 12.263 3 12 3C11.7369 3 11.4785 3.06916 11.2507 3.20055C11.0228 3.33193 10.8335 3.52093 10.7018 3.74857V3.74857Z"
                                stroke="#767E94" stroke-width="1.6" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M12 18C12.6213 18 13.125 17.4963 13.125 16.875C13.125 16.2537 12.6213 15.75 12 15.75C11.3787 15.75 10.875 16.2537 10.875 16.875C10.875 17.4963 11.3787 18 12 18Z"
                                fill="#767E94" />
                        </svg>
                    </span>
                    {{ __('report_ad') }}
                </button>
            </div>
        </div>
    @endif
    <!-- Report Ad Modal Button End -->

</div>

<!-- Report Ad Modal Start -->
<div class="modal fade report-modal" id="reportAdModal" tabindex="-1" aria-labelledby="reportAdModalLabel"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('frontend.adReport') }}" method="post" class="report-modal-form">
                @csrf
                <input type="hidden" name="ad_id" value="{{ $ad->id }}">

                <div class="modal-body pt-0">

                    <h4 class="modal-title fw-bold text-center mb-3">{{ __('report_for_ad') }}</h4>

                    <!-- Display flash messages -->
                    <div class="flash-messages"></div>

                    <div class="form-group">
                        <label class="form-label fw-bolder" for="report_type">{{ __('i_would_like_to_report_for') }}</label>

                        <div class="mb-3">
                            <select name="report_type" id="report_type" class="form-select form-control" aria-label="Default select example">
                                <option value="" selected>{{ __('select_report_reason')}}</option>

                                @foreach ($ad_report_categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label fw-bolder" for="report_description">{{ __('report_description') }}</label>
                        <textarea name="report_description" id="report_description" rows="8" required class="form-control @error('report_description') is-invalid border-danger @enderror" placeholder="{{ __('type_report_description_here') }}"></textarea>
                        @error('report_description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer justify-center pt-0 border-top-0">
                    <button type="submit" id="submit-button" class="btn ad-report-submit-btn w-100">{{ __('submit_for_review') }}</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- Report Ad Modal End -->

@section('frontend_script')
    <script>
        // Reson modal script start
        $(document).ready(function() {
            $('#submit-button').click(function(e) {
                e.preventDefault();

                var form = $('#reportAdModal form');
                var formData = form.serialize();

                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: formData,
                    success: function(data) {
                        // Clear existing flash messages
                        $('.flash-messages').empty();

                        if (data.success) {
                            // Create a text node with the message
                            var successMessage = document.createTextNode(data.message);
                            var successAlert = $('<div class="alert alert-success"></div>').append(successMessage);
                            // Append the success message to the flash-messages element
                            $('.flash-messages').append(successAlert);

                            // Optionally, you can clear the form or close the modal here
                            $('#report_type').val(''); // Clear the textarea
                            $('#report_description').val(''); // Clear the textarea
                        } else {
                            // Create a text node with the message
                            var errorMessage = document.createTextNode(data.message);
                            var errorAlert = $('<div class="alert alert-danger"></div>').append(errorMessage);
                            // Append the error message to the flash-messages element
                            $('.flash-messages').append(errorAlert);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        $('.flash-messages').empty();
                        if (xhr.status === 422) {
                            // If the status code is 422 (validation error), display validation errors
                            var errors = JSON.parse(xhr.responseText);
                            var errorHtml = '<div class="alert alert-danger"><ul>';
                            $.each(errors.errors, function(key, value) {
                                errorHtml += '<li>' + value + '</li>';
                            });
                            errorHtml += '</ul></div>';
                            $('.flash-messages').html(errorHtml);
                        } else {
                            // Handle other errors
                            // Create a text node with the error message
                            var errorText = document.createTextNode('An error occurred: ' + error);
                            var errorAlert = $('<div class="alert alert-danger"></div>').append(errorText);
                            // Append the error message to the flash-messages element
                            $('.flash-messages').append(errorAlert);
                        }
                    }
                });
            });
        });
        // Reson modal script end
    </script>
@endsection
