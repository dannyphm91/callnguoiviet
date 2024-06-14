@extends('frontend.layouts.app')
@section('content')
<x-frontend.breadcrumb.breadcrumb :links="[['text' => 'Dashboard', 'url' => '/dashboard'], ['text' => 'Post Ad']]" />
<section class="py-16">
    <div class="container">
        <div class="mx-auto" style="max-width: 872px;">
            <div class="flex flex-wrap gap-4 justify-between items-center mb-6">
                <h2 class="sm:heading-01 heading-03 dark:text-white text-gray-900">{{ __('post_your_ad') }}</h2>
                <a href="{{ route('frontend.dashboard') }}" class="inline-flex gap-1 items-center transition-all duration-300 heading-07 text-primary-500 hover:text-primary-700">
                    <x-svg.heroicons.arrow-left />
                    <span>{{ __('back_dashboard') }}</span>
                </a>
            </div>
            @if ($errors->any())
                <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <x-svg.info-icon fill="currentColor" />
                    <div>
                        <span class="font-medium">{{ __('ensure_that_these_requirements_are_met') }}</span>
                        <ul class="mt-1.5 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="dark:bg-white rounded-xl border border-gray-100 shadow-[0px_4px_8px_0px_rgba(28,33,38,0.08)]">
                <div class="post-header">
                    <button type="button"
                        class="btn-tab cursor-not-allowed {{ request()->routeIs('frontend.post') ? 'active' : '' }}">
                        <x-frontend.icons.adjustment-horizontal class="w-4 h-4 sm:w-6 sm:h-6" />
                        <span>{{ __('basic') }}</span>
                    </button>
                    <button type="button"
                        class="btn-tab cursor-not-allowed {{ request()->routeIs('frontend.post.step2') ? 'active' : '' }}">
                        <x-frontend.icons.adjustment-horizontal class="w-4 h-4 sm:w-6 sm:h-6" />
                        <span>{{ __('detail_info') }}</span>
                    </button>
                    <button type="button"
                        class="btn-tab cursor-not-allowed {{ request()->routeIs('frontend.post.step3') ? 'active' : '' }}">
                        <x-frontend.icons.adjustment-horizontal class="w-4 h-4 sm:w-6 sm:h-6" />
                        <span>
                            {{ __('contact_and_promote') }}
                        </span>
                    </button>
                </div>

                @yield('post-ad-content')
            </div>
        </div>
    </div>
</section>
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/js/choiceJs/choice.min.css') }}">
    <style>
        .choices[data-type*="select-one"] .choices__inner {
            padding: 11px 20px !important;
        }

        .choices[data-type*="select-one"] .choices__inner:has(#number),
        .choices[data-type*="select-one"] .choices__inner:has(#whatsappNumber),
        .choices[data-type*="select-one"] .choices__inner:has(#currency) {
            padding: 11px 10px !important;
        }

        .choices__list--single {
            padding: 0px !important;
            font-size: 1rem;
            line-height: 1.5rem;
            font-weight: 400;
        }

        .choices:has(#currency),
        .choices:has(#number),
        .choices:has(#whatsappNumber) {
            width: 100px !important;
        }


        .choices:has(#currency) .choices__list--dropdown .choices__item--selectable,
        .choices:has(#currency) .choices__list[aria-expanded] .choices__item--selectable,
        .choices:has(#number) .choices__list--dropdown .choices__item--selectable,
        .choices:has(#number) .choices__list[aria-expanded] .choices__item--selectable,
        .choices:has(#whatsappNumber) .choices__list--dropdown .choices__item--selectable,
        .choices:has(#whatsappNumber) .choices__list[aria-expanded] .choices__item--selectable {
            padding-right: 0px;
        }

        .choices__item--selectable::after {
            display: none;
        }

        .choices__inner:has(#currency),
        .choices__inner:has(#number),
        .choices__inner:has(#whatsappNumber) {
            box-shadow: none !important;
            border: none !important;
        }

        .preview-container {
            position: relative;
            display: inline-block;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #ff0000;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .btn-tab.active {
            border-bottom: 3px solid var(--primary-500);
            color: var(--primary-500);
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('uploadImages', () => ({

                images: [],
                handleFileInput(event) {
                    const files = event.target.files;
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        this.readFile(file).then(imageDataURL => {
                            this.appendImagePreview(imageDataURL, file.name);
                        });
                    }
                },
                readFile(file) {
                    return new Promise((resolve) => {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            resolve(event.target.result);
                        };
                        reader.readAsDataURL(file);
                    });
                },
                appendImagePreview(imageSrc, fileName) {
                    this.images.push({
                        url: imageSrc,
                        name: fileName
                    });
                },
                removeImage(index) {
                    this.images.splice(index, 1);
                }
            }))
        })
    </script>
@endpush
