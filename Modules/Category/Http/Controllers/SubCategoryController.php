<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Actions\CreateSubCategory;
use Modules\Category\Actions\DeleteSubCategory;
use Modules\Category\Actions\UpdateSubCategory;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategory;
use Modules\Category\Http\Requests\SubCategoryFormRequest;
use Modules\Language\Entities\Language;

class SubCategoryController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        if (! userCan('subcategory.view')) {
            abort(403);
        }
        try {
            $sub_categories = SubCategory::withCount('ads')
                ->latest()
                ->paginate(10);

            return view('category::subcategory.index', compact('sub_categories'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        if (! userCan('subcategory.create')) {
            abort(403);
        }
        try {
            $categories = Category::all();
            $locales = Language::orderBy('created_at', 'asc')->get(); //->pluck('code')->toArray()
            if ($categories->count() < 1) {
                flashWarning("You don't have any active category. Please create or active category first.");

                return redirect()->route('module.category.create');
            }

            return view('category::subcategory.create', compact('categories', 'locales'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(SubCategoryFormRequest $request)
    {
        if (! userCan('subcategory.create')) {
            abort(403);
        }
        try {
            // $subcategory = CreateSubCategory::create($request);
            $subCategory = new SubCategory();
            $locales = Language::pluck('code')->toArray();
            foreach ($locales as $locale) {
                $name = $request->input('name.'.$locale);
                if ($name == '') {
                    $name = $request->input('name.en');
                }
                $subCategory->translateOrNew($locale)->name = $name;
            }
            $subCategory->category_id = $request->category_id;
            $subCategory->slug = \Str::slug($request->input('name.en'));
            $success = $subCategory->save();

            if ($success) {
                flashSuccess('SubCategory Added Successfully');

                return back();
            } else {
                flashError();

                return back();
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit(SubCategory $subcategory)
    {
        if (! userCan('subcategory.update')) {
            abort(403);
        }
        try {
            $locales = Language::orderBy('created_at', 'asc')->get();
            $categories = Category::all();

            return view('category::subcategory.edit', compact('subcategory', 'categories', 'locales'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function update(SubCategoryFormRequest $request, SubCategory $subcategory)
    {
        if (! userCan('subcategory.update')) {
            abort(403);
        }
        try {
            $subcategory = UpdateSubCategory::update($request, $subcategory);

            if ($subcategory) {
                flashSuccess('SubCategory Updated Successfully');

                return redirect(route('module.subcategory.index'));
            } else {
                flashError();

                return back();
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy(SubCategory $subcategory)
    {
        if (! userCan('subcategory.delete')) {
            abort(403);
        }
        try {
            $subcategory = DeleteSubCategory::delete($subcategory);

            if ($subcategory) {
                flashSuccess('SubCategory Deleted Successfully');

                return back();
            } else {
                flashError();

                return back();
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function show(SubCategory $subcategory)
    {
        try {
            $subcategory->loadCount('ads', 'category');
            $ads = $subcategory->ads;

            // return [
            //     'subcategory' => $subcategory,
            //     'ads' => $ads
            // ];

            return view('category::subcategory.show', compact('ads', 'subcategory'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function status_change(Request $request)
    {
        try {
            $product = SubCategory::findOrFail($request->id);
            $product->status = $request->status;
            $product->save();

            if ($request->status == 1) {
                return response()->json(['message' => 'Subcategory Activated Successfully']);
            } else {
                return response()->json(['message' => 'Subcategory Inactivated Successfully']);
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
