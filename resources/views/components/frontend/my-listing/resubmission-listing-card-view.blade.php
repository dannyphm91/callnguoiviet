<div
    class="relative w-full rounded-lg p-4 shadow-[0px_2px_4px_0px_rgba(28,33,38,0.03)] flex flex-col transition-all duration-100  gap-6 border border-gray-100 hover:listing-card-gradient ">
    <div class="flex flex-col gap-4">
        <a href="{{ route('frontend.addetails', $ad->slug) }}" class="w-full rounded-md overflow-hidden">
            <img src="{{ $ad->thumbnail }}" alt="listing img" class="w-full sm:h-[250px] h-[200px] object-cover " />
        </a>
        <div class="flex justify-between gap-2.5">
            <div class="flex-grow flex flex-col gap-1">
                <span class="body-sm-500 text-primary-500">
                    {{ $ad->category->name }}
                </span>
                <a href="{{ route('frontend.addetails', $ad->slug) }}">
                    <p class="heading-07 text-gray-900 line-clamp-2">
                        {{ $ad->title }} {{ $ad->title }}
                    </p>
                </a>
                <div class="body-sm-400 text-gray-700 flex items-center gap-x-1 mt-1 line-clamp-1">
                    <x-frontend.icons.locate />
                    {{ $ad->district ? $ad->district . ', ' : '' }}
                    {{ $ad->region ? $ad->region . ', ' : '' }}
                    {{ $ad->country ?? '' }}
                </div>
            </div>
            <div class="inline-flex items-center justify-center">
                <div>
                    <div class="relative group" x-data="{ showMenu: false }" x-init @click.outside="showMenu = false">
                        <button type="button" @click="showMenu = !showMenu"
                            class="flex items-center justify-center ms-auto text-white rounded-full w-9 h-9 bg-gray-100 hover:bg-primary-100">
                            <x-svg.horizontal-dots />
                        </button>
                        <div class="absolute top-9 right-0 z-10" x-cloak x-show="showMenu" x-transition>
                            <ul
                                class=" bg-white border-gray-100 min-w-[12rem] md:min-w-[18.3rem] py-3 rounded-lg shadow-[0px_4px_6px_-2px_rgba(16,24,40,0.03),0px_12px_16px_-4px_rgba(16,24,40,0.08)]">
                                <li>
                                    <a href="{{ route('frontend.addetails', $ad->slug) }}"
                                        class="btn gap-x-[0.5rem] body-md-400 text-gray-700 hover:text-gray-900 hover:bg-primary-50 transition-all duration-150 flex items-center px-4 py-[0.62rem]">
                                        <x-frontend.icons.eye />
                                        <span class="text-sm font-medium">{{ __('view_listing_details') }}</span>
                                    </a>
                                </li>
                                @if ($ad->status == 'active')
                                    <li>
                                        <form action="{{ route('frontend.myad.status', $ad->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button
                                                onclick="return confirm('{{ __('are_you_sure_you_want_to_sold_this_item') }}?');"
                                                type="submit"
                                                class="gap-x-[0.5rem] w-full body-md-400 text-gray-700 hover:text-gray-900 hover:bg-primary-50 transition-all duration-150 flex items-center px-4 py-[0.62rem]">
                                                <x-frontend.icons.cross />
                                                <span class="text-sm font-medium">{{ __('mark_as_sold') }}</span>
                                            </button>
                                        </form>
                                    </li>
                                @endif
                                @if ($ad->status == 'sold')
                                    <li>
                                        <form action="{{ route('frontend.myad.status', $ad->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button
                                                onclick="return confirm('{{ __('are_you_sure_you_want_to_active_this_item') }}?');"
                                                type="submit"
                                                class="gap-x-[0.5rem] w-full body-md-400 text-gray-700 hover:text-gray-900 hover:bg-primary-50 transition-all duration-150 flex items-center px-4 py-[0.62rem]">
                                                <x-frontend.icons.check />
                                                <span class="text-sm font-medium">{{ __('mark_as_active') }}</span>
                                            </button>
                                        </form>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('frontend.post.edit', $ad->slug) }}"
                                        class="btn gap-x-[0.5rem] body-md-400 text-gray-700 hover:text-gray-900 hover:bg-primary-50 transition-all duration-150 flex items-center px-4 py-[0.62rem]">
                                        <x-frontend.icons.edit />
                                        <span class="text-sm font-medium">{{ __('edit') }}</span>
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('frontend.post.delete', $ad->slug) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            onclick="return confirm('{{ __('are_you_sure_you_want_to_delete_this_item') }}?');"
                                            type="submit"
                                            class="gap-x-[0.5rem] w-full body-md-400 text-gray-700 hover:text-gray-900 hover:bg-primary-50 transition-all duration-150 flex items-center px-4 py-[0.62rem]">
                                            <x-frontend.icons.trash />
                                            <span class="text-sm font-medium">{{ __('delete') }}</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-y-5 sm:gap-y-0 justify-between">
        <div class="flex justify-between items-center">
            <h5 class="heading-05 text-error-500">{{ currentCurrencySymbol() }}{{ $ad->price }}</h5>
            <div class="body-md-400 text-gray-700 flex items-center">
                {{ $ad->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
    <div class="absolute top-8 right-8 space-y-2 flex flex-col items-center justify-center">
        @if ($ad->status == 'active')
            <x-frontend.my-listing.active-badge />
        @else
            <x-frontend.my-listing.status :status="$ad->status" />
        @endif
    </div>
</div>
