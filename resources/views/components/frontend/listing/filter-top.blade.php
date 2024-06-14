<section class="pt-8 pb-6">
    <div class="container">
        <div class="flex flex-wrap xl:flex-nowrap gap-3 items-center">
            <button class="btn-secondary py-2.5 px-5" @click="filter = !filter">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                </svg>
                <span>Filters</span>
            </button>
            <input class="tc-input max-w-[393px]" type="text" placeholder="Search">
            <input class="tc-input max-w-[248px]" type="text" placeholder="Location">
            <div class="flex radio-box__wrap">
                <label class="py-3 px-4 body-sm-500 text-center cursor-pointer" for="all">
                    <input type="radio" name="user" id="all" class="hidden" checked>
                    <span>All</span>
                </label>
                <label class="py-3 px-4 body-sm-500 hover:bg-primary-50 transition-all duration-300 text-gray-700 text-center cursor-pointer" for="person">
                    <input type="radio" name="user" id="person" class="hidden">
                    <span>Person</span>
                </label>
                <label class="py-3 px-4 body-sm-500 hover:bg-primary-50 transition-all duration-300 text-gray-700 text-center cursor-pointer" for="company">
                    <input type="radio" name="user" id="company" class="hidden">
                    <span>Company</span>
                </label>
            </div>
            <div class="flex radio-box__wrap">
                <label class="py-3 px-4 body-sm-500 hover:bg-primary-50 transition-all duration-300 text-center cursor-pointer" for="all_con">
                    <input type="radio" name="condition" id="all_con" checked class="hidden">
                    <span>All</span>
                </label>
                <label class="py-3 px-4 body-sm-500 hover:bg-primary-50 transition-all duration-300 text-center cursor-pointer" for="used">
                    <input type="radio" name="condition" id="used" class="hidden">
                    <span>Used</span>
                </label>
                <label class="py-3 px-4 body-sm-500 hover:bg-primary-50 transition-all duration-300 text-center cursor-pointer" for="new">
                    <input type="radio" name="condition" id="new" class="hidden">
                    <span>New</span>
                </label>
            </div>
            <button class="btn-primary py-2.5 px-5">
                <span>Search</span>
            </button>
        </div>
    </div>
</section>
