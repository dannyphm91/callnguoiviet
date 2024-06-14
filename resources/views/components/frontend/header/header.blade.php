<header x-data="data">
    <x-frontend.header.header-top />
    <x-frontend.header.search-bar />
    <x-frontend.header.header-main />
    <x-frontend.header.header-bottom />
    <x-frontend.header.responsive-header />
</header>
@push('js')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('data', () => ({
                mobileMenu: false,
                login: false,
                searchbar: false,
            }))
        })
    </script>
@endpush
