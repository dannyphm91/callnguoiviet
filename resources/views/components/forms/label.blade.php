<label class="{{ $class }}" for="{{ $for ? $for:$name }}">
    {{ __($name) }}

    @if ($required == "true")
        <span class="form-label-required text-danger">*</span>
    @endif

    {{ $slot }}
</label>
