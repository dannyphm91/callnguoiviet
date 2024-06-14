@props(['ad' => null])
<div class="bg-gray-50 dark:bg-gray-900 border border-l-0 border-gray-100 lg:rounded-r-lg py-10 relative">
    <div class="swiper galleryView">
        <div class="swiper-wrapper venobox">
            <div class="swiper-slide">
                <a href="{{ $ad->image_url }}" id='first' class="w-full h-full flex justify-center"
                    data-gall="myGallery">
                    <img class="h-full object-cover" src="{{ $ad->image_url }}" />
                </a>
            </div>
            @foreach ($ad->galleries as $gallery)
                <div class="swiper-slide">
                    <a href="{{ $gallery->image_url }}" class="w-full h-full flex justify-center" data-gall="myGallery">
                        <img class="h-full  object-cover" src="{{ $gallery->image_url }}" />
                    </a>
                </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <a href="{{ $ad->image_url }}" data-gall="myGallery"
        class="venobox bg-white hover:bg-primary-50 transition-all duration-300 z-50 p-2.5 border border-gray-100 rounded-full absolute top-4 right-4">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3.75 8.25V3.75H8.25M3.75 15.75V20.25H8.25M15.75 3.75L20.25 3.75V8.25M15.75 20.25H20.25V15.75"
                stroke="#1C2126" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>
</div>
<div class="p-5">
    <div thumbsSlider="" class="swiper galleryList">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{ $ad->image_url }}" />
            </div>
            @foreach ($ad->galleries as $gallery)
                <div class="swiper-slide">
                    <img src="{{ $gallery->image_url }}" />
                </div>
            @endforeach
        </div>
    </div>
</div>
@push('css')
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
