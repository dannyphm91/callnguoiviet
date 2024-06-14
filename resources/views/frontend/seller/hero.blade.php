<div class="seller-hero-area border border-gray-100 dark:border-gray-600 p-6 rounded-lg shadow-[0px_4px_8px_0px_rgba(28,33,38,0.08)] bg-white dark:bg-gray-900">
    <div class="flex flex-wrap items-center gap-5 justify-between">
        <div class="flex  gap-4 items-center">
            <div class="bg-error-100 py-5 px-8 rounded-md heading-03">{{ $rating_details['average'] }}</div>
            <div>
                <div class="flex gap-1 items-center mb-2">
                    @for ($i = 0; $i < $rating_details['average']; $i++)
                        <x-frontend.icons.star-yellow />
                    @endfor
                </div>
                <p class="heading-07 mb-0.5 text-gray-900 dark:text-white">{{ $rating_details['average'] }} {{ __('star_average_rating') }}</p>
                <p class="body-sm-400 text-gray-600 dark:text-gray-300">{{ $rating_details['total'] }} {{ __('people_written_reviews') }}</p>
            </div>
        </div>

        <!-- Write review Button If Authenticate -->
        @if ( auth()->check() && $user->id != auth()->id())
        <div>
            @if (!$already_review)
            <button type="button" data-modal-target="review-modal" data-modal-toggle="review-modal"
            class="btn-primary">{{ __('write_review') }}</button>
            @endif
            {{-- <x-frontend.modals.review-modal /> --}}

            <div id="review-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 bg-black/50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">

                        <form action="{{ route('frontend.seller.review') }}" method="post">
                            @csrf
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 rounded-t">
                                <h3 class="text-xl font-semibold text-gray-900 ">{{ __('write_review') }}</h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                                    data-modal-hide="review-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>

                            <!-- displaying flash messages -->
                            <div class="flash-messages px-4"></div>

                            <div class="p-4 pt-0 space-y-4">
                                <h6 class="heading-06 text-gray-900">{{ __('ratings') }}:</h6>
                                <div id="rateYo"></div>
                                @error('stars')
                                    <span class="invalid-feedback d-block text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <input type="hidden" name="stars" id="rating" value="{{ old('stars') }}">
                            <input type="hidden" name="seller_id" value="{{ $user->id }}">
                            <input type="hidden" name="seller_username" value="{{ $user->username }}">

                            <div class="p-4 md:p-5 space-y-4">
                                <textarea name="comment" rows="4" id="description"
                                    class="@error('comment') border-danger @enderror block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-100 focus:ring-blue-500 "
                                    placeholder="{{ __('your_review') }}"></textarea>
                                @error('comment')
                                    <span class="invalid-feedback d-block text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="p-4 md:p-5 space-y-4">
                                <h6 class="heading-06 text-gray-900">Ratings:</h6>
                                <div id="review-star"></div>
                            </div> --}}
                            <div class="flex items-center p-4 md:p-5 rounded-b">
                                <button id="submit-rating-review" type="submit" class="btn-primary">
                                    {{ __('publish_review') }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
        @endif
        <!-- Write review Button If Authenticate -->

        <!-- Write review Button If Unauthorize -->
        @if ( !auth('user')->check() && $user->id != auth('user')->id())
            <a href="{{ route('users.login') }}" class="login_required btn-primary">
                {{ __('write_review') }}
            </a>
        @endif
        <!-- Write review Button If Unauthorize -->

        <div class="bg-primary-50 dark:bg-gray-700 flex justify-between items-center gap-8 p-6 rounded-md">
            <div>
                <h2 class="heading-06 dark:text-white mb-2">{{ $total_active_ad }}</h2>
                <p class="body-md-400 text-gray-600 dark:text-gray-300">{{ __('active_ads') }}</p>
            </div>
            <div
                class="bg-white text-primary-500 w-14 h-14 rounded-md inline-flex justify-center items-center">
                <x-frontend.icons.outline-document />
            </div>
        </div>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('backend/css/jquery.rateyo.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('backend/js/jquery.rateyo.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#rateYo").rateYo({
                starWidth: '30px',
                fullStar: true,
                mormalFill: 'yellow',
                ratedFill: 'orange',
                onSet: function(rating, rateYoInstance) {
                    $('#rating').val(rating);
                }
            });
        });
    </script>
    <script>
        setTimeout(() => {
            $('.jq-ry-normal-group').addClass('d-flex');
            $('.jq-ry-normal-group').addClass('gap-1');
        }, 1000);
    </script>

    <script>
        // Submit Rating modal script start
        $(document).ready(function() {
            $('#submit-rating-review').click(function(e) {
                e.preventDefault();

                var form = $('#review-modal form');
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
                            var successAlert = $(
                                '<div class="rounded-md bg-green-50 p-4 text-green-800"></div>'
                                ).append(successMessage);
                            // Append the success message to the flash-messages element
                            //$('.flash-messages').append(successAlert);
                            // Optionally, you can clear the form or close the modal here
                            //$('#description').val(''); // Clear the textarea
                            //$('#rating').val(''); // Clear the stars rating
                            window.location.href = data.redirectUrl;
                        } else {
                            // Create a text node with the message
                            var errorMessage = document.createTextNode(data.message);
                            var errorAlert = $(
                                    '<div class="rounded-md bg-red-50 p-4 text-red-800"></div>')
                                .append(errorMessage);
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
                            var errorHtml =
                                '<div class="rounded-md bg-red-50 p-4 text-red-800"><ul>';
                            $.each(errors.errors, function(key, value) {
                                errorHtml += '<li>' + value + '</li>';
                            });
                            errorHtml += '</ul></div>';
                            $('.flash-messages').html(errorHtml);
                        } else {
                            // Handle other errors
                            // Create a text node with the error message
                            var errorText = document.createTextNode('An error occurred: ' +
                                error);
                            var errorAlert = $(
                                    '<div class="rounded-md bg-red-50 p-4 text-red-700"></div>')
                                .append(errorText);
                            // Append the error message to the flash-messages element
                            $('.flash-messages').append(errorAlert);
                        }
                    }
                });
            });
        });
        // Submit Rating script end
    </script>

@endpush
