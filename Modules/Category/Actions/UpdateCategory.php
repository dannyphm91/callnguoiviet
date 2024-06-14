<?php

namespace Modules\Category\Actions;

use Modules\Language\Entities\Language;

class UpdateCategory
{
    public static function update($request, $category)
    {
        $data = $request->except('image');
        $category->update($data);
        $locales = Language::pluck('code')->toArray();
        foreach ($locales as $locale) {
            $name = $request->input('name.'.$locale);
            if ($name == '') {
                $name = $request->input('name.en');
            }
            $category->translateOrNew($locale)->name = $name;
        }
        $category->slug = \Str::slug($request->input('name.en'));
        $category->save();
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            deleteImage($category->image);
            $url = $request->image->move('uploads/category', $request->image->hashName());
            $category->update(['image' => $url]);
        }

        return $category;
    }
}
