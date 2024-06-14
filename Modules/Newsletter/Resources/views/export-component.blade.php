<form action="{{ route('module.newsletter.export') }}" method="POST">
    @csrf
    <div>
        <div class="p-2">
            <label for="order_by">
                {{ __('order_by') }}
            </label>
            <select name="from" id="order_by" class="mr-1 form-control">
                <option selected value="latest">
                    {{ __('from_latest') }}
                </option>
                <option value="oldest">
                    {{ __('from_oldest') }}
                </option>
            </select>
        </div>
    </div>
    <div>
        <div class="p-2">
            <label for="numberall">
                {{ __('amount') }}
            </label>
            <div class="input-group">
                <input value="5" id="numberall" name="amount" placeholder="{{ __('amount') }}" type="number"
                    class="form-control">
                <div class="input-group-append">
                    <button type="button" onclick="All()" class="btn btn-block btn-outline-info" type="button">
                        {{ __('all') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="p-2">
            <label>
                {{ __('document_type') }}
            </label>
            <select name="type" style="" class="mr-1 form-control">
                <option selected value="csv">
                    {{ __('csv') }}
                </option>
                <option value="excel">
                    {{ __('excel') }}
                </option>
                <option value="pdf">
                    {{ __('pdf') }}
                </option>
            </select>
        </div>
    </div>
    <div class="m-2">
        <button type="submit" class="btn btn-block btn-outline-info btn-md">
            {{ __('download') }}
        </button>
    </div>
</form>

@section('script')
    <script>
        function All() {
            var phpData = "{!! $total !!}";
            $('#numberall').val(phpData);
        }

        $('#numberall').on('input', function() {
            var phpData = "{!! $total !!}";
            var value = $('#numberall').val();
            if (value > phpData) {
                $('#numberall').val(phpData);
            }
        });
    </script>
@endsection
