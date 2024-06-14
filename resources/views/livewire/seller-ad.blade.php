<div>
    @if ($total != 0)
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3">
            @foreach ($ad_data as $ad)
                <x-frontend.ad-card.card :ad="$ad" />
            @endforeach
        </div>
    @else
        <x-not-found2 message="{{ __('no_ads_found') }}" />
    @endif

    @if ($ad_data->count() > 0)
        <div class="load-more mt-6">
            @if ($loadButton && $total >= 9)
                @if (count($ad_data) >= $total)
                    <div class="text-center">{{ __('no_more_ads_found') }}</div>
                @else
                    <div>
                        <button wire:click="loadMore" wire:loading.attr="disabled" class="btn-load-more flex shrink-0 p-[0.5rem_1rem] justify-center items-center rounded-[0.375rem] border border-gray-100 shadow-[0px_1px_2px_0px_rgba(28, 33, 38, 0.05)] heading-08 text-gray-700 hover:text-white transition-all duration-100 hover:bg-primary-500 mx-auto">
                            <span wire:loading wire:target="loadMore">
                                {{ __('loading') }}...
                            </span>
                            <span wire:loading.remove>
                                <span>{{ __('load_more') }}</span>
                            </span>
                        </button>
                    </div>
                @endif
            @endif
        </div>
    @endif

</div>
@push('js')
<script>
  let isToastVisible = false;

  window.addEventListener('alert', event => {
    if (!isToastVisible) {
      isToastVisible = true;

      toastr.clear();

      toastr.options = {
        "closeButton": true,
        "progressBar": false,
        "onHidden": function () {
          isToastVisible = false;
        }
      };

      toastr[event.detail.type](
        event.detail.message,
        event.detail.title ?? ''
      );
    }
  });
</script>
@endpush
