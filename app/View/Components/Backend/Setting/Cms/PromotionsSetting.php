<?php

namespace App\View\Components\Backend\Setting\Cms;

use Illuminate\View\Component;

class PromotionsSetting extends Component
{
    public $promotionBannerTitle;

    public $promotionBannerText;

    public $promotionBannerImg;

    public $featuredTitle;

    public $featuredText;

    public $featuredImg;

    public $urgentTitle;

    public $urgentText;

    public $urgentImg;

    public $highlightTitle;

    public $highlightText;

    public $highlightImg;

    public $topTitle;

    public $topText;

    public $topImg;

    public $bumpUpTitle;

    public $bumpUpText;

    public $bumpUpImg;

    public $promotionContent;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $promotionBannerTitle, $promotionBannerText, $promotionBannerImg,
        $featuredTitle, $featuredText, $featuredImg,
        $urgentTitle, $urgentText, $urgentImg,
        $highlightTitle, $highlightText, $highlightImg,
        $topTitle, $topText, $topImg,
        $bumpUpTitle, $bumpUpText, $bumpUpImg,

        $promotionContent,
    ) {
        $this->promotionBannerTitle = $promotionBannerTitle;
        $this->promotionBannerText = $promotionBannerText;
        $this->promotionBannerImg = $promotionBannerImg;

        $this->featuredTitle = $featuredTitle;
        $this->featuredText = $featuredText;
        $this->featuredImg = $featuredImg;

        $this->urgentTitle = $urgentTitle;
        $this->urgentText = $urgentText;
        $this->urgentImg = $urgentImg;

        $this->highlightTitle = $highlightTitle;
        $this->highlightText = $highlightText;
        $this->highlightImg = $highlightImg;

        $this->topTitle = $topTitle;
        $this->topText = $topText;
        $this->topImg = $topImg;

        $this->bumpUpTitle = $bumpUpTitle;
        $this->bumpUpText = $bumpUpText;
        $this->bumpUpImg = $bumpUpImg;

        $this->promotionContent = $promotionContent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.backend.setting.cms.promotions-setting');
    }
}
