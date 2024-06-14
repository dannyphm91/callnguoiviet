<?php

namespace App\View\Components\Backend\Setting\Cms;

use Illuminate\View\Component;

class RefundPolicySetting extends Component
{
    public $refund;

    public $refundBackground;

    public $refundContent;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($refund, $refundBackground, $refundContent)
    {
        $this->refund = $refund;
        $this->refundBackground = $refundBackground;
        $this->refundContent = $refundContent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.backend.setting.cms.refund-policy-setting');
    }
}
