@extends('frontend.layouts.app')

@section('title')
    {{ $blog->title }}
@endsection

@section('meta')
    <meta name="title" content="{{ $blog->title }}">
    <meta name="description" content="{{ $blog->short_description }}">

    <meta property="og:image" content="{{ $blog->image_url }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $blog->title }}">
    <meta property="og:url" content="{{ route('frontend.single.blog', $blog->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:description" content="{{ $blog->short_description }}">

    <meta name=twitter:card content=summary_large_image />
    <meta name=twitter:site content="{{ config('app.name') }}" />
    <meta name=twitter:creator content="{{ $blog->author->name }}" />
    <meta name=twitter:url content="{{ route('frontend.single.blog', $blog->slug) }}" />
    <meta name=twitter:title content="{{ $blog->title }}" />
    <meta name=twitter:description content="{{ $blog->short_description }}" />
    <meta name=twitter:image content="{{ $blog->image_url }}" />
@endsection

@section('content')
    <div>
        {{-- <x-frontend.breadcrumb.breadcrumb :links="[['text' => __('blog')], ['text' => $blog->title]]" /> --}}
            <x-frontend.breadcrumb.breadcrumb :links="[ ['url' =>  route('frontend.blog'), 'text' =>  __('blog')] ,['url' => '#', 'text' => $blog->title] ]" />

        <section class="md:py-16 py-8 dark:bg-gray-800">
            <div class="container">
                <div class="blog-deatils">
                    <img class="w-full mb-8 object-cover max-h-[600px]"
                        {{-- src="{{ asset('frontend/images/blog-details.webp') }}" alt=""> --}}
                        src="{{ $blog->image_url }}" alt="blog-img">

                    <div class="flex flex-col lg:flex-row gap-6">

                        <!-- Blog Details Left Content Area Start -->
                        <div class="lg:w-2/3 w-full">
                            <div class="blog-details-info mb-8">
                                <div class="body-sm-400 dark:text-gray-100 text-gray-600 flex gap-2 items-center">
                                    <span>{{ $blog->created_at->format('M d, Y') }}</span>
                                    <span>.</span>
                                    <span>{{ $blog->comments_count }} {{ __('comments') }}</span>
                                </div>
                                <div class="flex flex-wrap gap-5 justify-between items-center my-4 dark:text-gray-100">
                                    <div class="flex gap-3 items-center">
                                        <img class="w-10 h-10 rounded-full object-cover" src="{{ asset($blog->author->image) }}" alt="author-img">
                                        <h3>{{ $blog->author->name }}</h3>
                                    </div>
                                    <ul class="flex flex-wrap gap-2 items-center">
                                        <li>
                                            <a href="{{ socialMediaShareLinks(url()->current(), 'facebook') }}" class="btn-social rounded-full">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ socialMediaShareLinks(url()->current(), 'twitter') }}" class="btn-social rounded-full">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ socialMediaShareLinks(url()->current(), 'whatsapp') }}" class="btn-social rounded-full">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ socialMediaShareLinks(url()->current(), 'linkedin') }}" class="btn-social rounded-full">
                                                <i class="fab fa-linkedin"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <h2 class="heading-04 mb-4 dark:text-white">{{ $blog->title }}</h2>

                                <p class="body-md-400 text-gray-600 dark:text-gray-100">
                                    {!! $blog->description !!}
                                </p>
                            </div>

                            <!-- Comment Area Start -->
                            @livewire('blog.comment', ['post_id' => $blog->id])
                            <!-- Comment Area End -->

                        </div>
                        <!-- Blog Details Left Content Area Start -->

                        <!-- Blog Details Sidebar Start -->
                        <div class="blog-sidebar flex flex-col gap-5 lg:w-1/3 w-full">
                            <form action="{{ route('frontend.blog') }}" method="GET" id="searchForm">
                                <input id="categoryWiseSorting" name="category" type="hidden" value="">
                            </form>

                            <!-- Category -->
                            @if ($categories->count() > 0)
                                <div class="p-8 rounded-lg bg- dark:bg-gray-900 border border-gray-50 dark:border-gray-600 shadow">
                                    <div class="grid grid-cols-2 gap-5 ">
                                        @foreach ($categories as $category)
                                            <a href="{{ route('frontend.blog', ['category' => $category->slug]) }}"
                                                class="blog-category group">
                                                <img class="w-full h-20 object-cover transition-all duration-300 group-hover:scale-125"
                                                    src="{{ $category->image_url }}" alt="category-img">
                                                <h2
                                                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50 text-center text-white w-full">
                                                    {{ $category->name }}</h2>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <!-- Category -->

                            <!-- Recent Post -->
                            @if ($recentPost->count() > 0)
                                <div class="p-8 rounded-lg bg-white dark:bg-gray-900 border border-gray-50 dark:border-gray-600 shadow">
                                    <h2 class="heading-05 mb-4 dark:text-white">{{ __('recent_post') }}</h2>
                                    <div class="flex flex-col gap-4">
                                        @foreach ($recentPost as $post)
                                            @if ($loop->index == 3)
                                            @if (advertisementCode('blog_detail_page_right'))
                                                <div class="h-[400px] max-h-[400px]">
                                                    {!! advertisementCode('blog_detail_page_right') !!}
                                                </div>
                                            @endif
                                            @else
                                                <a href="{{ route('frontend.single.blog', $post->slug) }}"
                                                    class="flex gap-3 items-center group">
                                                    <img class="w-20 h-16 rounded-md object-cover"
                                                        src="{{ $post->image_url }}" alt="post-img">
                                                    <div>
                                                        <h3
                                                            class="body-md-500 dark:text-white line-clamp-1 mb-1.5 group-hover:text-primary-500">
                                                            {{ Str::limit($post->title, 48, '...') }}</h3>
                                                        <div class="body-sm-400 text-gray-600 dark:text-gray-300 flex gap-2 items-center">
                                                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                                                            <span>.</span>
                                                            <span>{{ $post->comments_count }} {{ __('comments') }}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <!-- Recent Post -->

                        </div>
                        <!-- Blog Details Sidebar End -->

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('css')
    <style>
    </style>
@endpush

@push('js')
    <script>
        function countComments(postId) {
            setTimeout(function() {
                $.ajax({
                    type: 'GET',
                    url: '/blog/comments/count/' + postId,
                    success: function(data) {
                        $("#comment_count").html(data + ' Comments');
                    }
                });
            }, 2000);
        }

        function sorting(categorySlug) {
            $('#categoryWiseSorting').val(categorySlug)
            $('#searchForm').submit()
        }
    </script>
@endpush
