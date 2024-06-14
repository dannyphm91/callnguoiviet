<header class="header header--two" id="sticky-menu">
    <div class="navigation-bar__top">
        <div class="container">
            <div class="navigation-bar">
                <div class="d-flex gap-sm-4 gap-2 align-items-center">
                    <button class="toggle-icon">
                        <span class="toggle-icon__bar"></span>
                        <span class="toggle-icon__bar"></span>
                        <span class="toggle-icon__bar"></span>
                    </button>
                    <!-- Brand Logo -->
                    <a href="{{ route('frontend.index') }}" class="navigation-bar__logo">
                        <img src="{{ $setting->logo_image_url }}" alt="brand-logo" class="logo-dark">
                    </a>
                    <button type="button" class="tc-location" data-toggle="modal" data-target="#locationModal">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10 18.125C10 18.125 16.25 13.75 16.25 8.125C16.25 6.4674 15.5915 4.87769 14.4194 3.70558C13.2473 2.53348 11.6576 1.875 10 1.875C8.3424 1.875 6.75269 2.53348 5.58058 3.70558C4.40848 4.87769 3.75 6.4674 3.75 8.125C3.75 13.75 10 18.125 10 18.125ZM12.5 8.125C12.5 9.50571 11.3807 10.625 10 10.625C8.61929 10.625 7.5 9.50571 7.5 8.125C7.5 6.74429 8.61929 5.625 10 5.625C11.3807 5.625 12.5 6.74429 12.5 8.125Z"
                                fill="#191F33" />
                        </svg>
                        @if (selected_country())
                            <span>{{selected_country()->name}}</span>
                        @else
                            <span>{{__('all_country')}}</span>
                        @endif
                    </button>
                    <!-- City List Popup -->
                    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h2>{{__("select_your_country")}}</h2>
                                    <form>
                                        <label for="leaflet_search">
                                            <input id="search-input" type="text"  placeholder="Search Country"
                                                name="location" value="" autocomplete="off" class="text-gray-900">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z"
                                                    stroke="#00AAFF" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M21 20.9999L16.65 16.6499" stroke="#00AAFF" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </label>
                                    </form>
                                    <div class="city-list">
                                        <ul>
                                            <li><a class="dropdown-item hover:tw-bg-[#F1F2F4] hover:tw-rounded-[4px]"
                                                href="{{route('frontend.set.country', ['country' => 'all_country'])}}">
                                                <i class="fa-solid fa-globe" style="font-size: 22px"></i>
                                        {{__('all_country')}}
                                    </a></li>
                                            @foreach ($headerCountries as $country)
                                                <li id="lang-dropdown-item">
                                                    <a class="dropdown-item hover:tw-bg-[#F1F2F4] hover:tw-rounded-[4px]"
                                                                href="{{route('frontend.set.country', ['country' => $country->id])}}">
                                                        <i class="flag-icon {{ $country->icon }}"></i>
                                                                {{ $country->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-4">
                    <ul class="d-flex align-items-center gap-4 tc-header-none">
                        <x-frontend.currency-switcher />
                        <x-frontend.language-switcher />
                    </ul>
                    <!-- Action Buttons -->
                    <div class="d-flex align-items-center gap-4">
                        @if (auth('user')->check())
                            @php
                                $unread_messages = App\Models\Messenger::where('to_id', auth('user')->id())
                                    ->where('body', '!=', '.')
                                    ->where('read', 0)
                                    ->count();
                            @endphp
                            <a href="{{ route('frontend.adlist') }}" class="btn btn--outline tc-header-none">
                                <span class="icon--left">
                                    <x-svg.search-icon />
                                </span>
                                <span>Browse Ads</span>
                            </a>
                            <a href="{{ route('frontend.post') }}" class="btn tc-header-none">
                                <span class="icon--left">
                                    <x-svg.image-select-icon />
                                </span>
                                <span>
                                    {{ __('post_listing') }}
                                </span>
                            </a>
                            <a href="{{ route('frontend.dashboard') }}" class="user position-relative">
                                <div class="position-relative user__img-wrapper">
                                    <img src="{{ auth('user')->user()->image_url }}"
                                        style="width: 30px; height: 30px; border-radius: 50%" alt="User Image">
                                </div>

                                <span id="unread_count_custom3"
                                    class="text-danger unread-message-img {{ $unread_messages ? '' : 'd-none' }}"
                                    amount="{{ $unread_messages }}">
                                    {{ $unread_messages }}
                                </span>

                                @if (auth('user')->user()->document_verified && auth('user')->user()->document_verified->status == 'approved')
                                    <span style="width: 15px; height:15px" class="verify-badge">
                                        <x-svg.account-verification.verified-badge />
                                    </span>
                                @endif
                            </a>
                        @else
                            <a href="{{ route('frontend.adlist') }}" class="btn btn--outline tc-header-none">
                                <span class="icon--left">
                                    <x-svg.search-icon />
                                </span>
                                <span>Browse Ads</span>
                            </a>
                            <a href="{{ route('users.login', ['post_ads' => true]) }}" class="btn tc-btn">
                                <span class="icon--left tc-icon">
                                    <x-svg.image-select-icon />
                                </span>
                                <span class="right-text">
                                    {{ __('post_listing') }}
                                </span>
                            </a>
                            <a href="{{ route('users.login') }}"
                                class="btn btn--bg tc-header-none">{{ __('sign_in') }}</a>
                        @endif
                    </div>
                </div>
                <!-- Responsive Navigation Menu  -->
                <x-frontend.responsive-menu />
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Select the input field and the list items
        const searchInput = document.getElementById("search-input");
        const countryListItems = document.querySelectorAll(".city-list ul li");

        // Add an event listener to the input field
        searchInput.addEventListener("input", function () {
            const inputValue = searchInput.value.toLowerCase().trim(); // Trim whitespace

            // Sort the list items based on input matching the first word
            countryListItems.forEach(function (item) {
                const countryName = item.textContent.toLowerCase();
                const firstWord = countryName.split(" ")[0];

                if (firstWord === inputValue) {
                    item.style.display = "block";
                } else if (countryName.includes(inputValue)) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    });
</script>


