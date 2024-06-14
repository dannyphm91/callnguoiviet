<?php

namespace Modules\Blog\Http\Controllers;

use File;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\PostCategory;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index($category_slug = null)
    {
        try {
            if ($category_slug) {
                if (! userCan('postcategory.update')) {
                    return abort(403);
                }

                $cateogory = PostCategory::whereSlug($category_slug)->firstOrFail();
            }

            $categories = PostCategory::latest()->paginate(20);

            return view('blog::category.index', [
                'categories' => $categories,
                'edit_category' => $cateogory ?? null,
            ]);
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:post_categories,name|max:255',
            'image' => 'required|image|mimes:png,jpg, jpeg,gif,svg|max:2048',
        ]);

        try {
            if (! userCan('postcategory.create')) {
                return abort(403);
            }

            $category = PostCategory::create($request->except(['image']));

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $url = $request->image->move('uploads/post/category', $request->image->hashName());
                $category->update(['image' => $url]);
            }

            flashSuccess('Category Created Successfully');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function show($id)
    {
        try {
            return view('blog::show');
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
    public function update(Request $request, PostCategory $post_category)
    {
        if (! userCan('postcategory.update')) {
            return abort(403);
        }

        $request->validate([
            'name' => 'required|unique:post_categories,name,'.$post_category->id.'|max:255',
            'image' => 'nullable|image|mimes:png,jpg, jpeg,gif,svg|max:2048',
        ]);
        try {
            $post_category->update($request->except('image'));

            if ($request->hasFile('image')) {
                unlink(public_path($post_category->image));

                $url = $request->image->move('uploads/post/category', $request->image->hashName());
                $post_category->update(['image' => $url]);
            }

            flashSuccess('Category Updated Successfully');

            return redirect()->route('module.postcategory.index');
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
    public function destroy(PostCategory $post_category)
    {
        if (! userCan('postcategory.delete')) {
            return abort(403);
        }
        try {
            $post_category->delete();

            File::delete(public_path($post_category->image));

            flashSuccess('Category Deleted Successfully');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
