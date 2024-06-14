<div>
    @if (!$active_category)
        <div class="flex justify-center">
            <button type="button" wire:click="openModal"
                class="border border-primary-500 px-3 py-2 rounded-md inline-flex gap-2 items-center shadow-md hover:scale-105 transition-all duration-300 hover:bg-primary-50 bg-transparent">
                <img src="{{ asset('frontend/images/color-category.png') }}" alt="">
                <span>{{ __('choose_category') }}</span>
            </button>
        </div>
    @endif
    @if ($active_subcategory || $active_category)
        <div class="flex justify-center gap-2 items-center mt-5">
            <span>{{ @$active_category }}</span>
            @if (@$active_subcategory)
            <i class="text-primary-500"><x-svg.chevron-right /></i>
            <span>{{ @$active_subcategory }}</span>
            <i class="text-primary-500"><x-svg.chevron-right /></i>
            @endif

            <button type="button" class="inline-flex gap-2 items-center hover:text-primary-500" wire:click="openModal">
                <x-frontend.icons.edit />
                <span>{{ __('edit') }}</span>
            </button>
        </div>

        <input name="category_id" type="hidden" value="{{ $active_category_id }}">
        <input name="subcategory_id" type="hidden" value="{{ $active_subcategory_id }}">
    @endif

    @if ($category_modal)
        <!-- category modal start -->
        <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50 max-w-4xl w-full">
            <div
                class="bg-white shadow-md px-8 py-6 rounded-xl relative mx-3 max-h-[80vh] overflow-x-hidden overflow-y-auto">
                <h2 class="heading-06 text-primary-500 pb-3 border-b border-primary-100 mb-5">{{ __('select_a_category') }}</h2>
                <div class="flex gap-2 items-center">
                    <div class="flex gap-2 flex-wrap justify-center">
                        <div class="flex gap-2 flex-wrap justify-center">
                            @foreach ($categories as $item)
                                <div class="inline-flex max-w-max">
                                    <label wire:click='getSubCategories({{ @$item->id }}, "{{ @$item->name }}")'
                                        for="cat{{ @$item->id }}"
                                        class="ad-category {{ @$item->id == $active_category_id ? 'ad-category-checked' : '' }} relative cursor-pointer group flex flex-col gap-1 items-center justify-center px-4 py-3 rounded-md bg-gray-50 border border-transparent transition-all duration-300 hover:border-primary-100 hover:bg-white hover:shadow-md">
                                        <input type="radio" name="category" id="cat{{ @$item->id }}"
                                            class="hidden">
                                        <i
                                            class="absolute -top-3 left-1/2 -translate-x-1/2 p-1 rounded-full bg-primary-100 text-primary-700"><x-frontend.icons.check /></i>
                                        <img class="group-hover:scale-110 transition-all duration-300 w-8"
                                            src="{{ asset(@$item->image) }}" alt="{{ @$item->name }}">
                                        <h3 class="body-base-500">{{ @$item->name }}</h3>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="heading-07 text-primary-500 pb-3 border-b border-primary-100 my-5">{{ __('select_a_subcategory') }}</h2>
                    <ul class="flex flex-wrap gap-3" id="subcategory">
                        @forelse ($subCategories as $item)
                            <li>
                                <label wire:click='setSubCategory({{ @$item->id }}, "{{ @$item->name }}")'
                                    for="subcat{{ $item->id }}"
                                    class="ad-subcategory {{ @$item->id == $active_subcategory_id ? 'ad-subcategory-checked' : '' }} relative inline-flex justify-center items-center gap-2 transition-all duration-300 hover:-translate-y-0.5 border border-gray-100 hover:bg-gray-50 rounded-md cursor-pointer hover:text-primary-500 px-4 py-2">
                                    <input class="hidden" type="radio" name="sub_category"
                                        id="subcat{{ $item->id }}">
                                    <i
                                        class="p-0.5 rounded-full bg-primary-100 text-primary-700"><x-frontend.icons.check /></i>
                                    <span>{{ $item->name }}</span>
                                </label>
                            </li>
                        @empty
                            <li>{{ __('no_categoy_selected') }}</li>
                        @endforelse
                    </ul>
                </div>
                <button type="button" class="absolute top-3 right-3 p-2 rounded-full border border-gray-100 bg-white"
                    wire:click="closeModal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div x-cloak class="fixed top-0 left-0 w-full h-full bg-black/70 z-20" wire:click="closeModal"></div>
        <!-- category modal end -->
    @endif

    <script>
        window.addEventListener('contentChanged', event => {

            document.addEventListener('DOMContentLoaded', (event) => {

                new Swiper(".choose-category-slider", {
                    slidesPerView: "auto",
                    spaceBetween: 16,
                    modules: [Navigation],
                    navigation: {
                        nextEl: ".choose-category-slider_next",
                        prevEl: ".choose-category-slider_prev",
                    },
                });
            });
        });
    </script>

    <style>
        .ad-category i,
        .ad-subcategory i {
            display: none;
        }

        .ad-category-checked {
            background: white;
            border-color: var(--primary-100);
            color: var(--primary-500);
        }

        .ad-subcategory-checked {
            background: var(--gray-50);
            border-color: var(--primary-100);
            color: var(--primary-500);
        }

        .ad-category-checked i,
        .ad-subcategory-checked i {
            display: inline-block;
        }
    </style>
</div>
