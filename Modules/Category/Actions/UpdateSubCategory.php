<?php

namespace Modules\Category\Actions;

use Modules\Language\Entities\Language;

class UpdateSubCategory
{
    public static function update($request, $subcategory)
    {
        // $subcategory->update($data);
        $locales = Language::pluck('code')->toArray();
        foreach ($locales as $locale) {
            $name = $request->input('name.'.$locale);
            if ($name == '') {
                $name = $request->input('name.en');
            }
            $subcategory->translateOrNew($locale)->name = $name;
        }
        $subcategory->slug = \Str::slug($request->input('name.en'));
        $subcategory->save();

        return $subcategory->save(); //$subcategory->update($request->all());
    }
}
