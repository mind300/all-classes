<?php

namespace App\Http\Controllers\Api\Brands;

use App\Http\Controllers\Controller;
use App\Http\Requests\Brands\BrandRequest;
use App\Models\Brand;
use App\Models\User;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::with(['media', 'suppliers'])->withCount('offers')->paginate(10);
        return contentResponse($brands);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $brand = Brand::create($request->validated());
        $supplier = (new User)->setConnection('suppliers')->create(array_merge($request->safe()->only('email'), ['brand_id' => $brand->id, 'password' => '12345@Test']));
        if ($request->hasFile('media')) {
            $brand->addMediaFromRequest('media')->toMediaCollection('brand');
        }
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return contentResponse($brand->load(['media', 'suppliers']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());
        $brand->supplier->update($request->safe()->only('email'));
        if ($request->hasFile('media')) {
            $brand->addMediaFromRequest('media')->toMediaCollection('brand');
        }
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->supplier->forceDelete();
        $brand->forceDelete();
        return messageResponse();
    }
}
