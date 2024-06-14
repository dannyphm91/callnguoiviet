@props(['brands'])
@php
    $locale = app()->getLocale();
@endphp
<div class="fixed  opacity-0 transform transition ease-linear duration-300  md:relative inset-0 -z-10 bg-black/20 md:bg-transparent h-full"
    :class="{ 'translate-x-0 opacity-100 z-10 ': filter }" @click.self="filter=false">

    <div class="w-0 h-0 overflow-x-hidden divide-y divide-gray-100 md:divide-y-0    text-gray-50 transition-all duration-200 ease-linear md:bg-transparent "
        :class="{ 'w-[312px] h-screen md:h-auto': filter }">

        <div x-data="{ expanded: true }" class="relative overflow-hidden filter-item mb-4 ">
            <div class="flex items-center justify-end pr-5 py-5 md:hidden rounded-lg" @click="filter = false">
                <button type="button"
                    class="h-[40px] w-[40px] bg-gray-50 text-gray-800 font-bold hover:text-gray-900 transition duration-200 ease-linear flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>

                </button>
            </div>
            <div>
                <button @click="expanded = ! expanded"
                    class="flex items-center justify-between w-full p-4 text-gray-700 dark:text-gray-200 caption-03 select-none">
                    <span>{{ __('price') }}</span>
                    <span class="w-4 h-4 duration-200 ease-out" :class="expanded ? '' : 'rotate-180'">
                        <x-svg.heroicons.arrow-up />
                    </span>
                </button>
                <div x-show="expanded" x-collapse x-cloak>
                    <div x-init="mintrigger();
                    maxtrigger()" class="relative price-range p-4 max-w-xl w-full">
                        <div>
                            <input type="range" step="100" wire:model="minPrice" :min="min"
                                :max="max" x-on:input="mintrigger" x-model="minprice"
                                class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                            <input type="range" wire:model="maxPrice" step="100" :min="min"
                                :max="max" x-on:input="maxtrigger" x-model="maxprice"
                                class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                            <div class="relative z-10 h-2.5">
                                <div class="absolute z-10 start-0 end-0 bottom-0 top-0 rounded-md bg-primary-100">
                                </div>
                                <div class="absolute z-20 top-0 bottom-0 rounded-md bg-primary-500"
                                    :style="'inset-inline-end:' + maxthumb + '%; inset-inline-start:' + minthumb + '%'">
                                </div>
                                <div class="range-thumb absolute z-30 w-5 h-5 top-0 start-0 bg-primary-500 rounded-full -mt-[5px] "
                                    :style="'inset-inline-start: ' + minthumb + '%'"></div>
                                <div class="range-thumb absolute z-30 w-5 h-5 top-0 end-0 bg-primary-500 rounded-full -mt-[5px] me-[-1.1rem]"
                                    :style="'inset-inline-end: ' + maxthumb + '%'"></div>
                            </div>
                        </div>

                        <div class="flex gap-1.5 justify-center items-center text-gray-600 dark:text-gray-100 body-md-400 mt-5">
                            <span>$<span x-text="minprice"></span></span>
                            <span>-</span>
                            <span>$<span x-text="maxprice"></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div x-data="{ expanded: true }" class="relative overflow-hidden  mb-4">
            <div class="cursor-pointer group filter-item">
                <button @click="expanded = ! expanded"
                    class="flex items-center justify-between w-full p-4 text-gray-700 dark:text-gray-100 caption-03 select-none">
                    <span>{{ __('category') }}</span>
                    <span class="w-4 h-4 duration-200 ease-out" :class="expanded ? '' : 'rotate-180'">
                        <x-svg.heroicons.arrow-up />
                    </span>
                </button>
                <div x-show="expanded" x-collapse x-cloak class="pb-4">
                    <div class="flex justify-between items-center gap-3 hover:bg-gray-50 hover:dark:bg-gray-600 tc-checkbox-wrap">
                        <label class="tc-radio cursor-pointer flex-grow px-4">
                            <input wire:model="selectedCategory" id="allcategory" type="radio" value ="">
                            <label for="allcategory" class="block py-2 w-full"> {{ __('all_category') }}</label>
                        </label>
                    </div>
                    @foreach (loadCategoriesSubcategories() as $category)
                        <div wire:key="category-{{ $category['id'] }}" x-data="{ open: false }">
                            <div class="flex pe-1.5 justify-between items-center hover:bg-gray-50 hover:dark:bg-gray-600 tc-checkbox-wrap">
                                <label  class="tc-radio cursor-pointer flex-grow px-4">
                                    <input wire:model="selectedCategory" id="category{{ $category['id'] }}"
                                        type="radio" value="{{ $category['slug'] }}">
                                    <label for="category{{ $category['id'] }}" class="block dark:text-gray-100 py-2 w-full">
                                        {{ $category['translations']['category'][$locale] ?? $category['name'] }}
                                    </label>
                                </label>
                                <button class="h-10 px-2.5 transition-all duration-300 dark:text-gray-100 text-gray-700 hover:bg-gray-100 hover:text-primary-500" @click="open = !open">
                                    <template x-if="!open">
                                        <x-svg.heroicons.plus />
                                    </template>
                                    <template x-if="open">
                                        <x-svg.minus-icon />
                                    </template>
                                </button>
                            </div>
                            <div x-show="open" x-cloak>
                                @foreach ($category['subcategories'] as $subcategory)
                                    <div wire:key="subcategory-{{ $subcategory['id'] }}">
                                        <div
                                            class="flex justify-between items-center gap-3 py-2 pl-9 pr-4 hover:bg-gray-50 tc-checkbox-wrap">
                                            <div class="tc-radio">
                                                <input type="radio" id="subcategory{{ $subcategory['id'] }}"
                                                    wire:model="selectedSubcategory"
                                                    value="{{ $subcategory['slug'] }}">
                                                <label for="subcategory{{ $subcategory['id'] }}">
                                                    {{ $subcategory['translations'][$locale] ?? $subcategory['name'] }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div x-data="{ expanded: true }" class="relative overflow-hidden  mb-4">
            <div class="cursor-pointer group filter-item">
                <button @click="expanded = ! expanded"
                    class="flex items-center justify-between w-full p-4 text-gray-700 dark:text-gray-100 caption-03 select-none">
                    <span>Other Filter</span>
                    <span class="w-4 h-4 duration-200 ease-out" :class="expanded ? '' : 'rotate-180'">
                        <x-svg.heroicons.arrow-up />
                    </span>
                </button>
                <div x-show="expanded" x-collapse x-cloak>
                    <div class="px-4 pb-4">
                        <h3 class="text-gray-900 dark:text-gray-200 body-md-500 mb-2">{{ __('brands') }}</h3>
                        <ul class="flex flex-col gap-4">
                            @foreach ($brands as $brand)
                                <li class="tc-check-radio">
                                    <input type="radio" id="brand{{ $brand['id'] }}" wire:model="selectedbrand"
                                        name="brands" value="{{ $brand['name'] }}">
                                    <label for="brand{{ $brand['id'] }}">{{ $brand['name'] }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div x-data="{ expanded: true }" class="relative overflow-hidden  mb-4">
            <div class="cursor-pointer group filter-item">
                <button @click="expanded = ! expanded"
                    class="flex items-center justify-between w-full p-4 text-gray-700 dark:text-gray-100 caption-03 select-none">
                    <span>{{ __('posted_within') }}</span>
                    <span class="w-4 h-4 duration-200 ease-out" :class="expanded ? '' : 'rotate-180'">
                        <x-svg.heroicons.arrow-up />
                    </span>
                </button>
                <div x-show="expanded" x-collapse x-cloak>
                    <div class="px-4 pb-4">
                        <ul class="flex flex-col gap-4">
                            <li class="tc-check-radio">
                                <input type="radio" name="posted-within" wire:model="dateRange" value="1"
                                    id="24hrs">
                                <label for="24hrs">Last 24 hrs</label>
                            </li>
                            <li class="tc-check-radio">
                                <input type="radio" wire:model="dateRange" value="7" name="posted-within"
                                    id="7days">
                                <label for="7days">Last 7 days</label>
                            </li>
                            <li class="tc-check-radio">
                                <input type="radio" wire:model="dateRange" value="30" name="posted-within"
                                    id="30days">
                                <label for="30days">Last 30 days</label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
