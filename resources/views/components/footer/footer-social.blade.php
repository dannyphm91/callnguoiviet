<ul class="social-icon">
    <!-- facebook -->
    @if ($setting->facebook)
    <li class="social-icon__item">
        <a href="{{ $setting->facebook }}" class="social-icon__link">
            <x-svg.facebook-icon fill="currentColor"/>
            <span class="sr-only">facebook</span>
        </a>
    </li>
    @endif

    <!-- Twitter -->
    @if ($setting->twitter)
    <li class="social-icon__item">
        <a href="{{ $setting->twitter }}" class="social-icon__link">
            <x-svg.twitter-icon fill="currentColor" />
            <span class="sr-only">twitter</span>
        </a>
    </li>
    @endif

    <!-- Instagram -->
    @if ($setting->instagram)
    <li class="social-icon__item">
        <a href="{{ $setting->instagram }}" class="social-icon__link">
            <x-svg.instagram-icon />
            <span class="sr-only">instagram</span>
        </a>
    </li>
    @endif

    <!-- Youtube -->
    @if ($setting->youtube)
    <li class="social-icon__item">
        <a href="{{ $setting->youtube }}" class="social-icon__link">
           <x-svg.youtube-icon />
           <span class="sr-only">youtube</span>
        </a>
    </li>
    @endif

    <!-- Linkedin -->
    @if ($setting->linkdin)
    <li class="social-icon__item">
        <a href="{{ $setting->linkdin }}" class="social-icon__link">
            <x-svg.linkedin-footer-icon />
            <span class="sr-only">linkdin</span>
        </a>
    </li>
    @endif

    <!-- whats app -->
    @if ($setting->whatsapp)
    <li class="social-icon__item">
        <a href="{{ $setting->whatsapp }}" class="social-icon__link">
            <x-svg.whatsapp-footer-icon />
            <span class="sr-only">whatsapp</span>
        </a>
    </li>
    @endif
</ul>
