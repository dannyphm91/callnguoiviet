@props(['for', 'text' => null])

@error($for)
<p {{ $attributes->merge(['class' => 'text-sm text-red-600']) }}>
    {{ $text ?? $message }}
</p>
@enderror