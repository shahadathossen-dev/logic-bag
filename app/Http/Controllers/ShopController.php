<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\Product;
use App\Models\Product\Tag;
use Illuminate\Http\Request;
use App\Models\Product\Category;
use App\Models\Product\Subcategory;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{

    protected $perpage = 12;

    protected function getPaginate($perpage)
    {
        return $this->perpage = $perpage;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->perpage){
            $this->getPaginate($request->perpage);
        }

        $products = Product::published()->paginate($this->perpage);

        if(!$products || count($products) < 1){

            if ($request->ajax()) {
                abort(404);
            }

            Alert::warning('No product found', 'Oops..!')->persistent("Close this");
            return redirect()->route('shop');
        }

        if ($request->ajax()) {
            return view('pages.partials.store')->with(compact('products'));
        }

        return view('pages.shop')->with(compact('products'));
    }

    public function category_subcategories($category)
    {
        $title = ucwords(implode(' ', explode('-', $category)));
        $category = Category::where('title', $title)->first();
        $subcategories = Subcategory::where('category_id', $category->id)->get();
        return $subcategories;
    }

    public function category_products(Request $request, $category)
    {

        if($request->perpage){
            $this->getPaginate($request->perpage);
        }

        $title = ucwords(implode(' ', explode('-', $category)));
        $categoryModel = Category::where('title', $title)->firstOrFail();

        $products = Product::where('category_id', $categoryModel->id)->published()->paginate($this->perpage);

        if(!$products || count($products) < 1){

            if ($request->ajax()) {
                abort(404, 'No products found!');
            }

            Alert::warning('No product found', 'Oops..!')->persistent("Close this");
            return redirect()->route('shop');
        }

        if ($request->ajax()) {
            return view('pages.partials.store')->with(compact('products'));
        }

        return view('pages.shop')->with(compact('products'));

    }

    public function tag_search(Request $request, $tag)
    {

        if($request->perpage){
            $this->getPaginate($request->perpage);
        }

        $name = ucwords(implode(' ', explode('-', $tag)));
        $tagModel = Tag::where('name', $name)->firstOrFail();
        $products = $tagModel->products()->published()->paginate($this->perpage);

        if(!$products || count($products) < 1){

            if ($request->ajax()) {
                abort(404);
            }

            Alert::warning('No product found', 'Oops..!')->persistent("Close this");
            return redirect()->route('shop');
        }

        if ($request->ajax()) {
            return view('pages.partials.store')->with(compact('products'));
        }

        return view('pages.shop')->with(compact('products'));

    }

    public function category_subcategory_products(Request $request, $category, $subcategory)
    {
        if($request->perpage){
            $this->getPaginate($request->perpage);
        }

        $title = ucwords(implode(' ', explode('-', $category)));
        $subCatTitle = ucwords(implode(' ', explode('-', $subcategory)));
        $categoryModel = Category::where('title', $title)->firstOrFail();

        if ($subCatTitle == "All") {

             $products = Product::where('category_id', $categoryModel->id)->published()->paginate($this->perpage);

            return $this->sendResponse($request, $products);

        }

        $subcategoryModel = Subcategory::where('title', $subCatTitle)->where('category_id', $categoryModel->id)->firstOrFail();

        $products = Product::where('category_id', $categoryModel->id)->Where('subcategory_id', $subcategoryModel->id)->published()->paginate($this->perpage);

        return $this->sendResponse($request, $products);

    }

    public function sendResponse($request, $products){

        if(!$products || count($products) < 1){

            if ($request->ajax()) {
                abort(404, 'No product found!');
            }

            Alert::warning('No product found', 'Oops..!')->persistent("Close this");
            return redirect()->route('shop');
        }

        if ($request->ajax()) {
            return view('pages.partials.store')->with(compact('products'));
        }

        return view('pages.shop')->with(compact('products'));
    }

    public function price_search(Request $request)
    {
        
        return redirect()->route('shop.products.price.search.result', ['range' => $request->minimum.'-'.$request->maximum]);

    }

    public function get_price_search(Request $request)
    {
        if($request->perpage){
            $this->getPaginate($request->perpage);
        }

        $rangeArray = explode('-', $request->range);
        $minimum = $rangeArray[0];
        $maximum = $rangeArray[1];
        $products = Product::whereBetween('price', [$minimum, $maximum])->published()->paginate($this->perpage);
        return $this->sendResponse($request, $products);

    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            abort(404);
        }

        return redirect()->route('shop.products.search.result', ['keyword' => str_slug($request->keyword)]);

    }

    public function search_keyword (Request $request)
    {

        if($request->perpage){
            $this->getPaginate($request->perpage);
        }

        $products = $this->search_product($request)->paginate($this->perpage);

        return $this->sendSearchResponse($request, $products);

    }

    protected function search_product ($request)
    {

        $keyword = str_replace('-', ' ', $request->keyword);
        return $products = Product::where('title', 'like', '%'.$keyword.'%')
                            ->orWhere('model', 'like', '%'.$keyword.'%')
                            ->orWhere('description', 'like', '%'.$keyword.'%')
                            ->orWhereHas('attributes', function ($query) use ($keyword){
                                    $query->where('color', 'like', '%'.$keyword.'%')
                                    ->orWhere('sku', 'like', '%'.$keyword.'%');
                                })
                            ->orWhereHas('meta', function ($query) use ($keyword){
                                    $query->where('description', 'like', '%'.$keyword.'%')
                                })
                            ->orWhereHas('tags', function ($query) use ($keyword){
                                    $query->where('name', 'like', '%'.$keyword.'%');
                                })
                            ->published();
    }

    public function sendSearchResponse($request, $products){

        if (!$products) {
            abort(404);
        }

        if ($request->ajax()) {
            return view('pages.partials.store')->with(compact('products'));
        }

        return view('pages.shop')->with(compact('products'));
    }

    public function live_search (Request $request){

        return $this->search_product($request)->get()->map(function ($product) {
                return ['category' => $product->category->title, 'subcategory' => $product->subcategory->title, 'product' => $product, 'attribute' => $product->attributeFirst(), 'meta' => $product->meta];
            });
    }

    public function category_products_price_search(Request $request)
    {

        $title = ucwords(implode(' ', explode('-', $request->category)));
        $categoryModel = Category::where('title', $title)->first();

        if (!$categoryModel) {
            abort(404);
        }

        $products = Product::where('category_id', $categoryModel->id)
                            ->whereBetween('price', [$request->minimum, $request->maximum])
                            ->published()->paginate(12);

        if (!$products) {
            abort(404);
        }

        if ($request->ajax()) {
            return view('pages.partials.store')->with(compact('products'));
        }

        return view('pages.shop')->with(compact('products'));
    }

    public function subcategory_products_price_search(Request $request)
    {

        $title = ucwords(implode(' ', explode('-', $request->category)));
        $categoryModel = Category::where('title', $title)->first();

        if (!$categoryModel) {
            abort(404);
        }

        $subCatTitle = ucwords(implode(' ', explode('-', $request->subcategory)));
        $subcategoryModel = Subcategory::where('title', $subCatTitle)->where('category_id', $categoryModel->id)->first();

        if (!$subcategoryModel) {
            abort(404);
        }

        $products = Product::where('category_id', $categoryModel->id)
                            ->Where('subcategory_id', $subcategoryModel->id)
                            ->whereBetween('price', [$request->minimum, $request->maximum])
                            ->published()->paginate(12);

        if (!$products) {
            abort(404);
        }

        if ($request->ajax()) {
            return view('pages.partials.store')->with(compact('products'));
        }

        return view('pages.shop')->with(compact('products'));
    }

}
