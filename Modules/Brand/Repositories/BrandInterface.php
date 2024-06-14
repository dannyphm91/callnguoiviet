<?php

namespace Modules\Brand\Repositories;

interface BrandInterface
{
    public function all();

    public function store(object $data);

    public function update(object $request, object $data);

    public function destroy(object $data);
}
