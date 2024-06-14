<div>
    <div class="space-y-[1rem] rounded-[0.75rem] border border-gray-100 dark:border-gray-600 shadow-[0px_1px_2px_0px_rgba(28,33,38,0.06),0px_1px_3px_0px_rgba(28,33,38,0.10)] py-[1.5rem]">
        <h6 class="body-md-500 text-gray-900 dark:text-white px-[1.5rem]">{{__('points_converting_history')}}</h6>
        <div class="relative overflow-x-auto">
            <table class="w-full text-left">
                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700 w-full">
                    <tr>
                        <th scope="col" class="py-[0.5rem] px-[1.5rem]">#</th>
                        <th scope="col" class="py-[0.5rem] px-[1.5rem]">{{__('date')}}</th>
                        <th scope="col" class="py-[0.5rem] px-[1.5rem]">{{__('points')}}</th>
                        <th scope="col" class="py-[0.5rem] px-[1.5rem]">{{__('pricing')}}</th>
                        <th scope="col" class="py-[0.5rem] px-[1.5rem]">{{__('status')}}</th>
                    </tr>
                </thead>
                <div class="px-[1.5rem]">
                    <tbody id="affiliatePointHistoryBody">
                        @if ($affiliatePointHistory->isNotEmpty())
                            @foreach ($affiliatePointHistory as $index => $data)
                                <tr class="border-b border-b-gray-100 body-md-400 text-gray-900 dark:text-white {{ $index >= $visibleRows ? 'hidden' : '' }}">
                                    <td scope="row" class="px-[1.5rem] py-[1rem]   whitespace-nowrap">#{{$data->order_id}}</td>
                                    <td class="px-[1.5rem] py-[1rem]">{{date('d M, Y', strtotime($data->created_at))}}</td>
                                    <td class="px-[1.5rem] py-[1rem]">{{number_format($data->points)}} Points</td>
                                    <td class="px-[1.5rem] py-[1rem]">{{changeCurrency(number_format($data->pricing, 2))}}</td>
                                    <td class="px-[1.5rem] py-[1rem] capitalize">
                                        @if ($data->status == 0)
                                            <span class="bg-primary-50 rounded-[0.25rem] text-primary-500 py-[0.375rem] px-[0.625rem] inline-flex items-center justify-center caption-03">PENDING</span>
                                        @else
                                            <span class="bg-success-50 dark:bg-success-700 rounded-[0.25rem] text-success-500 dark:text-success-200 py-[0.375rem] px-[0.625rem] inline-flex items-center justify-center caption-03">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <td class="px-[1.5rem] py-[1rem]"> {{__('no_data_found')}}</td>
                        @endif
                    </tbody>
                </div>
            </table>
        </div>
        @if (sizeof($affiliatePointHistory) > $visibleRows)
            <div class="w-full flex items-center justify-center">
                <button wire:click="loadMore" class="body-md-500 text-primary-500 hover:text-primary-600 transition-all duration-200 text-center">
                    {{__('load_more')}}
                </button>
            </div>
        @endif
    </div>
</div>
