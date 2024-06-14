@extends('frontend.layouts.app')

@section('title', $metatitle ?? __('ads'))

@section('meta')
    @php
        $data = metaData('ads');
    @endphp

    <meta name="title" content="{{ $data->title }}">
    <meta name="description" content="{{ $data->description }}">

    <meta property="og:image" content="{{ $data->image_url }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $data->title }}">
    <meta property="og:url" content="{{ route('frontend.ads') }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{ $data->description }}">

    <meta name=twitter:card content={{ $data->image_url }} />
    <meta name=twitter:site content="{{ config('app.name') }}" />
    <meta name=twitter:url content="{{ route('frontend.ads') }}" />
    <meta name=twitter:title content="{{ $data->title }}" />
    <meta name=twitter:description content="{{ $data->description }}" />
    <meta name=twitter:image content="{{ $data->image_url }}" />
@endsection

<?php
$currentUrl = Request::url();
$baseUrl = config('app.url');

// Parse the URL to get path components
$urlComponents = parse_url($currentUrl);
$pathSegments = explode('/', trim($urlComponents['path'], '/'));

$breadcrumbs = [];
$currentPath = '';

foreach ($pathSegments as $segment) {
    $currentPath .= '/' . $segment;
    $breadcrumbs[] = [
        'url' => rtrim($baseUrl . $currentPath, '/'),
        'text' => ucfirst(str_replace('-', ' ', $segment)),
    ];
}
?>

@section('content')
    <div class="" x-data="{ filter: false, activeFilter: false }">
        <!-- Render the Breadcrumbs -->
        <x-frontend.breadcrumb.breadcrumb :links="$breadcrumbs" />
        <!-- listing Section -->
        @livewire('adlist', ['brands' => $brands])
    </div>
@endsection


