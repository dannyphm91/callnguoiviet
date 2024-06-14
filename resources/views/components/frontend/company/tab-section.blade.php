<div class="p-[1.5rem] w-full" x-data="{ tab: 'listing' }">
    <div class="flex gap-x-[1.5rem]  border-b border-b-gray-100 w-full">
        <h5 :class="`heading-05 ${tab === 'listing' ? 'active-tab':'text-gray-500'} transition-all duration-150 ease-in-out  pb-[0.94rem] hover:active-tab relative `"
            role="button" @click="tab='listing'">
            Company
            Listing
        </h5>
        <h5 :class="`heading-05 ${tab === 'rating' ? 'active-tab':'text-gray-500'} transition-all duration-150 ease-in-out  pb-[0.94rem] hover:active-tab relative`"
            role="button" @click="tab='rating'">Rating & Review</h5>
    </div>

    <div class="mt-[1.5rem]">
        <template x-if="tab === 'listing'">
            <x-frontend.company.listing />
        </template>

        <template x-if="tab === 'rating'">
            <x-frontend.company.rating />
        </template>
    </div>
</div>
