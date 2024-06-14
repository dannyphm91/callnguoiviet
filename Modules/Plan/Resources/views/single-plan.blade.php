<div class="col-md-6 col-lg-4 col-xl-4 mb-3 col-12">
    <div class="card h-100">
        <div class="card-header text-center py-4">
            <h4>{{ $plan->label }}</h4>
            @if ($plan->recommended)
                <div class="badge badge-info">{{ __('recommended') }}</div>
            @endif
            <div class="badge badge-secondary">
                @if ($plan->plan_payment_type == 'one_time')
                    {{ __('one_time') }}
                @else
                    {{ __('recurring') }}
                @endif
            </div>
            <div class="d-flex justify-content-center align-items-center text-center">
                <h1 class="text-dark">
                    {{ changeCurrency($plan->price) }}
                </h1>
                <div>
                    @if ($plan->plan_payment_type == 'recurring')
                        @if ($plan->interval == 'custom_date')
                            <small>/{{ $plan->custom_interval_days }}
                                {{ __('days') }}</small>
                        @else
                            <small>/{{ $plan->interval }}</small>
                        @endif
                    @endif
                </div>
            </div>
            @if ($plan->stripe_id)
                <small>{{ __('stripe_price_id') }}: {{ $plan->stripe_id }}</small>
            @endif
        </div>
        <div class="card-body">
            <div class="mb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex">
                    @if ($plan->ad_limit === 0)
                        <span class="icon mr-2 bg-danger">
                            <x-svg.cross-icon width="22" height="22" />
                        </span>
                        <h5 class="mb-0">
                            {{ __('listing_post') }} : {{ __('not_included')}}
                        </h5>
                    @else
                        <span class="icon mr-2">
                            <x-svg.check-icon width="22" height="22" />
                        </span>
                        <h5 class="mb-0">
                            {{ __('listing_post_limit') }} : {{ $plan->ad_limit }}
                        </h5>
                    @endif
                </div>
            </div>

            <div class="mb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex">
                    @if ($plan->featured_limit === 0)
                        <span class="icon mr-2 bg-danger">
                            <x-svg.cross-icon width="22" height="22" />
                        </span>
                        <h5 class="mb-0">
                            {{ __('featured_listing') }} : {{ __('not_included')}}
                        </h5>
                    @else
                        <span class="icon mr-2">
                            <x-svg.check-icon width="22" height="22" />
                        </span>
                        <h5 class="mb-0">
                            {{ __('featured_listing_limit') }} : {{ $plan->featured_limit }} {{ __('for') }} {{ $plan->featured_duration < 1 ?__('lifetime') : $plan->featured_duration }}
                            @if ($plan->featured_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif
                        </h5>
                    @endif
                </div>
            </div>

            <div class="mb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex">
                    @if ($plan->urgent_limit === 0)
                        <span class="icon mr-2 bg-danger">
                            <x-svg.cross-icon width="22" height="22" />
                        </span>
                        <h5 class="mb-0">
                            {{ __('urgent_listing') }} : {{ __('not_included')}}
                        </h5>
                    @else
                        <span class="icon mr-2">
                            <x-svg.check-icon width="22" height="22" />
                        </span>
                        <h5 class="mb-0">
                            {{ __('urgent_listing_limit') }} : {{ $plan->urgent_limit }} {{ __('for') }} {{ $plan->urgent_duration < 1 ?__('lifetime') : $plan->urgent_duration }}

                            @if ($plan->urgent_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif
                        </h5>
                    @endif
                </div>
            </div>

            <div class="mb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex">
                    @if ($plan->highlight_limit === 0)
                        <span class="icon mr-2 bg-danger">
                            <x-svg.cross-icon width="22" height="22" />
                        </span>
                        <h5 class="mb-0">
                            {{ __('highlight_listing') }} : {{ __('not_included')}}
                        </h5>
                    @else
                        <span class="icon mr-2">
                            <x-svg.check-icon width="22" height="22" />
                        </span>
                        <h5 class="mb-0">
                            {{ __('highlight_listing_limit') }} : {{ $plan->highlight_limit }} {{ __('for') }} {{ $plan->highlight_duration < 1 ?__('lifetime') : $plan->highlight_duration }}
                            @if ($plan->highlight_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif
                        </h5>
                    @endif
                </div>
            </div>

            <div class="mb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex">
                    @if ($plan->top_limit === 0)
                        <span class="icon mr-2 bg-danger">
                            <x-svg.cross-icon width="22" height="22" />
                        </span>
                        <h5 class="mb-0">
                            {{ __('top_listing') }} : {{ __('not_included')}}
                        </h5>
                    @else
                        <span class="icon mr-2">
                            <x-svg.check-icon width="22" height="22" />
                        </span>
                        <h5 class="mb-0">
                            {{ __('top_listing_limit') }} : {{ $plan->top_limit }} {{ __('for') }} {{ $plan->top_duration < 1 ?__('lifetime') : $plan->top_duration }}
                            @if ($plan->top_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif
                        </h5>
                    @endif
                </div>
            </div>

            <div class="mb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex">
                    @if ($plan->bump_up_limit === 0)
                        <span class="icon mr-2 bg-danger">
                            <x-svg.cross-icon width="22" height="22" />
                        </span>
                        <h5 class="mb-0">
                            {{ __('bump_up_listing') }} : {{ __('not_included')}}
                        </h5>
                    @else
                        <span class="icon mr-2">
                            <x-svg.check-icon width="22" height="22" />
                        </span>
                        <h5 class="mb-0">
                            {{ __('bump_up_listing_limit') }} : {{ $plan->bump_up_limit }} {{ __('for') }} {{ $plan->bump_up_duration < 1 ?__('lifetime') : $plan->bump_up_duration }}
                            @if ($plan->bump_up_duration == 1)
                                {{ __('day') }}
                            @else
                                {{ __('days') }}
                            @endif
                        </h5>
                    @endif
                </div>
            </div>

            <div class="mb-2 align-items-center d-flex {{ $plan->frontend_show ? 'active' : '' }}">

                @if (!$plan->badge)
                    <span class="icon mr-2 bg-danger">
                        <x-svg.cross-icon width="22" height="22" />
                    </span>
                    <h5 class="mb-0">
                        {{ __('membership_badge') }} : {{ __('not_included')}}
                    </h5>
                @else
                    <span class="icon mr-2">
                        <x-svg.check-icon width="22" height="22" />
                    </span>
                    <h5 class="mb-0">
                        {{ __('membership_badge') }}
                    </h5>
                @endif
            </div>

            <div class="mb-2 align-items-center d-flex {{ $plan->frontend_show ? 'active' : '' }}">

                @if (!$plan->premium_member)
                    <span class="icon mr-2 bg-danger">
                        <x-svg.cross-icon width="22" height="22" />
                    </span>
                    <h5 class="mb-0">
                        {{ __('premium_membership') }} : {{ __('not_included')}}
                    </h5>
                @else
                    <span class="icon mr-2">
                        <x-svg.check-icon width="22" height="22" />
                    </span>
                    <h5 class="mb-0">
                        {{ __('premium_membership') }}
                    </h5>
                @endif
            </div>
        </div>
        <div class="card-footer">
            <div class=" d-flex justify-content-between">
                @if (userCan('plan.update') || userCan('plan.delete'))
                    @if (userCan('plan.update'))
                        <a href="{{ route('module.plan.edit', $plan->id) }}"
                            class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                            {{ __('edit') }}
                        </a>
                    @endif
                    @if ($plan->id !== $setting->default_plan)
                        @if (userCan('plan.delete'))
                            <form action="{{ route('module.plan.delete', $plan->id) }}"
                                class="" method="POST"
                                onclick="return confirm('{{ __('Are you certain you want to delete this item? Deleting the plan will also remove the associated order.') }}')">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger w-100-p">
                                    <i class="fas fa-trash"></i>
                                    {{ __('delete') }}
                                </button>
                            </form>
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
