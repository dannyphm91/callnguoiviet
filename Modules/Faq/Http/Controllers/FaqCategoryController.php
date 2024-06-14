<?php

namespace Modules\Faq\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Faq\Actions\SortingFaqCategory;
use Modules\Faq\Entities\FaqCategory;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        abort_if(! userCan('faq.view'), 403);
        try {

            $data['faqCategories'] = FaqCategory::oldest('order')->get();

            return view('faq::faqcategory.index', $data);
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
        abort_if(! userCan('faq.create'), 403);

        return view('faq::faqcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(Request $request)
    {
        abort_if(! userCan('faq.create'), 403);

        $request->validate([
            'name' => 'required|unique:faq_categories,name',
            'icon' => 'required',
        ]);
        try {

            FaqCategory::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'icon' => $request->icon,
            ]);

            flashSuccess('Faq Category Successfully Created');

            return back();
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
    public function edit(FaqCategory $faq_category)
    {
        abort_if(! userCan('faq.update'), 403);
        try {

            $data['faqCategories'] = FaqCategory::oldest('order')->get();
            $data['item'] = $faq_category;

            return view('faq::faqcategory.index', $data);
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
    public function update(Request $request, FaqCategory $faq_category)
    {
        abort_if(! userCan('faq.update'), 403);

        $request->validate([
            'name' => "required|unique:faq_categories,name,{$faq_category->id}",
        ]);
        try {

            $faq_category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'icon' => $request->icon,
            ]);

            flashSuccess('Faq Category Successfully Updated');

            return redirect()->route('module.faq.category.index');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Renderable
     */
    public function destroy(FaqCategory $faq_category)
    {
        abort_if(! userCan('faq.delete'), 403);
        try {

            $faq_category->delete();

            flashSuccess('Faq Category Successfully Deleted');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function updateOrder(Request $request)
    {
        abort_if(! userCan('faq.update'), 403);

        try {
            SortingFaqCategory::sort($request);

            return response()->json(['message' => 'Faq Category Sorted Successfully!']);
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }
}
