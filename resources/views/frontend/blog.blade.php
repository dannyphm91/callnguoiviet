@extends('frontend.layouts.app')

@section('title', __('blog_posts'))

@section('meta')
    @php
        $data = metaData('blog');
    @endphp

    <meta name="title" content="{{ $data->title }}">
    <meta name="description" content="{{ $data->description }}">

    <meta property="og:image" content="{{ $data->image_url }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $data->title }}">
    <meta property="og:url" content="{{ route('frontend.blog') }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{ $data->description }}">

    <meta name=twitter:card content="{{ $data->image_url }}" />
    <meta name=twitter:site content="{{ config('app.name') }}" />
    <meta name=twitter:url content="{{ route('frontend.blog') }}" />
    <meta name=twitter:title content="{{ $data->title }}" />
    <meta name=twitter:description content="{{ $data->description }}" />
    <meta name=twitter:image content="{{ $data->image_url }}" />
@endsection

@section('content')
    <div>
        {{-- <x-frontend.breadcrumb.breadcrumb :links="[['text' => __('blog')]]" /> --}}
        <x-frontend.breadcrumb.breadcrumb :links="[ ['url' => '#', 'text' => __('blog')] ]" />

        <!-- Blog-list section Start -->
        <section class="py-16 dark:bg-gray-800">
            <div class="container">
                <div class="flex flex-col lg:flex-row gap-6">
                    <div class="blog-sidebar flex flex-col gap-5 lg:w-1/3 w-full">

                        <!--  Search-->
                        <div class="p-8 rounded-lg bg-white dark:bg-gray-900 border border-gray-50 dark:border-gray-600 shadow">
                            <h2 class="heading-05 dark:text-white mb-4">{{ __('search') }}</h2>
                            <form action="{{ route('frontend.blog') }}" method="GET" id="searchForm">
                                <input type="search" name="keyword" value="{{ request('keyword') }}" placeholder="{{ __('search') }}"  class="tc-input">

                                <input id="categoryWiseSorting" name="category" type="hidden"
                                value="{{ request('category', '') }}">
                            </form>
                        </div>

                        <!-- Category -->
                        @if ($topCategories->count() > 0)
                            <div class="p-8 rounded-lg bg-white dark:bg-gray-900 border border-gray-50 dark:border-gray-600 shadow">
                                <div class="grid grid-cols-2 gap-5 ">
                                    @foreach ($topCategories as $category)
                                        <a href="{{ route('frontend.blog', ['category' => $category->slug]) }}" class="blog-category group">
                                            <img class="w-full h-20 object-cover transition-all duration-300 group-hover:scale-125"
                                                src="{{ $category->image_url }}" alt="category-img">
                                            <h2 class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50 text-center text-white w-full">{{ $category->name }}</h2>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <!-- Category -->

                        <!-- Recent Post -->
                        @if ($recentBlogs->count() > 0)
                            <div class="p-8 rounded-lg bg-white dark:bg-gray-900 border border-gray-50 dark:border-gray-600 shadow">
                                <h2 class="heading-05 dark:text-white mb-4">{{ __('recent_post') }}</h2>
                                <div class="flex flex-col gap-4">
                                    @foreach ($recentBlogs as $post)
                                        <a href="{{ route('frontend.single.blog', $post->slug) }}" class="flex gap-3 items-center group">
                                            <img class="w-20 h-16 rounded-md object-cover" src="{{ $post->image_url }}" alt="post-img">
                                            <div>
                                                <h3 class="body-md-500 dark:text-white line-clamp-1 mb-1.5 group-hover:text-primary-500">{{ Str::limit($post->title, 48, '...') }}</h3>
                                                <div class="body-sm-400 text-gray-600 dark:text-gray-400 flex gap-2 items-center">
                                                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                                                    <span>.</span>
                                                    <span>{{ $post->comments_count }} {{ __('comments') }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <!-- Recent Post -->

                        <!-- google adsense area  -->
                        @if (advertisementCode('blog_page_left'))
                            <div class="h-[400px] max-h-[400px]">
                                {!! advertisementCode('blog_page_left') !!}
                            </div>
                        @endif
                        <!-- google adsense area end -->
                        <!-- google adsense area end -->

                    </div>
                    <div class="lg:w-2/3 w-full">
                        @if ($blogs->count() > 0)
                            <div class="flex flex-col gap-5">
                                @foreach ($blogs as $key => $post)
                                   <!-- google adsense area  -->
                                    @if ($key == 3)
                                        @if (advertisementCode('blog_page_inside_blog'))
                                            <div class="h-[400px] max-h-[400px]">
                                                {!! advertisementCode('blog_page_inside_blog') !!}
                                            </div>
                                        @endif
                                    @endif
                                    <!-- google adsense area end -->

                                    <a href="{{ route('frontend.single.blog', $post->slug) }}"
                                        class="flex flex-col md:flex-row gap-6 md:items-center p-6 rounded-md dark:bg-gray-900 border border-gray-50 dark:border-gray-600 shadow hover:shadow-md transition-all duration-300 group">
                                        <img class="w-full min-h-[200px] md:min-w-[250px] md:max-w-[250px] rounded-md object-cover" src="{{ $post->image_url }}" alt="">
                                        <div>
                                            <h3 class="heading-06 dark:text-white mb-2 group-hover:text-primary-500">
                                                {{ Str::limit($post->title, 48, '...') }}
                                            </h3>
                                            <p class="body-sm-400 dark:text-gray-200 line-clamp-3 mb-4">{{ Str::limit($post->short_description, 180, '...') }}</p>
                                            <div class="body-sm-400 text-gray-600 dark:text-gray-400 flex gap-2 items-center">
                                                <span>{{ $post->created_at->format('M d, Y') }}</span>
                                                <span>.</span>
                                                <span>{{ $post->comments_count }} {{ __('comments') }}</span>
                                            </div>
                                            <button class="text-primary-500 mt-3">{{ __('read_more') }}</button>
                                        </div>
                                    </a>

                                @endforeach
                            </div>
                        @else
                            <div class="flex justify-center items-center">
                                <x-not-found2 message="No posts found" />
                            </div>
                        @endif

                        <!-- Pagination Start -->
                        <div class="page-navigation">
                            {{ $blogs->links('vendor.pagination.custom') }}
                        </div>
                        <!-- Pagination End -->

                    </div>
                </div>
            </div>
        </section>
        <!-- Blog-list section End -->

    </div>
@endsection
@push('css')
    <style>
    </style>
@endpush
