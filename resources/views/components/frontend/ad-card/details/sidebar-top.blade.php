@props([
    'ad' => null,
    'hidereport' => false,
])

<div class="border border-gray-100 rounded-l-lg">
    <div class="flex flex-col">
        <div class="pt-5 pb-4 px-5">
            <h3 class="text-error-500 heading-04 mb-1">
                {{ changeCurrency($ad?->price) }}
            </h3>
        </div>
        <div class="py-4 px-5 bg-gray-50" x-data="{ reveal: false }" @click="reveal= !reveal" role="button">
            <h4 class="text-lg leading-6 font-semibold" :class="reveal ? 'mb-0' : 'mb-1'">
                <span x-show="!reveal" x-cloak>
                    {{ $ad?->phone ? Str::limit($ad?->phone, 4, 'XXXXXX') : 'xxxxx' }}
                </span>
                <span x-show="reveal" x-cloak>{{ $ad?->phone }}</span>
            </h4>
            <span class="text-gray-600 body-xs-400" x-cloak x-transition
                x-show="!reveal">{{ __('reveal_phone_number') }}</span>
        </div>
        <div class="py-4 px-5 flex flex-col gap-3">
            @if (auth('user')->check())
                <button type="button" class="btn-primary w-full"
                    data-modal-target="messsageSendModal{{ $ad->id }}"
                    data-modal-toggle="messsageSendModal{{ $ad->id }}">
                    <x-frontend.icons.chat />
                    <span>{{ __('send_message') }}</span>
                </button>
            @else
                <a href="{{ route('users.login') }}" class="btn-primary w-full login_required">
                    <x-frontend.icons.chat />
                    <span>{{ __('send_message') }}</span>
                </a>
            @endif
            {{-- @if (auth('user')->check() && auth('user')->user()->username !== $ad->customer->username)
                <button type="button" class="btn-primary w-full" data-modal-target="messsageSendModal{{ $ad->id }}" data-modal-toggle="messsageSendModal{{ $ad->id }}">
                    <x-frontend.icons.chat />
                    <span>{{ __('send_message') }}</span>
                </button>
            @else
                <a href="{{ route('users.login') }}" class="btn-primary w-full login_required">
                    <x-frontend.icons.chat />
                    <span>{{ __('send_message') }}</span>
                </a>
            @endif --}}
            @if ($ad->whatsapp)
                <a target="_blank" href="https://wa.me/{{ $ad->whatsapp }}"
                    class="btn-secondary w-full hover:bg-success-50 text-success-500 !border-success-500">
                    <x-frontend.icons.whatsapp />
                    <span>{{ __('whatsapp_message') }}</span>
                </a>
            @endif
            @if ($ad->email)
                <a href="mailto:{{ $ad->email }}"
                    class="flex gap-2 heading-07 text-gray-700 hover:text-primary-500 justify-center items-center">
                    <x-frontend.icons.envelope />
                    <span>{{ __('email') }}</span>
                </a>
            @endif
        </div>
        <a href="{{ route('frontend.seller.profile', $ad?->customer?->username) }}"
            class="group hover:bg-primary-50 dark:hover:bg-gray-500 transition-all duration-300 py-4 px-5 border-t border-gray-100">
            <div class="flex gap-2.5 items-center">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ asset($ad?->customer?->image) }}"
                    alt="">
                <div>
                    <h3 class="body-md-500 group-hover:text-primary-500 text-gray-900 dark:text-white">
                        {{ $ad?->customer?->name ?? '' }}
                    </h3>
                    <div class="body-sm-400 text-gray-500 dark:text-gray-100 flex items-center">
                        @if (hasMemberBadge($ad?->customer?->id))
                            <x-svg.verified-seller-badge-icon />
                        @endif
                        <span>{{ __('seller') }}</span>
                    </div>
                </div>

            </div>
        </a>

        <!-- Report Ad Modal Button Start -->
        @if (!$hidereport && auth('user')->check() && $ad->user_id !== auth('user')->user()->id)
            <div class="report py-4 px-5 border-t border-gray-100">
                <button type="button" data-modal-target="reportAdModal{{ $ad->id }}"
                    data-modal-toggle="reportAdModal{{ $ad->id }}"
                    class="inline-flex justify-center items-center">
                    <span class="icon mr-1">
                        <x-frontend.icons.warning stroke="#767E94" />
                    </span>
                    {{ __('report_ad') }}
                </button>
            </div>
        @endif
        <!-- Report Ad Modal Button End -->

        <!-- Report Ad Button If Unauthorize -->
        @if (!$hidereport && !auth('user')->check() && $ad->user_id != auth('user')->id())
            <div class="report py-4 px-5 border-t border-gray-100">
                <a href="{{ route('users.login') }}" class="login_required inline-flex justify-center items-center">
                    <span class="icon mr-1">
                        <x-frontend.icons.warning stroke="#767E94" />
                    </span>
                    {{ __('report_ad') }}
                </a>
            </div>
        @endif
        <!-- Report Ad Button If Unauthorize -->

    </div>
