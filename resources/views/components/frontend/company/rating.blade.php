<div>
    <div class="bg-warning-50 p-[1rem] w-full flex items-center gap-[0.75rem] rounded-[0.5rem] heading-04 text-gray-900">
        <x-frontend.icons.star-yellow />
        4.7 Star Rating
    </div>
    <div class="space-y-[1.5rem]">
        <template x-for="item in [...new Array(10)]">
            <div class="flex flex-wrap gap-x-[0.75rem]">
                <div class="h-[3rem] w-[3rem] shrink-0 rounded-full overflow-hidden">
                    <img src="{{ asset('frontend/images/john-wick.png') }}" class="w-full object-cover"
                        alt="user img">
                </div>
                <div class="space-y-[0.25rem]">
                    <div class="flex items-center gap-x-[0.12rem]">
                        <small class="h-[1.2rem] w-[1.2rem] text-[#FF8E09]">
                            <x-frontend.icons.star />
                        </small>
                        <small class="h-[1.2rem] w-[1.2rem] text-[#FF8E09]">
                            <x-frontend.icons.star />
                        </small>
                        <small class="h-[1.2rem] w-[1.2rem] text-[#FF8E09]">
                            <x-frontend.icons.star />
                        </small>
                        <small class="h-[1.2rem] w-[1.2rem] text-[#FF8E09]">
                            <x-frontend.icons.star />
                        </small>
                    </div>
                    <div class="flex items-center gap-x-[0.5rem]">
                        <h4 class="body-sm-500 text-gray-900">John Wick</h4>
                        <small class="body-sm-400 text-gray-500">5 mins ago</small>
                    </div>
                    <div class="body-md-400 text-gray-900">
                        <p> Love their drink specials. Bartenders super nice.</p>
                    </div>
                </div>
            </div>
        </template>

    </div>
    <div class="mt-[2rem]">
        <button
            class="flex  shrink-0 p-[0.5rem_1rem] justify-center items-center rounded-[0.375rem] border border-gray-100 shadow-[0px_1px_2px_0px_rgba(28, 33, 38, 0.05)] heading-08 text-gray-700 hover:text-white transition-all duration-100 hover:bg-primary-500 mx-auto">Load
            more</button>
    </div>
</div>
