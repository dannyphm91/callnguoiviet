<form class="form-horizontal" action="{{ route('admin.promotions.update') }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="card">
        <div class="card-header">
            {{ __('promotions') }}
        </div>
        <div class="card-body">
            {{-- translate button --}}
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <input type="hidden" class="d-none m-0" value="{{ request('lang_query') }}"
                            name="language_code" readonly>
                        <div class="d-flex flex-wrap justify-content-end">
                            @foreach ($languages as $language)
                                <a href="{{ route('admin.promotions.store', ['lang_query' => $language->code]) }}"
                                    class="a-color mt-2">
                                    <div class="filtertags close-tag pointer mr-2">
                                        <div
                                            class="single-tag {{ request('lang_query') == $language->code || (!request('lang_query') && $language->code == 'en') ? 'single-tag-active' : '' }}">
                                            {{ $language->name }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Promotion Banner --}}
            <div class="card pb-3">
                <div class="row">

                    <div class="col-12">
                        <div class="card-header">{{ __('update_promotion_banner_section') }}</div>
                    </div>
    
                    <div class="col-md-4">
                        <div class="form-group mb-0 px-3 pt-3 pb-3">
                            <x-forms.label name="promotion_banner_img" />
                            <input type="file" class="form-control dropify"
                                data-default-file="{{ asset(url($promotionBannerImg)) }}" name="promotion_banner_img"
                                autocomplete="image" data-allowed-file-extensions="jpg png jpeg"
                                accept="image/png, image/jpg, image/jpeg">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group mb-0 px-3 pt-3 pb-0">
                            <x-forms.label name="promotion_banner_title" />
                            <input type="text" class="form-control" placeholder="promotion_banner_title"
                                name="promotion_banner_title" value="{{ $promotionContent ? $promotionContent->title : $promotionBannerTitle }}">

                            @error('promotion_banner_title')
                                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="form-group mb-0 px-3 pt-3 pb-0">
                            <x-forms.label name="promotion_banner_text" />
                            <textarea id="promotions_ck" class="form-control" name="promotion_banner_text" placeholder="{{ __('write_the_answer') }}">{{ $promotionContent ? $promotionContent->text : $promotionBannerText }}</textarea>
    
                            @error('promotion_banner_text')
                                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Featured Promotion CMS --}}
            <div class="card pb-3">
                <div class="row">

                    <div class="col-12">
                        <div class="card-header">{{ __('update_featured_section') }}</div>
                    </div>
    
                    <div class="col-md-4">
                        <div class="form-group mb-0 px-3 pt-3 pb-3">
                            <x-forms.label name="featured_img" />
                            <input type="file" class="form-control dropify"
                                data-default-file="{{ asset(url($featuredImg)) }}" name="featured_img"
                                autocomplete="image" data-allowed-file-extensions="jpg png jpeg"
                                accept="image/png, image/jpg, image/jpeg">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group mb-0 px-3 pt-3 pb-0">
                            <x-forms.label name="featured_title" />
                            <input type="text" class="form-control" placeholder="featured_title"
                                name="featured_title" value="{{ $promotionContent ? $promotionContent->title_featured : $featuredTitle }}">

                            @error('featured_title')
                                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="form-group mb-0 px-3 pt-3 pb-0">
                            <x-forms.label name="featured_text" />
                            <textarea id="featured_ck" class="form-control" name="featured_text" placeholder="{{ __('write_the_answer') }}">{{ $promotionContent ? $promotionContent->text_featured : $featuredText }}</textarea>
    
                            @error('featured_text')
                                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Urgent Promotion CMS --}}
            <div class="card pb-3">
                <div class="row">

                    <div class="col-12">
                        <div class="card-header">{{ __('update_urgent_section') }}</div>
                    </div>
    
                    <div class="col-md-4">
                        <div class="form-group mb-0 px-3 pt-3 pb-3">
                            <x-forms.label name="urgent_img" />
                            <input type="file" class="form-control dropify"
                                data-default-file="{{ asset(url($urgentImg)) }}" name="urgent_img"
                                autocomplete="image" data-allowed-file-extensions="jpg png jpeg"
                                accept="image/png, image/jpg, image/jpeg">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group mb-0 px-3 pt-3 pb-0">
                            <x-forms.label name="urgent_title" />
                            <input type="text" class="form-control" placeholder="urgent_title"
                                name="urgent_title" value="{{ $promotionContent ? $promotionContent->title_urgent : $urgentTitle }}">
                            
                            @error('urgent_title')
                                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="form-group mb-0 px-3 pt-3 pb-0">
                            <x-forms.label name="urgent_text" />
                            <textarea id="urgent_ck" class="form-control" name="urgent_text" placeholder="{{ __('write_the_answer') }}">{{ $promotionContent ? $promotionContent->text_urgent : $urgentText }}</textarea>
    
                            @error('urgent_text')
                                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Highlight Promotion CMS --}}
            <div class="card pb-3">
                <div class="row">

                    <div class="col-12">
                        <div class="card-header">{{ __('update_highlight_section') }}</div>
                    </div>
    
                    <div class="col-md-4">
                        <div class="form-group mb-0 px-3 pt-3 pb-3">
                            <x-forms.label name="highlight_img" />
                            <input type="file" class="form-control dropify"
                                data-default-file="{{ asset(url($highlightImg)) }}" name="highlight_img"
                                autocomplete="image" data-allowed-file-extensions="jpg png jpeg"
                                accept="image/png, image/jpg, image/jpeg">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group mb-0 px-3 pt-3 pb-0">
                            <x-forms.label name="highlight_title" />
                            <input type="text" class="form-control" placeholder="highlight_title"
                                name="highlight_title" value="{{ $promotionContent ? $promotionContent->title_highlight : $highlightTitle }}">
                            
                            @error('highlight_title')
                                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="form-group mb-0 px-3 pt-3 pb-0">
                            <x-forms.label name="highlight_text" />
                            <textarea id="highlight_ck" class="form-control" name="highlight_text" placeholder="{{ __('write_the_answer') }}">{{ $promotionContent ? $promotionContent->text_highlight : $highlightText }}</textarea>
    
                            @error('highlight_text')
                                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Top Promotion CMS --}}
            <div class="card pb-3">
                <div class="row">

                    <div class="col-12">
                        <div class="card-header">{{ __('update_top_section') }}</div>
                    </div>
    
                    <div class="col-md-4">
                        <div class="form-group mb-0 px-3 pt-3 pb-3">
                            <x-forms.label name="top_img" />
                            <input type="file" class="form-control dropify"
                                data-default-file="{{ asset(url($topImg)) }}" name="top_img"
                                autocomplete="image" data-allowed-file-extensions="jpg png jpeg"
                                accept="image/png, image/jpg, image/jpeg">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group mb-0 px-3 pt-3 pb-0">
                            <x-forms.label name="top_title" />
                            <input type="text" class="form-control" placeholder="top_title"
                                name="top_title" value="{{ $promotionContent ? $promotionContent->title_top : $topTitle }}">
                            
                            @error('top_title')
                                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="form-group mb-0 px-3 pt-3 pb-0">
                            <x-forms.label name="top_text" />
                            <textarea id="top_ck" class="form-control" name="top_text" placeholder="{{ __('write_the_answer') }}">{{ $promotionContent ? $promotionContent->text_top : $topText }}</textarea>
    
                            @error('top_text')
                                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bump Up Promotion CMS --}}
            <div class="card pb-3">
                <div class="row">

                    <div class="col-12">
                        <div class="card-header">{{ __('update_bump_up_section') }}</div>
                    </div>
    
                    <div class="col-md-4">
                        <div class="form-group mb-0 px-3 pt-3 pb-3">
                            <x-forms.label name="bump_up_img" />
                            <input type="file" class="form-control dropify"
                                data-default-file="{{ asset(url($bumpUpImg)) }}" name="bump_up_img"
                                autocomplete="image" data-allowed-file-extensions="jpg png jpeg"
                                accept="image/png, image/jpg, image/jpeg">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group mb-0 px-3 pt-3 pb-0">
                            <x-forms.label name="bump_up_title" />
                            <input type="text" class="form-control" placeholder="bump_up_title"
                                name="bump_up_title" value="{{ $promotionContent ? $promotionContent->title_bump_up : $bumpUpTitle }}">
                            
                            @error('bump_up_title')
                                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="form-group mb-0 px-3 pt-3 pb-0">
                            <x-forms.label name="bump_up_text" />
                            <textarea id="bump_up_ck" class="form-control" name="bump_up_text" placeholder="{{ __('write_the_answer') }}">{{ $promotionContent ? $promotionContent->text_bump_up : $bumpUpText }}</textarea>
    
                            @error('bump_up_text')
                                <span class="text-danger" style="font-size: 13px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-sync"></i> {{ __('update_promotions_setting') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
