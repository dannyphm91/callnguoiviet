<?php

namespace App\View\Components\AdDetails;

use Illuminate\View\Component;

class AdDescription extends Component
{
    public $description;

    public $features;

    public $videourl;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($description, $features, $videourl)
    {
        $this->description = $description;
        $this->features = $features;
        $this->videourl = $videourl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ad-details.ad-description');
    }
}
