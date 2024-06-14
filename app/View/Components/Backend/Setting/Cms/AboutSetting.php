<?php

namespace App\View\Components\Backend\Setting\Cms;

use Illuminate\View\Component;

class AboutSetting extends Component
{
    public $aboutcontent;

    public $aboutVideoUrl;

    public $aboutVideoThumb;

    // public $aboutBackground;
    public $aboutSliders;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    // public function __construct($aboutcontent, $aboutVideoUrl, $aboutVideoThumb, $aboutBackground, $aboutSliders)
    public function __construct($aboutcontent, $aboutVideoUrl, $aboutVideoThumb, $aboutSliders)
    {
        $this->aboutcontent = $aboutcontent;
        $this->aboutVideoUrl = $aboutVideoUrl;
        $this->aboutVideoThumb = $aboutVideoThumb;
        // $this->aboutBackground = $aboutBackground;
        $this->aboutSliders = $aboutSliders;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.backend.setting.cms.about-setting');
    }
}
