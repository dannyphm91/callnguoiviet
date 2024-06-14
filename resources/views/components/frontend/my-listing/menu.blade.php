@props(['ad'])
<div class="relative group">
    <button type="button"
        class="flex items-center justify-center ms-auto text-white  rounded-full w-9 h-9 hover:bg-gray-100 ">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M6.75 12C6.75 12.4142 6.41421 12.75 6 12.75C5.58579 12.75 5.25 12.4142 5.25 12C5.25 11.5858 5.58579 11.25 6 11.25C6.41421 11.25 6.75 11.5858 6.75 12Z"
                fill="#555B61" />
            <path
                d="M12.75 12C12.75 12.4142 12.4142 12.75 12 12.75C11.5858 12.75 11.25 12.4142 11.25 12C11.25 11.5858 11.5858 11.25 12 11.25C12.4142 11.25 12.75 11.5858 12.75 12Z"
                fill="#555B61" />
            <path
                d="M18.75 12C18.75 12.4142 18.4142 12.75 18 12.75C17.5858 12.75 17.25 12.4142 17.25 12C17.25 11.5858 17.5858 11.25 18 11.25C18.4142 11.25 18.75 11.5858 18.75 12Z"
                fill="#555B61" />
            <path
                d="M6.75 12C6.75 12.4142 6.41421 12.75 6 12.75C5.58579 12.75 5.25 12.4142 5.25 12C5.25 11.5858 5.58579 11.25 6 11.25C6.41421 11.25 6.75 11.5858 6.75 12Z"
                stroke="#555B61" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M12.75 12C12.75 12.4142 12.4142 12.75 12 12.75C11.5858 12.75 11.25 12.4142 11.25 12C11.25 11.5858 11.5858 11.25 12 11.25C12.4142 11.25 12.75 11.5858 12.75 12Z"
                stroke="#555B61" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            <path
                d="M18.75 12C18.75 12.4142 18.4142 12.75 18 12.75C17.5858 12.75 17.25 12.4142 17.25 12C17.25 11.5858 17.5858 11.25 18 11.25C18.4142 11.25 18.75 11.5858 18.75 12Z"
                stroke="#555B61" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
    <div class="absolute hidden group-hover:block top-9 right-0 z-10">
        <ul
            class=" bg-white border-gray-100 min-w-[15rem] sm:min-w-[18.3rem] py-3 rounded-lg shadow-[0px_4px_6px_-2px_rgba(16,24,40,0.03),0px_12px_16px_-4px_rgba(16,24,40,0.08)]">
            <li
                class="gap-x-[0.5rem] body-md-400 text-gray-700 hover:text-gray-900 hover:bg-primary-50 transition-all duration-150 flex items-center px-4 py-[0.62rem] cursor-pointer">
                <x-frontend.icons.promotion />
                    <span class="text-sm font-medium">Listing Promotion</span>
            </li>
            <li
                class="gap-x-[0.5rem] body-md-400 text-gray-700 hover:text-gray-900 hover:bg-primary-50 transition-all duration-150 flex items-center px-4 py-[0.62rem] cursor-pointer">
                <x-frontend.icons.message />
                <span class="text-sm font-medium">View All Messages</span>
            </li>
            <li
                class="gap-x-[0.5rem] body-md-400 text-gray-700 hover:text-gray-900 hover:bg-primary-50 transition-all duration-150 flex items-center px-4 py-[0.62rem] cursor-pointer">
                <x-frontend.icons.arrow-square-up />
                <span class="text-sm font-medium">View Listing Detail</span>
            </li>

            <li
                class="gap-x-[0.5rem] body-md-400 text-gray-700 hover:text-gray-900 hover:bg-primary-50 transition-all duration-150 flex items-center px-4 py-[0.62rem] cursor-pointer">
                <x-frontend.icons.share />
                <span class="text-sm font-medium">Share Listing</span>
            </li>

        </ul>
    </div>



</div>
