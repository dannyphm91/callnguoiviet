<div class="relative w-full rounded-lg p-4 shadow-[0px_2px_4px_0px_rgba(28,33,38,0.03)] flex flex-col lg:flex-row  transition-all duration-100  gap-6 border border-gray-100 dark:border-gray-600 hover:listing-card-gradient"
    x-data="{ commentModal: false }">
    <div class="flex flex-col lg:flex-row lg:items-center gap-4">
        <a href="{{ route('frontend.addetails', $ad->slug) }}" class="w-full rounded-md overflow-hidden lg:max-w-[6rem]">
            <img src="{{ $ad->thumbnail }}" alt="listing img" class="w-full lg:h-[80px] h-[200px] object-cover" />
        </a>
        <div class="sapce-y-2 flex-1 mt-5 sm:mt-0 flex flex-col">
            <span class="body-sm-500 text-primary-500">
                {{ $ad->category->name }}
            </span>

            <a href="{{ route('frontend.addetails', $ad->slug) }}">
                <p class="heading-07 text-gray-900 line-clamp-1">
                    {{ $ad->title }}
                </p>
            </a>
            <div class="body-sm-400 text-gray-700 flex items-center gap-x-1 mt-1 line-clamp-1">
                <x-frontend.icons.locate />
                {{ $ad->district ? $ad->district . ', ' : '' }}
                {{ $ad->region ? $ad->region . ', ' : '' }}
                {{ $ad->country ?? '' }}
            </div>

        </div>
    </div>
    <div class="flex-grow flex items-center flex-wrap gap-3 justify-between">
        <div class="space-y-2 flex flex-col items-center justify-center">
            @if ($ad->status == 'active')
                <x-frontend.my-listing.active-badge />
            @elseif($ad->resubmission == '1')
                <x-frontend.my-listing.resubmission-badge />
            @else
                <x-frontend.my-listing.status :status="$ad->status" />
            @endif
        </div>
        <div>
            <button type="button" @click="commentModal = true"
                class="inline-flex justify-center items-center gap-2 py-2 px-4 rounded-md transition-all duration-300 bg-primary-500 hover:bg-primary-600 text-white body-small-500">
                <small
                    class="w-4 h-4 rounded-full text-white flex items-center justify-center">
                    <x-frontend.icons.edit />
                </small>
                <span>{{ __('required_changes') }}</span>
            </button>
        </div>
        <div class="lg:pr-4 lg:static absolute top-[220px] end-4">
            <div>
                <div class="relative group" x-data="{ showMenu: false }" x-init @click.outside="showMenu = false">
                    <button type="button" @click="showMenu = !showMenu"
                        class="flex items-center justify-center ms-auto text-white  rounded-full w-9 h-9 bg-gray-100">
                        <x-svg.horizontal-dots />
                    </button>
                    <div class="absolute top-9 right-0 z-10" x-cloak x-show="showMenu" x-transition>
                        <ul
                            class=" bg-white border-gray-100 min-w-[15rem] sm:min-w-[18.3rem] py-3 rounded-lg shadow-[0px_4px_6px_-2px_rgba(16,24,40,0.03),0px_12px_16px_-4px_rgba(16,24,40,0.08)]">
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
    <!-- Main modal -->
    <div x-show="commentModal" x-cloak
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-4xl">
        <div class="relative mx-4 p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('comment') }}</h3>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <div> {!! $ad->comment !!}</div>
                    <h2 class="heading-06 text-center">
                        Galleries
                    </h2>
                    <div class="flex mt-6 overflow-x-auto no-scrollbar justify-center gap-5 items-center">
                        @foreach ($resubmissionGallery as $index => $data)
                            @if ($ad->id == $data->ad_id)
                                <a href="{{ $data->image }}" data-gall="gallery" class="venobox">
                                    <img class="min-w-[120px] max-w-[120px] h-[120px] object-contain border border-gray-100 rounded"
                                        src="{{ $data->image }}" alt="" />
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Modal footer -->
            </div>
            <button @click="commentModal = false"
                class="absolute -top-2 -right-2 p-3 bg-white rounded-full border border-primary-50">
                <x-frontend.icons.close />
            </button>
        </div>
    </div>
    <div x-show="commentModal" x-cloak @click="commentModal = false"
        class="fixed top-0 left-0 w-full h-full bg-black/50 z-10"></div>
</div>



