<aside
    class="border border-gray-100 self-start border-t-0 flex flex-col items-center gap-[1.5rem] w-full md:w-[288px]  lg:w-[26.5rem] rounded-[0.75rem] rounded-t-none shadow-[0px_4px_8px_0px_rgba(28,33,38,0.08)]">
    <div
        class="aside-img-section h-[13.5rem] w-[13.5rem] border-[12px] border-[#FFF] rounded-full relative mx-auto mt-[-7rem]">
        <img src="{{ asset('/frontend/images/company-profile-img.svg') }}" alt="company profile image"
            class="w-full  object-cover">
    </div>
    <div class="text-center space-y-[0.38rem]">
        <h4 class="text-[1.7rem] font-semibold leading-[2.25rem] text-gray-900">
            Rajdhani Realty Ltd
        </h4>
        <p class="text-[1.25rem] leading-[1.75rem] text-gray-600">We build your dream</p>
        <div class="flex items-center gap-[0.75rem] justify-center">
            <small style="background: linear-gradient(96deg, #E8F0FC 2.6%, #F2E8FC 100%)"
                class="py-[0.375rem] px-[0.625rem] rounded-[0.25rem] text-[0.75rem] font-semibold text-gray-800 uppercase tracking-[-0.0075rem] leading-[0.75rem]">MEMBER</small>
            <small class="flex items-center gap-[0.25rem] text-success-500">
                <x-frontend.icons.check-badge />
                Verified
            </small>
        </div>
    </div>
    <div style="background: linear-gradient(180deg, #E8F0FC 0%, rgba(232, 240, 252, 0.00) 100%);"
        class="py-[1rem] px-[1rem] flex   w-full">
        <div class="flex items-start gap-[0.5rem] basis-[9rem] shrink-0 w-full">
            <small
                class="min-h-[1.4rem] min-w-[1.4rem] rounded-full bg-primary-500 flex items-center justify-center text-white">
                <x-frontend.icons.plus />
            </small>
            <div class="space-y-[0.12rem]">
                <h6 class="text-gray-900 font-semibold leading-[1.5rem] text-[1.125rem]">671</h6>
                <p class="text-gray-700 body-sm-400 leading-[1.125rem]">Listing created</p>
            </div>
        </div>
        <div class="flex items-start gap-[0.5rem] basis-[8rem] shrink-0 w-full">
            <small
                class="h-[1.4rem] w-[1.4rem] rounded-full bg-primary-500 flex items-center justify-center text-white text-sm shrink-0">
                <x-frontend.icons.check />
            </small>
            <div class="space-y-[0.12rem]">
                <h6 class="text-gray-900 font-semibold leading-[1.5rem] text-[1.125rem]">539</h6>
                <p class="text-gray-700 body-sm-400 leading-[1.125rem]">Total sold</p>
            </div>
        </div>
    </div>
    <div class="w-full">
        <div class="bg-warning-50 w-full px-[1.5rem] py-[0.75rem]">
            <h4 class="flex items-center gap-x-[0.38rem]">
                <small class=" text-[#FF8E09]">
                    <x-frontend.icons.star />
                </small>
                <span class="text-gray-800 heading-07">
                    4.7 Star Rating
                </span>
                <small class="text-gray-600 body-md-400">
                    99 Reviews
                </small>
            </h4>
        </div>
        <a href="#"
            class="bg-primary-500 text-white w-full px-[1.5rem] py-[0.75rem] flex items-center gap-x-[0.5rem] heading-07">
            <span>
                <x-frontend.icons.arrow-square-up />
            </span>
            https://www.facebook.com/
        </a>
    </div>
    <div class="py-[1.5rem] pt-0 px-[0.75rem] space-y-[0.75rem] border-b border-b-gray-100">
        <h6 class="heading-07 text-gray-900">About Company</h6>
        <p class="body-md-400 text-gray-700 leading-[1.5rem]">
            John Wick is an American neo-noir action thriller media franchise created by Derek Kolstad and centered on
            John Wick, a former hitman who is drawn back into the criminal underworld he had previously abandoned.
        </p>
        <small class="block text-sm-400 leading-[1.25rem] text-gray-500">
            Member since October, 2021
        </small>
    </div>
    <div class="px-[1.5rem]  space-y-[0.75rem] w-full">
        <h6 class="heading-07 text-gray-900">Contact Information</h6>
        <div class="divide-y  divide-gray-100">
            <div class="flex items-start space-x-[0.75rem] pb-[1rem]">
                <span>
                    <x-frontend.icons.phone-blue />
                </span>
                <div class="space-y-[0.13rem]">
                    <small class="body-xs-500 text-gray-500 leading-[1rem] uppercase">PHONE NUMBER</small>
                    <p class="body-md-500 leading-[1.5rem] text-gray-900">(808) 5XX-XXXX</p>
                </div>
            </div>
            <div class="flex items-start space-x-[0.75rem] py-[1rem]">
                <span>
                    <x-frontend.icons.email-blue />
                </span>
                <div class="space-y-[0.13rem]">
                    <small class="body-xs-500 text-gray-500 leading-[1rem] uppercase">EMAIL ADDRESS</small>
                    <p class="body-md-500 leading-[1.5rem] text-gray-900">john.wick@gmail.com</p>
                </div>
            </div>
            <div class="flex items-start space-x-[0.75rem] pt-[1rem]">
                <span>
                    <x-frontend.icons.map-blue />
                </span>
                <div class="space-y-[0.13rem]">
                    <small class="body-xs-500 text-gray-500 leading-[1rem] uppercase">LOCATION</small>
                    <p class="body-md-500 leading-[1.5rem] text-gray-900">
                        Flor: 4, House: 34/4, Road: 3, Block: A, Dhaka Uddan, Mohammadpur, Dhaka 1207
                    </p>
                    <small class="text-primary-500 body-sm-500 leading-[1.25rem] cursor-pointer">Show on map</small>
                </div>
            </div>
        </div>
    </div>
    <div
        class="cursor-pointer flex text-gray-400 mody-md-500  leading-[1.5rem] gap-x-[0.75rem] justify-start w-full px-[1.5rem] pb-[1.5rem]">
        <x-frontend.icons.warning />
        <p class="">Report Seller</p>
    </div>
</aside>
