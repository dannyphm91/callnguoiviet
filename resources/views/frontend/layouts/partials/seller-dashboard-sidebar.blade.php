<div
    class="mx-auto flex flex-col md:flex-row py-6 rounded-xl border border-gray-100 dark:border-gray-600 w-full shadow-[0px_4px_8px_0px_rgba(28,33,38,0.08)] bg-white dark:bg-gray-900">

    <div class="flex flex-col gap-6">
        <div class="px-6 flex items-center gap-4">
            <img class="w-20 h-20 rounded-full object-cover" src="{{ $user->image_url }}" alt="">
            <div class="flex flex-col gap-1">
                <h3 class="heading-06 text-gray-900 dark:text-white"> {{ $user->name }}</h3>
                <p class="body-md-400 text-gray-600 dark:text-gray-300">{{ __('member_since') }}
                    {{ $user->created_at->format('M, Y') }}</p>

                @if (hasMemberBadge($user->id))
                    <span class="flex items-center gap-[0.25rem] caption-04 text-success-500">
                        <x-frontend.icons.check-badge />
                        {{ __('verified_customer') }}
                    </span>
                @endif
            </div>
        </div>

        @if ($user->web)
            <div class="w-full">
                <a href="{{ $user->web }}"
                    class="bg-primary-50 dark:bg-gray-700 hover:bg-primary-500 transition-all duration-300 px-6 py-3 text-primary-500 dark:text-primary-300 hover:text-white w-full flex items-center gap-2 heading-07"
                    style="border-bottom: 2px solid var(--primary-500);">
                    <x-frontend.icons.arrow-square-up />
                    <span>{{ $user->web }}</span>
                </a>
            </div>
        @endif

        @if ($user->bio)
            <div class="p-6 pt-0 flex flex-col gap-2">
                <h6 class="heading-07 text-gray-900 dark:text-white">{{ __('about_seller') }}</h6>
                <p class="body-md-400 text-gray-700 dark:text-gray-200">{{ $user->bio }}</p>
            </div>
        @endif
    </div>

    <div class="px-[1.5rem] md:border-s md:border-t-0 border-t border-gray-100 md:pt-0 pt-6 space-y-[0.75rem] w-full">
        <h6 class="heading-07 text-gray-900 dark:text-white">{{ __('contact_information') }}</h6>
        <div class="divide-y divide-gray-100">

            @if ($user->phone)
                <div class="flex items-start space-x-[0.75rem] pb-[1rem]">
                    <span>
                        <x-frontend.icons.phone-blue />
                    </span>
                    <div class="space-y-[0.13rem]">
                        <small
                            class="body-xs-500 text-gray-500 dark:text-gray-200 leading-[1rem] uppercase">{{ __('phone_number') }}</small>
                        <p class="body-md-500 leading-[1.5rem] text-gray-900 dark:text-white">{{ $user->phone }}</p>
                    </div>
                </div>
            @endif

            @if ($user->email)
                <div class="flex items-start space-x-[0.75rem] py-[1rem]">
                    <span>
                        <x-frontend.icons.email-blue />
                    </span>
                    <div class="space-y-[0.13rem]">
                        <small
                            class="body-xs-500 text-gray-500 dark:text-gray-200 leading-[1rem] uppercase">{{ __('email_address') }}</small>
                        <p class="body-md-500 leading-[1.5rem] text-gray-900 dark:text-white">{{ $user->email }}</p>
                    </div>
                </div>
            @endif

            @if ($user->address)
                <div class="flex items-start space-x-[0.75rem] pt-[1rem]">
                    <span>
                        <x-frontend.icons.map-blue />
                    </span>
                    <div class="space-y-[0.13rem]">
                        <small
                            class="body-xs-500 text-gray-500 dark:text-gray-200 leading-[1rem] uppercase">{{ __('address') }}</small>
                        <p class="body-md-500 leading-[1.5rem] text-gray-900 dark:text-white">{{ $user->address }}</p>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Report Seller Button If Authenticated -->
    @if (auth('user')->check() && $user->id != auth('user')->id())
        <button type="button" data-modal-target="report-seller-modal" data-modal-toggle="report-seller-modal"
            class="flex items-center text-gray-400 mody-md-500 gap-3 w-full px-6">
            <x-frontend.icons.warning />
            {{ __('report_seller') }}
        </button>

        <!-- Modal Start -->
        <div id="report-seller-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 bg-black/50 justify-center items-center w-full md:inset-0 h-[calc(100%)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <form action="{{ route('frontend.seller.report') }}" method="post" class="report-modal-form">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="username" value="{{ $user->username }}">

                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 rounded-t ">
                            <h3 class="text-xl font-semibold text-gray-900 ">{{ __('report_seller') }}</h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                                data-modal-hide="report-seller-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>

                        <!-- displaying flash messages -->
                        <div class="flash-messages-report-seller px-4"></div>

                        <div class="p-4 space-y-4">
                            <label for="reasonn">{{ __('reason') }}</label>
                            <textarea name="reason" id="reasonn" required rows="6"
                                class="@error('reason') is-invalid border-danger @enderror block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-100 focus:ring-blue-500 "
                                placeholder="{{ __('type_report_description_here') }}"></textarea>

                            @error('reason')
                                <span class=" text-red-600">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="flex items-center p-4 md:p-5 rounded-b ">
                            <button id="submit-button" type="button" class="btn-primary">
                                {{ __('submit') }}
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal End -->
    @endif
    <!-- Report Seller Button If Authenticated -->

    <!-- Report Seller Button If Unauthorize -->
    @if (!auth('user')->check() && $user->id != auth('user')->id())
        <a href="{{ route('users.login') }}"
            class="login_required flex items-center text-gray-400 mody-md-500 gap-3 w-full px-6">
            <x-frontend.icons.warning />
            {{ __('report_seller') }}
        </a>
    @endif
    <!-- Report Seller Button If Unauthorize -->

