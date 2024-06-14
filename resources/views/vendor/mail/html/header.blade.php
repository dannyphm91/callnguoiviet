<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (isset($setting))
                @if (isset($setting->logo_image_url))
                    <img src="{{ $setting->logo_image_url }}" style="height: 48px; width:182px;" id="logo"
                        alt="{{ config('app.name') }}">
                @else
                    {{ config('app.name') }}
                @endif
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
