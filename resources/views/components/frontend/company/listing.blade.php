<div>
    <div class="w-full  mb-[1rem]">
        <form>

            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <x-frontend.icons.search />
                </div>
                <input type="search" id="default-search"
                    class="block w-full  ps-10 text-sm text-gray-900 border border-gray-100 rounded-[0.5rem]"
                    placeholder="Search Mockups, Logos..." required>
                <button type="submit"
                    class="text-white absolute right-0 bottom-0 bg-primary-500 hover:bg-primary-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 h-full">Search</button>
            </div>
        </form>
    </div>
    <div class="grid gap-[1rem] grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 ">
        <x-frontend.ad-card.card />
        <x-frontend.ad-card.card />
        <x-frontend.ad-card.card />
        <x-frontend.ad-card.card />
        <x-frontend.ad-card.card />
        <x-frontend.ad-card.card />
        <x-frontend.ad-card.card />
        <x-frontend.ad-card.card />
        <x-frontend.ad-card.card />

    </div>
    <div class="mt-[2rem]">
        <button
            class="flex w-[17.5rem] shrink-0 p-[0.5rem_1rem] justify-center items-center rounded-[0.375rem] border border-gray-100 shadow-[0px_1px_2px_0px_rgba(28, 33, 38, 0.05)] heading-08 text-gray-700 hover:text-white transition-all duration-100 hover:bg-primary-500 mx-auto">Load
            more</button>
    </div>
</div>
