<?php

namespace App\Actions\Module;

use App\Models\ModuleSetting;
use Illuminate\Http\Request;

class UpdateModule
{
    public function handel(Request $request)
    {
        $blog = $request->blog ?? false;
        $newsletter = $request->newsletter ?? false;
        $language = $request->language ?? false;
        $price_plan = $request->price_plan ?? false;
        $testimonial = $request->testimonial ?? false;
        $faq = $request->faq ?? false;
        $contact = $request->contact ?? false;
        $appearance = $request->appearance ?? false;

        ModuleSetting::first()->update([
            'blog' => $blog,
            'newsletter' => $newsletter,
            'language' => $language,
            'price_plan' => $price_plan,
            'testimonial' => $testimonial,
            'faq' => $faq,
            'contact' => $contact,
            'appearance' => $appearance,
        ]);
    }
}