@push('css')
    <!-- Add venobox -->
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}" type="text/css" />
    <style>
        .vbox-child {
            max-width: 750px !important;
        }
    </style>
    <style>
        .galleryView {
            height: 520px;
            width: 100%;
        }


        @media (max-width: 767px) {
            .galleryView {
                height: 320px;
            }
        }

        @media (max-width: 525px) {
            .galleryView {
                height: 250px;
            }
        }

        .swiper.galleryList {
            height: 60px;
            box-sizing: border-box;
            padding: 0;
        }

        .galleryList .swiper-slide {
            width: 80px !important;
            height: 100%;
            border-radius: 6px;
            border: 1px solid var(--gray-100);
        }

        .galleryList .swiper-slide-thumb-active {
            opacity: 1;
            border: 3px solid var(--primary-500);
        }

        .galleryList .swiper-slide img {
            height: 100%;
            object-fit: cover;
        }

        .galleryList .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
            padding: 10px
        }

        .galleryList .swiper-slide img {
            height: 100%;
            object-fit: cover;
        }

        .galleryView .swiper-button-prev,
        .galleryView .swiper-button-next {
            width: 24px;
            height: 24px;
            border-radius: 124px;
            background: rgba(0, 0, 0, 0.50);
            padding: 6px;
            transition: all 0.4s ease-in;
        }

        .galleryView .swiper-button-prev:hover,
        .galleryView .swiper-button-next:hover {
            background: var(--primary-500);
        }

        .galleryView .swiper-button-next:after {
            content: url("data:image/svg+xml,%3Csvg width='12' height='12' viewBox='0 0 12 12' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4.125 2.25L7.875 6L4.125 9.75' stroke='white' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
            font-size: unset;
        }

        .galleryView .swiper-button-prev:after {
            content: url("data:image/svg+xml,%3Csvg width='12' height='12' viewBox='0 0 12 12' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4.125 2.25L7.875 6L4.125 9.75' stroke='white' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
            font-size: unset;
            transform: rotate(180deg)
        }
    </style>
@endpush
@push('js')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('filters', () => ({
                categories: @json(loadCategoriesSubcategories()),
                minprice: "{{ minMAxCurrency(minmax()['minPrice']) }}",
                maxprice: "{{ minMAxCurrency(minmax()['maxPrice']) }}",
                min: "{{ minMAxCurrency(minmax()['minPrice']) }}",
                max: "{{ minMAxCurrency(minmax()['maxPrice']) }}",
                minthumb: 0,
                maxthumb: 0,

                mintrigger() {
                    this.minprice = Math.min(this.minprice, this.maxprice - 500);
                    this.minthumb = ((this.minprice - this.min) / (this.max - this.min)) * 100;
                },

                maxtrigger() {
                    this.maxprice = Math.max(this.maxprice, this.minprice + 500);
                    this.maxthumb = 100 - (((this.maxprice - this.min) / (this.max - this.min)) * 100);
                },
            }))
        })

        function removeFilter(el) {
            el.parentElement.remove()
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#category').on('click', function(e) {
                // Prevent the default behavior of the button
                e.preventDefault();

                // Retrieve the data-category attribute from the clicked button
                var categoryValue = $(this).data('category');
                document.querySelector(`input[value="${categoryValue}"]`).checked = false;
                // Log the value to the console (you can use it as needed)
                console.log(categoryValue);
                Livewire.emit('checkboxUpdated', categoryValue);
                // Additional logic if needed...
            })

            document.addEventListener('livewire:load', function() {
                Livewire.on('categoryRemoved', function() {
                    // Handle the 'categoryRemoved' event
                    Livewire.emit('checkboxUpdated', categoryValue);

                    // You can perform additional actions here, such as updating the UI or making AJAX requests
                });
            });

            // Assuming you have a function to update filters based on URL parameters
            function updateFiltersFromUrl() {
                var selectedCategories = new URLSearchParams(window.location.search).getAll('selectedCategory');
                var selectedSubcategories = new URLSearchParams(window.location.search).getAll(
                    'selectedSubcategory');

                // Update the DOM elements with the selected categories and subcategories
                // ...

                // Example: Update a paragraph to show/hide based on the presence of filters
                var activeFilterParagraph = document.querySelector('.active-filter-paragraph');
                if (selectedCategories.length > 0 || selectedSubcategories.length > 0) {
                    activeFilterParagraph.style.display = 'block';
                } else {
                    if(activeFilterParagraph) {
                        activeFilterParagraph.style.display = 'none';
                    }
                }
            }

            // Call the function on page load
            window.onload = function() {
                updateFiltersFromUrl();
            };
        })
    </script>
  <script>
    window.addEventListener('update-selected-category', event => {
        let routeName = "{{ trim(route('frontend.ads'), '/') }}";
        let newUrl = routeName;
        const breadcrumb = document.querySelector('.breadcrumb-list');

        while (breadcrumb.children.length > 2) {
            breadcrumb.removeChild(breadcrumb.lastChild);
        }

        if (event.detail.category && event.detail.category.length > 0) {
            newUrl += '/' + event.detail.category;
            createNewChildList(event.detail.category, newUrl);
        }

        if (event.detail.subcategory && event.detail.subcategory.length > 0) {
            newUrl += '/' + event.detail.subcategory;
            createNewChildList(event.detail.subcategory, newUrl);
        }

        const pageTitle =
            `${capitalizeFirstLetter(event.detail.metatitle)}${event.detail.category ? ' ' + capitalizeFirstLetter(event.detail.category) : ''}${event.detail.subcategory ? ' ' + capitalizeFirstLetter(event.detail.subcategory) : ''}`;

        // Update the meta title
        document.title = pageTitle;

        // Add meta title dynamically
        const metaTitle = document.querySelector('meta[name="title"]');
        if (metaTitle) {
            metaTitle.setAttribute('content', pageTitle);
        } else {
            const newMetaTitle = document.createElement('meta');
            newMetaTitle.setAttribute('name', 'title');
            newMetaTitle.setAttribute('content', pageTitle);
            document.head.appendChild(newMetaTitle);
        }

        history.pushState(null, null, newUrl);

        function createNewChildList(name, url) {
            const listItem = document.createElement('li');
            listItem.classList.add('inline-flex', 'items-center', 'gap-2');

            const anchor = document.createElement('a');
            anchor.href = url;
            anchor.classList.add('body-sm-400', 'transition-all', 'duration-300', 'text-gray-600',
                'hover:text-gray-900');
            anchor.textContent = capitalizeWords(name);

            listItem.appendChild(anchor);
            breadcrumb.appendChild(listItem);
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function capitalizeWords(str) {
            return str.replace(/[^a-zA-Z ]/g, ' ').replace(/\b\w/g, match => match.toUpperCase());
        }

    });
</script>

@endpush
