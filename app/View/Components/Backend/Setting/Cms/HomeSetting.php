<?php

namespace App\View\Components\Backend\Setting\Cms;

use Illuminate\View\Component;

class HomeSetting extends Component
{
    public $sliders;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sliders)
    {
        $this->sliders = $sliders;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.backend.setting.cms.home-setting');
    }
}
