@props(['class' => 'tc-label', 'name', 'for' => null, 'required' => false])

<label name="{{ $name }}" class="{{ $class }}" for="{{ $for ? $for:$name }}">
    {{ __($name) }}
    @if ($required == "true")
        <span class="text-red-600">*</span>
    @endif
    {{ $slot }}
</label>