</div>

@push('js')
    <script>
        // Reson modal script start
        $(document).ready(function() {
            $('#submit-button').click(function(e) {
                e.preventDefault();

                var form = $('#report-seller-modal form');
                var formData = form.serialize();

                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: formData,
                    success: function(data) {
                        // Clear existing flash messages
                        $('.flash-messages-report-seller').empty();

                        if (data.success) {
                            // Create a text node with the message
                            var successMessage = document.createTextNode(data.message);
                            var successAlert = $(
                                '<div class="rounded-md bg-green-50 p-4 text-green-800"></div>'
                            ).append(successMessage);
                            // Append the success message to the flash-messages element
                            // $('.flash-messages-report-seller').append(successAlert);

                            // Optionally, you can clear the form or close the modal here
                            $('#reasonn').val(''); // Clear the textarea
                            window.location.href = data.redirectUrl;

                        } else {
                            // Create a text node with the message
                            var errorMessage = document.createTextNode(data.message);
                            var errorAlert = $(
                                    '<div class="rounded-md bg-red-50 p-4 text-red-800"></div>')
                                .append(errorMessage);
                            // Append the error message to the flash-messages element
                            $('.flash-messages-report-seller').append(errorAlert);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX error
                        $('.flash-messages-report-seller').empty();
                        if (xhr.status === 422) {
                            // If the status code is 422 (validation error), display validation errors
                            var errors = JSON.parse(xhr.responseText);
                            var errorHtml =
                                '<div class="rounded-md bg-red-50 p-4 text-red-800"><ul>';
                            $.each(errors.errors, function(key, value) {
                                errorHtml += '<li>' + value + '</li>';
                            });
                            errorHtml += '</ul></div>';
                            $('.flash-messages-report-seller').html(errorHtml);
                        } else {
                            // Handle other errors
                            // Create a text node with the error message
                            var errorText = document.createTextNode('An error occurred: ' +
                                error);
                            var errorAlert = $(
                                    '<div class="rounded-md bg-red-50 p-4 text-red-700"></div>')
                                .append(errorText);
                            // Append the error message to the flash-messages element
                            $('.flash-messages-report-seller').append(errorAlert);
                        }
                    }
                });
            });
        });
        // Reson modal script end
    </script>
@endpush
