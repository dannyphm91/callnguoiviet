@props(['ad' => null, 'product_custom_field_groups' => []])

<div class="flex flex-col gap-2 px-5 pb-5">
    <h3 class="heading-07 text-gray-900 dark:text-white">{{ __('descriptions') }}</h3>
    {{-- <div class="body-md-400 text-gray-700">
        {!! $ad?->description ?? '' !!}
    </div> --}}
    <div x-data="{ showFullDescription: false }" class="body-md-400 text-gray-700 dark:text-gray-200">
        <div x-show="!showFullDescription" class="flex flex-col items-start gap-2">
            <div>{!! Str::limit($ad?->description ?? '', 300) !!}</div>
            <button @click="showFullDescription = true" class="text-primary-500 hover:underline focus:outline-none">Show
                more</button>
        </div>
        <div x-show="showFullDescription" class="flex flex-col items-start gap-2">
            <div>{!! $ad?->description ?? '' !!}</div>
            <button @click="showFullDescription = false" class="text-primary-500 hover:underline focus:outline-none">Show
                less</button>
        </div>
    </div>

    @if ($ad->video_url)
        <iframe width="700" height="300" src="{{ $ad->video_url }}" title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen></iframe>
    @endif
</div>

@foreach ($productCustomFieldGroups as $key => $customFieldGroup)
    <div class="mb-2">
        <h2 class="heading-06 text-gray-900 dark:text-white mx-6 my-4">
            {{ $customFieldGroup[0]->customField->customFieldGroup->name }}
        </h2>
        <div class="bg-primary-50 dark:bg-gray-900 lg:rounded-r-lg border-t border-b border-primary-100 dark:border-gray-400 px-5 py-[18px]">
            <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
                @foreach ($customFieldGroup as $field)
                    @if ($field->value)
                        @if ($field->customField->type == 'file')
                            <div class="flex flex-grow items-start gap-3">
                                <i class="{{ $field->customField->icon }} text-primary-500 fa-1x"></i>
                                <div>
                                    <p class="body-sm-400 test-gray-700 dark:text-gray-200 mb-1">
                                        {{ $field->customField->name }}
                                    </p>
                                    @if ($field->value)
                                        <a download href="/{{ $field->value }}"
                                            class="underline dark:text-white">{{ __('download') }}</a>
                                    @else
                                        {{ __('no_file_found') }}
                                    @endif
                                </div>
                            </div>
                        @elseif ($field->customField->type == 'url')
                            <div class="flex flex-grow items-start gap-3">
                                <i class="{{ $field->customField->icon }} text-primary-500 fa-1x"></i>
                                <div>
                                    <p class="body-sm-400 test-gray-700 dark:text-gray-200 mb-1">
                                        {{ $field->customField->name }}
                                    </p>
                                    <a target="_blank"
                                        class="text-sm w-[200px] dark:text-white overflow-hidden whitespace-nowrap text-ellipsis"
                                        href="{{ $field->value }}">{{ $field->value }}</a>
                                </div>
                            </div>
                        @elseif ($field->customField->type == 'date')
                            <div class="flex flex-grow items-start gap-3">
                                <i class="{{ $field->customField->icon }} text-primary-500 fa-1x"></i>
                                <div>
                                    <p class="body-sm-400 test-gray-700 dark:text-gray-200 mb-1">
                                        {{ $field->customField->name }}
                                    </p>
                                    <p class="body-md-500 text-gray-900 dark:text-white">
                                        {{ formatDate($field->value, 'd M, Y') }}
                                    </p>
                                </div>
                            </div>
                        @elseif ($field->customField->type == 'checkbox')
                            <div class="flex flex-grow items-start gap-2">
                                <i class="{{ $field->customField->icon }} text-primary-500 dark:text-primary-300 fa-1x"></i>
                                <div>
                                    <p class="body-sm-400 test-gray-700 dark:text-gray-200 mb-1">
                                        {{ $field->customField->name }}
                                    </p>
                                    <span class="body-md-500 text-gray-900 dark:text-white">
                                        @foreach ($field->customField->values as $value)
                                            @if ($loop->first)
                                                {{ $value->value }}
                                            @endif
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                        @elseif ($field->customField->type == 'checkbox_multiple')
                            <div class="flex flex-grow items-start gap-3">
                                <i class="{{ $field->customField->icon }} text-primary-500 dark:text-primary-300 fa-1x"></i>
                                <div>
                                    <p class="body-sm-400 test-gray-700 dark:text-gray-200 mb-1">
                                        {{ $field->customField->name }}
                                    </p>
                                    <span class="body-md-500 text-gray-900 dark:text-white">
                                        @php
                                            $selected_items = explode(', ', $field?->value);
                                            $all_values = $field?->customField?->values->toArray();

                                            $filteredValues = array_filter($all_values, function ($item) use ($selected_items) {
                                                return in_array($item['id'], $selected_items);
                                            });
                                        @endphp

                                        @if ($filteredValues)
                                            @foreach ($filteredValues as $index => $value)
                                                {{ $value['value'] }}
                                                @unless ($loop->last)
                                                    ,
                                                @endunless
                                            @endforeach
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-grow items-start gap-3">
                                <i class="{{ $field->customField->icon }} text-primary-500 fa-1x"></i>
                                <div>
                                    <p class="body-sm-400 test-gray-700 dark:text-gray-200 mb-1">
                                        {{ $field->customField->name }}
                                    </p>
                                    <p class="body-md-500 text-gray-900 dark:text-white">
                                        {{ $field->value }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endforeach

<div class="py-6 px-5">
    <h3 class="heading-07 mb-3 dark:text-white">{{ __('features') }}</h3>
    <ul class="lg:columns-3 sm:columns-2 columns-1">
        @foreach ($ad->adFeatures as $feature)
            <li class="feature-list dark:text-white">
                <x-frontend.icons.gray-check />
                {{ $feature->name }}
            </li>
        @endforeach
    </ul>
</div>
