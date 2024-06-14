@if ($paginator->hasPages())
    <div class="flex flex-wrap justify-center items-center mx-auto gap-4 mt-6">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button class="px-4 py-2 dark:bg-gray-900 flex items-center justify-center gap-[0.37rem] rounded-[0.375rem] shadow-sm border border-gray-100 dark:border-gray-600 heading-08 text-gray-700 dark:text-white cursor-not-allowed" type="button">
                <small>
                    <x-frontend.icons.arrow-left />
                </small>
                Previous
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 dark:bg-gray-900 flex items-center justify-center gap-[0.37rem] rounded-[0.375rem] shadow-sm border border-gray-100 dark:border-gray-600 heading-08 text-gray-700 hover:bg-primary-500 hover:text-white transition-all duration-300">
                <small>
                    <x-frontend.icons.arrow-left />
                </small>
                Previous
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="h-[2.5rem] w-[2.5rem] py-2 rounded-[0.375rem] border hover:bg-primary-50 flex items-center justify-center border-gray-100 body-sm-500 text-gray-700 ">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="h-[2.5rem] w-[2.5rem] py-2 rounded-[0.375rem] border hover:bg-primary-50 flex items-center justify-center border-gray-100 dark:border-gray-600 hover:border-primary-500 hover:text-primary-500 body-sm-500 text-white bg-primary-500 dark:bg-primary-700">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">
                            <span class="h-[2.5rem] w-[2.5rem] py-2 rounded-[0.375rem] dark:bg-gray-900 dark:text-white border hover:bg-primary-50 flex items-center justify-center border-gray-100 dark:border-gray-600 hover:border-primary-500 hover:text-primary-500 body-sm-500 text-gray-700">
                                {{ $page }}
                            </span>
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

         {{-- Next Page Link --}}
         @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 dark:bg-gray-900 flex items-center justify-center gap-[0.37rem] rounded-[0.375rem] shadow-sm border border-gray-100 dark:border-gray-600 heading-08 text-gray-700 dark:text-white hover:bg-primary-500 hover:text-white transition-all duration-300">
                Next
                <x-frontend.icons.arrow-right />
            </a>
        @else
            <button class="px-4 py-2 dark:bg-white flex items-center justify-center gap-[0.37rem] rounded-[0.375rem] shadow-sm border border-gray-100 heading-08 text-gray-700 cursor-not-allowed" type="button">
                Next
                <x-frontend.icons.arrow-right />
            </button>
        @endif
    </div>
@endif

<style>
    .page-link {
        display: inline !important;
    }
</style>
