<?php

namespace Modules\Brand\Repositories;

use Modules\Brand\Actions\CreateBrand;
use Modules\Brand\Actions\DeleteBrand;
use Modules\Brand\Actions\UpdateBrand;
use Modules\Brand\Entities\Brand;

class BrandRepositories implements BrandInterface
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return Brand::withCount('ads')->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(object $data)
    {
        return CreateBrand::create($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  object  $product
     * @return \Illuminate\Http\Response
     */
    public function update(object $request, object $data)
    {
        return UpdateBrand::update($request, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(object $data)
    {
        return DeleteBrand::delete($data);
    }
}
