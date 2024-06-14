@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item page-navigation__item page-navigation__next">
                    <a class="page-link page-navigation__link" aria-label="Previous">
                        <span aria-hidden="true">
                            <x-svg.left-arrow-icon stroke="currentColor" />
                        </span>
                    </a>
                </li>
            @else
                <li class="page-item page-navigation__item page-navigation__prev">
                    <a class="page-link page-navigation__link" href="{{ $paginator->previousPageUrl() }}"
                        aria-label="Previous">
                        <span aria-hidden="true">
                            <x-svg.left-arrow-icon stroke="currentColor" />
                        </span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item page-navigation__item"><a
                            class="page-link page-navigation__link">{{ $element }}</a></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item page-navigation__item"><a
                                    class="page-link page-navigation__link active bg-primary">{{ $page }}</a></li>
                        @else
                            <li class="page-item page-navigation__item"><a href="{{ $url }}"
                                    class="page-link page-navigation__link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item page-navigation__item page-navigation__next">
                    <a class="page-link page-navigation__link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">
                            <x-svg.right-arrow-icon stroke="currentColor" />
                        </span>
                    </a>
                </li>
            @else
                <li class="page-item page-navigation__item page-navigation__prev">
                    <a class="page-link page-navigation__link" aria-label="Next">
                        <span aria-hidden="true">
                            <x-svg.right-arrow-icon stroke="currentColor" />
                        </span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif

<style>
    .page-link {
        display: inline !important;
    }
</style>
