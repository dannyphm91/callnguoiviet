<?php

namespace Modules\Brand\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Http\Requests\BrandFormRequest;
use Modules\Brand\Repositories\BrandRepositories;

class BrandController extends Controller
{
    use ValidatesRequests;

    protected $brand;

    public function __construct(BrandRepositories $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Display a listing of the brands.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! userCan('brand.view')) {
            return abort(403);
        }
        try {
            $brands = $this->brand->all();

            return view('brand::index', compact('brands'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! userCan('brand.create')) {
            return abort(403);
        }
        try {
            return view('brand::create');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Store a newly created brand in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BrandFormRequest $request)
    {
        if (! userCan('brand.create')) {
            return abort(403);
        }
        try {
            $this->brand->store($request);

            flashSuccess('Brand Added Successfully');

            return back();
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    /**
     * Show the form for editing the specified brand.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        if (! userCan('brand.update')) {
            return abort(403);
        }
        try {
            $brands = $this->brand->all();

            return view('brand::index', compact('brands', 'brand'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update the specified brand in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(BrandFormRequest $request, Brand $brand)
    {
        if (! userCan('brand.update')) {
            return abort(403);
        }
        try {
            $this->brand->update($request, $brand);

            flashSuccess('Brand Updated Successfully');

            return redirect(route('module.brand.index'));
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    /**
     * Remove the specified brand from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        if (! userCan('brand.delete')) {
            return abort(403);
        }

        try {
            $this->brand->destroy($brand);

            flashSuccess('Brand Deleted Successfully');

            return redirect(route('module.brand.index'));
        } catch (\Throwable $th) {
            flashError();

            return back();
        }
    }

    public function show(Brand $brand)
    {
        try {
            $brand->loadCount('ads');
            $ads = $brand->ads;

            return view('brand::show', compact('brand', 'ads'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
