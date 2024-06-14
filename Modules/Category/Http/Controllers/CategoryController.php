<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Actions\SortingCategory;
use Modules\Category\Actions\UpdateCategory;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategory;
use Modules\Category\Http\Requests\CategoryFormRequest;
use Modules\Category\Repositories\CategoryRepositories;
use Modules\Language\Entities\Language;

class CategoryController extends Controller
{
    use ValidatesRequests;

    protected $category;

    public function __construct(CategoryRepositories $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! userCan('category.view')) {
            return abort(403);
        }
        try {
            $categories = Category::withCount('ads', 'customFields')
                ->oldest('order')
                ->paginate(10);

            return view('category::category.index', compact('categories'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! userCan('category.create')) {
            return abort(403);
        }
        try {
            $locales = Language::orderBy('created_at', 'asc')->get(); //->pluck('code')->toArray();

            return view('category::category.create', compact('locales'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Store a newly created category in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryFormRequest $request)
    {
        if (! userCan('category.create')) {
            return abort(403);
        }

        try {
            // $this->category->store($request);
            $category = new Category();
            $locales = Language::pluck('code')->toArray();
            foreach ($locales as $locale) {
                $name = $request->input('name.'.$locale);
                if ($name == '') {
                    $name = $request->input('name.en');
                }
                $category->translateOrNew($locale)->name = $name;
            }
            $category->slug = \Str::slug($request->input('name.en'));
            // $category->image = $request->file('image')->store('categories');
            $category->icon = $request->input('icon');
            $category->save();
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                deleteImage($category->image);
                $url = $request->image->move('uploads/category', $request->image->hashName());
                $category->update(['image' => $url]);
            }

            flashSuccess('Category Added Successfully');

            return back();
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (! userCan('category.update')) {
            return abort(403);
        }
        try {
            $locales = Language::orderBy('created_at', 'asc')->get();

            return view('category::category.edit', compact('category', 'locales'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryFormRequest $request, Category $category)
    {
        if (! userCan('category.update')) {
            return abort(403);
        }
        try {
            UpdateCategory::update($request, $category);
            flashSuccess('Category Updated Successfully');

            return redirect(route('module.category.index'));
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (! userCan('category.delete')) {
            return abort(403);
        }

        try {
            $this->category->destroy($category);
            flashSuccess('Category Deleted Successfully');

            return back();
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $request)
    {
        if (! userCan('category.update')) {
            return abort(403);
        }
        try {
            SortingCategory::sort($request);

            return response()->json(['message' => 'Category Sorted Successfully!']);
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    /**
     * Get subcateogry by category id
     *
     * @param  int  $category_id
     * @return \Illuminate\Http\Response
     */
    public function getSubcategories($category_id)
    {
        // return $category_id;
        // $subcategories = SubCategory::query()
        //     ->whereLike('category.name', $category_id)
        //     ->whereLike('category_id', $category_id)
        //     ->latest()
        //     ->get()
        //     ->map(
        //         fn ($item) => [
        //             'id' => $item->id,
        //             'name' => $item->name,
        //         ],
        //     );
        $subcategories = SubCategory::where('category_id', $category_id)
            ->latest()
            ->get()
            ->map(
                fn ($item) => [
                    'id' => $item->id,
                    'name' => $item->name,
                ],
            );

        return response()->json($subcategories);
    }

    public function show(Category $category)
    {
        try {
            $category->loadCount('ads', 'subcategories');
            $ads = $category->ads;
            $subcategories = $category->subcategories->loadCount('ads');

            return view('category::category.show', compact('category', 'ads', 'subcategories'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function status_change(Request $request)
    {
        try {
            $product = Category::findOrFail($request->id);
            $product->status = $request->status;
            $product->save();

            if ($request->status == 1) {
                return response()->json(['message' => 'Category Activated Successfully']);
            } else {
                return response()->json(['message' => 'Category Inactivated Successfully']);
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
