<div>
    @if ($total != 0)
        {{-- <div class="mb-4 bg-warning-50 p-[1rem] w-full flex items-center gap-[0.75rem] rounded-[0.5rem] heading-04 text-gray-900">
            <x-frontend.icons.star-yellow />
            {{ $rating_details['average'] }} {{ __('star_average_rating') }}
        </div> --}}

        <div class="space-y-[1.5rem]">
            @foreach ($reviews as $review)
                <div class="flex gap-x-[0.75rem]">

                    <a href="{{ route('frontend.seller.profile', $review->user->username) }}"
                        class="h-[2.5rem] md:h-[3rem] w-[2.5rem] md:w-[3rem] shrink-0 rounded-full overflow-hidden">
                        <img src="{{ $review->user->image_url }}" class="w-full object-cover" alt="user img">
                    </a>
                    <div class="space-y-[0.25rem] ">
                        <div class="flex items-center gap-x-[0.12rem]">
                            @if ($review->stars)
                                @for ($i = 0; $i < $review->stars; $i++)
                                    <small class="h-[1.2rem] w-[1.2rem] text-[#FF8E09]">
                                        <x-frontend.icons.star />
                                    </small>
                                @endfor
                            @endif
                        </div>

                        <div class="flex items-center gap-x-[0.5rem]">
                            <h4 class="body-sm-500 text-gray-900">{{ $review->user->name }}</h4>
                            <small class="body-sm-400 text-gray-500">
                                @if ($review->created_at->diffInMinutes() < 60)
                                    {{ $review->created_at->diffInMinutes() . ' min ago' }}
                                @else
                                    {{ $review->created_at->diffForHumans() }}
                                @endif
                            </small>
                        </div>
                        <div class="body-md-400 text-gray-900">
                            <p> {{ $review->comment }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <x-not-found2 message="No Review found" />
    @endif

    @if ($reviews->count() > 0)
        <div class="load-more mt-6">
            @if ($loadbutton && $total >= 5)
                @if (count($reviews) >= $total)
                    <div class="text-center">{{ __('no_more_reviews_found') }}</div>
                @else
                    <div>
                        <button wire:click="loadmoreReview" wire:loading.attr="disabled" class="btn-load-more flex shrink-0 p-[0.5rem_1rem] justify-center items-center rounded-[0.375rem] border border-gray-100 shadow-[0px_1px_2px_0px_rgba(28, 33, 38, 0.05)] heading-08 text-gray-700 hover:text-white transition-all duration-100 hover:bg-primary-500 mx-auto">
                            <span wire:loading wire:target="loadmoreReview">
                                {{ __('loading') }}...
                            </span>
                            <span wire:loading.remove wire:target="loadmoreReview">
                                <span>{{ __('load_more') }}</span>
                            </span>
                        </button>
                    </div>
                @endif
            @endif
        </div>
    @endif
</div>
