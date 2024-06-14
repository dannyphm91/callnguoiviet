@props(['links' => []])
<div class="bg-gray-50 dark:bg-gray-900">
    <div class="container">
        <div class="py-2.5">
            <ul class="breadcrumb-list flex gap-2 items-center">
                <li class="inline-flex items-center gap-2">
                    <a href="/" class="body-sm-400 transition-all duration-300 text-gray-600 dark:text-gray-300 hover:text-gray-900">{{__('home')}}</a>
                </li>
                @foreach ($links as $link)
                <li class="inline-flex items-center gap-2">
                    {{-- <span class="body-sm-400 text-gray-900">{{ data_get($link, 'text') }}</span> --}}
                    {{-- <span class="body-sm-400 text-gray-900">{{ __($link['text']) }}</span> --}}
                    <a href="{{ data_get($link, 'url') }}" class="body-sm-400 text-gray-900 dark:text-white">{{ __($link['text']) }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