</div>
@if ($cms->ads_safety_msg)
    <div class="flex items-center p-4 text-sm text-yellow-800 rounded-lg bg-yellow-200 dark:bg-gray-800 dark:text-yellow-300"
        role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="currentColor" viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <div>
            <span
                class="font-medium">{{ __('never_prepay_for_deliveries_physically_inspect_goods_and_sellers_before_payment_templatecookie_connects_buyers_and_sellers_not_responsible_for_transactions') }}</span>
        </div>
    </div>
@endif

<!-- Report Ad Modal Start -->
@if (!$hidereport)
    <div id="reportAdModal{{ $ad->id }}" tabindex="-1" aria-hidden="true"
        class="report-modal hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 bg-black/50 justify-center items-center w-full md:inset-0 h-[calc(100%)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">

                <form action="{{ route('frontend.adReport') }}" method="post" x-data="{ report_type: '', report_description: '' }">
                    @csrf
                    <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                    <input type="hidden" name="ad_slug" value="{{ $ad->slug }}">


                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">{{ __('report_for_ad') }}</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                            data-modal-hide="reportAdModal{{ $ad->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>

                    <!-- displaying flash messages -->
                    <div class="flash-messages p-4 pt-0 space-y-4"></div>
                    <div class="p-4 pt-0 space-y-4">
                        <label class="block text-sm font-medium leading-6 text-gray-900"
                            for="report_type">{{ __('i_would_like_to_report_for') }}</label>

                        <div class="mb-3">
                            <select x-model="report_type" name="report_type" id="report_type"
                                class="block w-full text-sm text-gray-900 rounded-lg border border-gray-100 focus:ring-blue-500"
                                aria-label="Default select example">
                                <option value="" selected>{{ __('select_report_reason') }}</option>

                                @foreach ($ad_report_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="p-4 pt-0 space-y-4">
                        <label class="block text-sm font-medium leading-6 text-gray-900"
                            for="report_description">{{ __('report_description') }}</label>
                        <textarea x-model="report_description" name="report_description" id="report_description" rows="8" required
                            class="@error('report_description') border-red-600 focus:ring-red-600 @else border-gray-100 focus:ring-blue-500 @enderror block w-full text-sm text-gray-900 rounded-lg border"
                            placeholder="{{ __('type_report_description_here') }}"></textarea>
                        @error('report_description')
                            <span class="invalid-feedback d-block text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-center p-4 pt-3 rounded-b">
                        <button :disabled="!report_type.length || !report_description.length" id="submit-button"
                            type="submit" class="btn-primary ad-report-submit-btn">
                            {{ __('submit_for_review') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endif
<!-- Report Ad Modal End -->

@php
    $not_same_user = auth('user')->check() && $ad && $ad?->customer && auth('user')->user()->username !== $ad->customer->username;
@endphp

<!-- Messenger Modal Start -->
@auth
    <div id="messsageSendModal{{ $ad->id }}" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[999] bg-black/50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full" x-data="{ meseage: '' }">
            <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow">
                <form action="{{ $not_same_user ? route('frontend.message.send') : url()->current() }}"
                    method="{{ $not_same_user ? 'post' : 'get' }}">
                    @csrf
                    <input type="hidden" name="to_id" value="{{ $ad->user_id }}">
                    <input type="hidden" name="ad_id" value="{{ $ad->id }}">

                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 rounded-t ">
                        <h3 class="text-xl font-semibold text-gray-900 ">{{ __('send_message') }}</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                            data-modal-hide="messsageSendModal{{ $ad->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-4 md:p-5 space-y-4">
                        <label for="meseage">{{ __('message') }}</label>
                        <textarea x-model="meseage" required name="body" id="meseage" required rows="6"
                            class=" block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-100 focus:ring-blue-500 "
                            placeholder="{{ __('send_message') }}..."></textarea>
                    </div>

                    <div class="flex items-center p-4 md:p-5 rounded-b ">
                        @if ($not_same_user)
                            <button :disabled="!meseage.length" type="submit" class="btn-primary">
                                {{ __('send') }}
                            </button>
                        @else
                            <span>
                                {{ __('you_cant_send_message_to_yourself') }}
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endauth
<!-- Messenger Modal End -->

@push('js')
    <script>
        // Reson modal script start
        $(document).ready(function() {
            $('#submit-button').click(function(e) {
                e.preventDefault();

                var form = $('#reportAdModal{{ $ad->id }} form');
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
                                )
                                .append(successMessage);
                            // Append the success message to the flash-messages element
                            // $('.flash-messages').append(successAlert);

                            // Optionally, you can clear the form or close the modal here
                            $('#report_type').val(''); // Clear the textarea
                            $('#report_description').val(''); // Clear the textarea
                            window.location.href = data.redirectUrl;
                        } else {
                            // Create a text node with the message
                            var errorMessage = document.createTextNode(data.message);
                            var errorAlert = $(
                                    '<div class="rounded-md bg-red-50 p-4 text-red-800"></div>')
                                .append(
                                    errorMessage);
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
                                    '<div class="rounded-md bg-red-50 p-4 text-red-800"></div>')
                                .append(
                                    errorText);
                            // Append the error message to the flash-messages element
                            $('.flash-messages').append(errorAlert);
                        }
                    }
                });
            });
        });
        // Reson modal script end
    </script>
@endpush
