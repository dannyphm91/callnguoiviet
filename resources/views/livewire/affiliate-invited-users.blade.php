<div>
    <div
        class="space-y-[1rem] rounded-[0.75rem] border border-gray-100 dark:border-gray-600 shadow-[0px_1px_2px_0px_rgba(28,33,38,0.06),0px_1px_3px_0px_rgba(28,33,38,0.10)] p-[1.5rem]">
        <h6 class="body-md-500 text-gray-900 dark:text-white">{{ __('invited_users') }}</h6>
        <div class="divide-y divide-gray-100" id="affiliateInvitedUsersContainer">
            @if ($affiliateInvitedUsers->isNotEmpty())
                @foreach ($affiliateInvitedUsers as $index => $data)
                    <div
                        class="flex items-center justify-between pb-[1rem] affiliate-invited-user {{ $index >= $visibleRows ? 'hidden' : '' }}">
                        <div class="flex items-center gap-[0.75rem]">
                            <p class="body-md-400 text-gray-800">{{ $data->email }}</p>
                            <span
                                class="body-md-400 text-gray-600 dark:text-gray-100">{{ date('d M, Y', strtotime($data->created_at)) }}</span>
                        </div>
                        <div class="text-success-500 heading-07">
                            +{{ $data->points }} Points
                        </div>
                    </div>
                @endforeach
                @if (count($affiliateInvitedUsers) > $visibleRows)
                    <div class="w-full flex items-center justify-center">
                        <button wire:click="loadMore"
                            class="body-md-500 text-primary-500 dark:text-primary-50 hover:text-primary-600 transition-all duration-200 text-center">
                            {{ __('load_more') }}
                        </button>
                    </div>
                @endif
            @else
                <p class="dark:text-white">{{ __('no_data_found') }}</p>
            @endif
        </div>
    </div>
</div>
