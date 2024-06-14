<div class="relative inline-flex" x-data="{ notiPanel: false }" @click.outside="notiPanel = false">
    <button @click="notiPanel = !notiPanel"
        class="transition-all duration-300 text-white/90 hover:text-white">
        <x-frontend.icons.bell-alert />
    </button>
    <!-- Dropdown menu -->
    <div class="absolute z-50 right-0 top-full w-full min-w-[240px] md:min-w-[536px]" x-cloak x-show="notiPanel" x-cloak
        x-transition>
        <div class="py-6 bg-white rounded-md border border-gray-50 shadow-gray-base-1 ">
            <div class="flex flex-wrap gap-2 justify-between items-center sm:px-6 px-3">
                <h4 class="text-gray-900 body-xl-600">Notification</h4>
                <button
                    class="inline-flex whitespace-nowrap gap-2 items-center body-small-600 text-gray-500 hover:text-primary-500 transition-all duration-300">
                    <x-frontend.icons.double-check />
                    <span>Mark as read</span>
                </button>
            </div>
            <ul class="flex flex-col py-3">
                <li>
                    <a href="#"
                        class="notification-list flex gap-3 items-start sm:px-6 px-3 py-3 hover:bg-gray-50 unread">
                        <img class="w-10 h-10 rounded-full object-cover"
                            src="{{ asset('frontend/images/user-avatar.png') }}" alt="">
                        <div>
                            <p class="body-base-600 text-gray-500 sm:line-clamp-2 line-clamp-1"><strong
                                    class="text-gray-900">"MD Khalil"</strong> is
                                a great match for your <strong class="text-gray-900">Software Engineer</strong> role.
                                Check out their profile now!</p>
                            <p class="body-small-400 text-gray-500 mt-1">3 hours ago</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="notification-list flex gap-3 items-start sm:px-6 px-3 py-3 hover:bg-gray-50">
                        <img class="w-10 h-10 rounded-full object-cover"
                            src="{{ asset('frontend/images/user-avatar.png') }}" alt="">
                        <div>
                            <p class="body-base-600 text-gray-500 sm:line-clamp-2 line-clamp-1"><strong
                                    class="text-gray-900">"MD Khalil"</strong> is
                                a great match for your <strong class="text-gray-900">Software Engineer</strong> role.
                                Check out their profile now!</p>
                            <p class="body-small-400 text-gray-500 mt-1">3 hours ago</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="notification-list flex gap-3 items-start sm:px-6 px-3 py-3 hover:bg-gray-50 unread">
                        <img class="w-10 h-10 rounded-full object-cover"
                            src="{{ asset('frontend/images/user-avatar.png') }}" alt="">
                        <div>
                            <p class="body-base-600 text-gray-500 sm:line-clamp-2 line-clamp-1"><strong
                                    class="text-gray-900">"MD Khalil"</strong> is
                                a great match for your <strong class="text-gray-900">Software Engineer</strong> role.
                                Check out their profile now!</p>
                            <p class="body-small-400 text-gray-500 mt-1">3 hours ago</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="notification-list flex gap-3 items-start sm:px-6 px-3 py-3 hover:bg-gray-50">
                        <img class="w-10 h-10 rounded-full object-cover"
                            src="{{ asset('frontend/images/user-avatar.png') }}" alt="">
                        <div>
                            <p class="body-base-600 text-gray-500 sm:line-clamp-2 line-clamp-1"><strong
                                    class="text-gray-900">"MD Khalil"</strong> is
                                a great match for your <strong class="text-gray-900">Software Engineer</strong> role.
                                Check out their profile now!</p>
                            <p class="body-small-400 text-gray-500 mt-1">3 hours ago</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="notification-list flex gap-3 items-start sm:px-6 px-3 py-3 hover:bg-gray-50 unread">
                        <img class="w-10 h-10 rounded-full object-cover"
                            src="{{ asset('frontend/images/user-avatar.png') }}" alt="">
                        <div>
                            <p class="body-base-600 text-gray-500 sm:line-clamp-2 line-clamp-1"><strong
                                    class="text-gray-900">"MD Khalil"</strong> is
                                a great match for your <strong class="text-gray-900">Software Engineer</strong> role.
                                Check out their profile now!</p>
                            <p class="body-small-400 text-gray-500 mt-1">3 hours ago</p>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="flex justify-center items-center">
                <a href=""
                    class="inline-flex gap-2 items-center heading-07 text-primary-500 hover:text-primary-700 transition-all duration-300">
                    <x-frontend.icons.loading />
                    <span>Load More</span>
                </a>
            </div>
        </div>
    </div>
</div>
