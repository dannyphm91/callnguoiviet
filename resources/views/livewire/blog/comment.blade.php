<div>
    <!-- Comment Box  -->
    <h2 class="heading-04 mb-8 dark:text-white">{{ __('leave_comments') }}</h2>
    <div>
        <form wire:submit.prevent="storeComment" class="mb-4">
            <div class="flex flex-col gap-4">
                @if (!auth('user')->check())
                    <div class="flex flex-col md:flex-row gap-5">
                        <div class="w-full">
                            <x-forms.flabel name="full_name" for="name" class="tc-label" :required="true" />
                            <input type="text" id="name" wire:model.defer="name" autocomplete="off"
                                class="@error('name') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror tc-input"
                                placeholder="{{ __('full_name') }}" />
                            @error('name')
                                <span class="text-sm text-red-600 dark:text-red-500 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="w-full">
                            <x-forms.flabel name="email" for="email" class="tc-label" :required="true" />
                            <input type="email" wire:model.defer="email" autocomplete="off"
                                class=" @error('email') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror tc-input"
                                placeholder="{{ __('email_address') }}" id="email" />

                            @error('email')
                                <span class="text-sm text-red-600 dark:text-red-500 mt-1">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>
                @endif
                <div>
                    <x-forms.flabel name="comments" for="comments" class="tc-label" :required="true" />
                    <textarea wire:model.defer="body" autocomplete="off" cols="30" rows="10"
                        class=" @error('body') @twMerge('focus:border-red-500 hover:border-red-500 border-red-500') @enderror tc-input"
                        placeholder="{{ __('whats_your_thought') }}..." id="comments"></textarea>
                    @error('body')
                        <span class="text-sm text-red-600 dark:text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>
                @if (config('captcha.active'))
                    <div class="form-group mt-4">
                        <div wire:ignore>
                            {!! NoCaptcha::renderjs() !!}
                            {!! NoCaptcha::display(['data-callback' => 'onCallback']) !!}
                        </div>
                        @error('recaptcha')
                            <small class="text-sm text-red-600 dark:text-red-500 mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                @endIf
                <div>
                    <button onclick="countComments('{{ $post_id }}')" wire:loading.attr="disabled"
                        wire:click.prevent="storeComment" type="submit" class="btn-primary py-3 px-5">
                        <span>{{ __('comment') }}</span>
                        <span wire:loading wire:target="storeComment">
                            <span class="spinner-border spinner-border-sm" id="circle-notch"></span>
                        </span>
                        <span wire:loading.remove wire:target="storeComment" class="submit-arrow-icon">
                            <x-svg.arrow-long-icon />
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- User comments -->
    @if ($comments->count() > 0)
        <div>
            <h3 class="heading-04 mb-4">{{ __('comments') }}</h3>

            <div class="user-comments">
                @if ($total != 0)
                    <ul class="flex flex-col gap-3">
                        @foreach ($comments as $comment)
                            <li class="flex gap-3 items-center">
                                <img class="w-10 h-10 rounded-full object-cover"
                                    src="{{ asset('backend/image/default-user.png') }}" alt="user-img">
                                <div>
                                    <div class="flex gap-4 items-center mb-1">
                                        <p class="body-md-500">{{ $comment->name }}</p>
                                        <span class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="body-md-400 text-gray-600">{{ $comment->body }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
                @if ($loadbutton && $total >= 5)
                    @if (count($comments) >= $total)
                        <div class="text-center">{{ __('no_more_comments_found') }}</div>
                    @else
                        @if ($loading)
                            <button wire:loading wire:target="load" class="btn-primary mt-2">
                                {{ __('loading') }}
                                <span class="icon--right">
                                    <x-svg.sync-icon />
                                </span>
                            </button>
                        @else
                            <button wire:click="load" wire:loading.remove wire:target="load" class="btn-primary mt-2">
                                {{ __('load_more') }}
                                <span class="icon--right">
                                    <x-svg.sync-icon />
                                </span>
                            </button>
                        @endif
                    @endif
                @endif
            </div>
        </div>
    @endif

</div>

@push('css')
    <style>
        /* Form submit spinner circle css */
        .spinner-border {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            vertical-align: -.125em;
            border: .25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            -webkit-animation: .75s linear infinite spinner-border;
            animation: .75s linear infinite spinner-border;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: .2em;
        }

        @-webkit-keyframes spinner-border {
            to {
                transform: rotate(360deg)
            }
        }

        @keyframes spinner-border {
            to {
                transform: rotate(360deg)
            }
        }

        /* Form submit spinner circle css */
    </style>
@endpush

@push('js')
    <script type="text/javascript">
        var onCallback = function() {
            @this.set('recaptcha', grecaptcha.getResponse())
        };
    </script>
@endpush
