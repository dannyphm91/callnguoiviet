<?php

namespace App\View\Components\Backend\Setting\Cms;

use Illuminate\View\Component;

class PricingPlan extends Component
{
    public $cms;

    public $pricePlanServices;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($cms, $pricePlanServices)
    {
        $this->cms = $cms;
        $this->pricePlanServices = $pricePlanServices;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.backend.setting.cms.pricing-plan');
    }
}
