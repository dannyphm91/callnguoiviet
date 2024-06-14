<div class="details-footer p-6">
<h2 class="text-gray-900 dark:text-white text-lg font-medium mb-2">{{ __('share_ads') }}:</h2>
<div x-data="{
    copyText: '{{ url()->current() }}',
    copyNotification: false,
    copyToClipboard() {
        navigator.clipboard.writeText(this.copyText);
        this.copyNotification = true;
        let that = this;
        setTimeout(function() {
            that.copyNotification = false;
        }, 3000);
    }
}">

<div class="input-group mb-3">
    <input type="text" class="tc-input" x-model="copyText" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
    <button @click="copyToClipboard();"
        class="btn btn-outline-secondary py-3 px-6 rounded-md bg-gray-100 hover:bg-gray-200 transition-all duration-300" type="button" id="button-addon2">
    <span x-show="!copyNotification" x-cloak>{{ __('copy') }}</span>
    <span x-show="copyNotification" x-cloak>&#10003; {{ __('copied') }}</span>
</button>

</div>

</div>

    <div class="flex flex-wrap gap-3 items-center">
        <!-- <span>Share ad</span> -->
        <ul class="flex flex-wrap gap-2 items-center">
            <li>
                <a href="javascript:void(0);" onclick="openPopUp('{{ socialMediaShareLinks(url()->current(), 'whatsapp') }}')" class="btn-social">
                    <x-svg.whatsapp-icon fill="#555B61" />
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" onclick="openPopUp('{{ socialMediaShareLinks(url()->current(), 'facebook') }}')" class="btn-social">
                    <x-svg.facebook-icon fill="#555B61" />
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" onclick="openPopUp('{{ socialMediaShareLinks(url()->current(), 'twitter') }}')" class="btn-social">
                    <x-svg.twitter-icon fill="#555B61" />
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" onclick="openPopUp('{{ socialMediaShareLinks(url()->current(), 'linkedin') }}')" class="btn-social">
                    <x-svg.linkedin-icon fill="#555B61" />
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" onclick="openPopUp('{{ socialMediaShareLinks(url()->current(), 'gmail') }}')" class="btn-social">
                    <x-svg.envelope-icon fill="#555B61" />
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" onclick="openPopUp('{{ socialMediaShareLinks(url()->current(), 'skype') }}')" class="btn-social">
                    <x-svg.skype-icon fill="#555B61" />
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" onclick="openPopUp('{{ socialMediaShareLinks(url()->current(), 'telegram') }}')" class="btn-social">
                    <x-svg.telegram-icon fill="#555B61" />
                </a>
            </li>

        </ul>
    </div>
</div>

@push('css')
    <style>
        .tc-input {
            width: 30% !important;
        }
    </style>
@endpush

@push('js')
    <script>
        function openPopUp(link) {
            var popupWidth = 600;
            var popupHeight = 400;

            var left = (window.innerWidth - popupWidth) / 2 + window.screenX;
            var top = (window.innerHeight - popupHeight) / 2 + window.screenY;

            window.open(link, 'popup', 'width=' + popupWidth + ',height=' + popupHeight + ',left=' + left + ',top=' + top);
        }
    </script>
@endpush
