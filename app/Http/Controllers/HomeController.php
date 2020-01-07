<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Product\Attribute;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function single_product($id)
    {
        $product = Product::findOrFail($id)->published();
        $product->update_views();

        $single_product = Product::where('id', $id)->get()
            ->map(function ($product) {
                return ['product' => $product, 'category' => $product->category->title, 'subcategory' => $product->subcategory->title, 'attributes' => $product->attributes, 'tags' => $product->tags, 'rating' => $product->ratingAverage(), 'reviews' => $product->reviews];
            });
        return $single_product[0];
    }

    public function single_attribute (Product $product, $sku)
    {
        $attribute = $product->attribute($sku);
        $attribute->model = $product->model;
            
        return response()->json($attribute);
    }

    public function view_product (Request $request, $category, $subcategory, $model)
    {
        $product = Product::whereModel($model)->published()->firstOrFail();

        $query = Attribute::where('product_id', $product->id);

        if (request()->has('color')) {
            $query->where('color', ucfirst(str_replace('-', ' ', request()->color)));
        }

        $attribute = $query->first();
        
        if (!$attribute) {
            abort(404);
        }

        $product->update_views();
        
        if ($request->ajax()) {
            return view('layouts.modules.quick-modal')->with(['product' => $product, 'attribute' => $attribute]);
        }
        
        return view('pages.product-details')->with(['product' => $product, 'attribute' => $attribute]);
    }

    public function recently_viewed (){
        return Product::all()->sortByDesc('viewed_at');
    }

    public function about_us ()
    {
        return view('pages.about-us');
    }

    public function contact_us ()
    {
        return view('pages.contact-us');
    }

}
