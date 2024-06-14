<div>
<div class="select-wrapper mx-0 flex flex-col sm:grid sm:grid-cols-3 mt-2 w-100" style="gap:8px;">
    <div class="px-0 w-full mb-2">
        <select id="city" name="country" wire:model="selectedCountryId"
            class="select location city tc-input opacity-0">
            <option value="">{{ __('select_country') }}</option>
            @foreach ($countries as $country)
                <option value="{{ $country['name'] }}">{{ $country['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="px-0 w-full mb-2">
        <select name="state" id="state" wire:model="selectedStateId"
            class="select location zone tc-input opacity-0">
            <option value="">{{ __('select_state') }}</option>
            @foreach ($states as $state)
                <option value="{{ $state['name'] }}">{{ $state['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="px-0 w-full mb-2">
        <select name="district" id="district" wire:model="selectedCityId"
            class="select location area tc-input opacity-0">
            <option value="">{{ __('select_city') }}</option>
            @foreach ($cities as $city)
                <option value="{{ $city['name'] }}">{{ $city['name'] }}</option>
            @endforeach
        </select>
    </div>
</div>
<style>
    .location+.bigdrop,
    .location+.select2-container {
        width: 100% !important;
    }

    @media (max-width: 1199px) {
        .location+.select2-container {
            margin: 4px 0px;
        }
    }

    .location+.select2-container .select2-selection--single,
    .location+.select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 44px !important;
    }

    .location+.select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 44px !important;
    }
</style>

@push('js')
    @livewireScripts

    <script>
        $(document).ready(function() {
            $('.select').select2();
        });
        window.addEventListener('render-select2', event => {
            $('.select').select2();
        })
    </script>
    <script>
        $(".location.city").on('change', function(e) {
            let id = $(this).val()
            @this.set('selectedCountryId', id);
            livewire.emit('getStateByCountryId');
        })


        $(".location.zone").on('change', function(e) {
            let id = $(this).val()
            @this.set('selectedStateId', id);
            livewire.emit('getCityByStateId', id);
        })

        $(".location.area").on('change', function(e) {
            let id = $(this).val()
            @this.set('selectedCityId', id);
        })
    </script>
@endpush
</div>