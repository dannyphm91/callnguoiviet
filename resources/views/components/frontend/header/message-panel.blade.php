@php
    $unread_message_count = unreadMessageCount();
@endphp
<div class="relative inline-flex" x-data="{ messagePanel: false }" @click.outside="messagePanel = false">
    <a href="{{ route('frontend.message') }}"
        class="transition-all duration-300 text-white/90 hover:text-white">
        <x-frontend.icons.chat />
    </a>
    @if ($unread_message_count > 0)
        <div class="absolute inline-flex items-center justify-center w-4 h-4 text-[8px] font-bold text-white bg-red-500 border border-white rounded-full -top-1 -right-1 dark:border-gray-900">
            {{ $unread_message_count }}
        </div>
    @endif
</div>
