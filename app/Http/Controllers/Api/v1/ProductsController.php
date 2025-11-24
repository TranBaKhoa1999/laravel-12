<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slug_category = null)
    {
        $request = request();
        $request->validate([
            'limit' => 'integer|min:1|max:100|nullable',
            'page' => 'integer|min:1|nullable',
        ]);

        $limit = $request->input('limit', 15);

        if($slug_category){
            $category = Category::where('slug', $slug_category)->firstOrFail();
            $products = Product::where('category_id', $category->id)->paginate($limit);
        } else{
            $products = Product::paginate($limit);
        }

        // Lấy sản phẩm với phân trang

        // return ProductResource::collection($products);
        // return printJson(ProductResource::collection($products), buildStatusObject('HTTP_OK'), $this->lang);
        return printJson(new ProductCollection($products), buildStatusObject('HTTP_OK'), $this->lang);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($slug_category, $slug_product)
    {
        $category = Category::where('slug', $slug_category)->firstOrFail();
        $product = Product::where('slug', $slug_product)->where('category_id', $category->id)->firstOrFail();
        return printJson(new ProductResource($product), buildStatusObject('HTTP_OK'), $this->lang);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
