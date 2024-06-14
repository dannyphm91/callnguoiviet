@props(['ad' => null])
<div class="bg-gray-50 dark:bg-gray-900 mb-8 border border-l-0 border-gray-100 lg:rounded-r-lg py-10 relative">
    <div class="swiper galleryView2">
        <div class="swiper-wrapper venobox">
            <div class="swiper-slide">
                <img class="h-full w-full max-w-full object-contain" src="{{ $ad->image_url }}" />
            </div>
            @foreach ($ad->galleries as $gallery)
                <div class="swiper-slide">
                    <img class="h-full w-full max-w-full object-contain" src="{{ $gallery->image_url }}" />
                </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
@push('css')
    <style>
        .galleryView2 {
            height: 520px;
            width: 100%;
        }


        @media (max-width: 767px) {
            .galleryView2 {
                height: 320px;
            }
        }

        @media (max-width: 525px) {
            .galleryView2 {
                height: 250px;
            }
        }

        .galleryView2 .swiper-button-prev,
        .galleryView2 .swiper-button-next {
            width: 24px;
            height: 24px;
            border-radius: 124px;
            background: rgba(0, 0, 0, 0.50);
            padding: 6px;
            transition: all 0.4s ease-in;
        }

        .galleryView2 .swiper-button-prev:hover,
        .galleryView2 .swiper-button-next:hover {
            background: var(--primary-500);
        }

        .galleryView2 .swiper-button-next:after {
            content: url("data:image/svg+xml,%3Csvg width='12' height='12' viewBox='0 0 12 12' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4.125 2.25L7.875 6L4.125 9.75' stroke='white' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
            font-size: unset;
        }

        .galleryView2 .swiper-button-prev:after {
            content: url("data:image/svg+xml,%3Csvg width='12' height='12' viewBox='0 0 12 12' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4.125 2.25L7.875 6L4.125 9.75' stroke='white' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
            font-size: unset;
            transform: rotate(180deg)
        }
    </style>
@endpush
