<?php

namespace App\Http\Controllers;

use Image;
use Alert;
use App\Models\Product;
use App\Models\Product\Tag;
use Illuminate\Http\Request;
use App\Models\Product\Meta;
use App\Models\Product\Discount;
use App\Models\Product\Property;
use App\Models\Product\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Events\Backend\NewProductCreated;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('backend.pages.products.index', ['products' => $products]);
    }

    public function create()
    {
        return view('backend.pages.products.add');
    }

    protected function validator(array $data, $id = NULL)
    {
        return Validator::make($data, [
            'title'     => 'required|string|unique:products,title,'.$id.',id',
            'model'     => 'required|string|max:255|unique:products,model,'.$id.',id',
            'category_id'=> 'required|integer',
            'subcategory_id'=> 'required|integer',
            'tags'      => 'required|array|max:10',
            'tags.*'    => 'integer|distinct',
            'price'     => 'required|numeric',
            'material' => 'required|string|max:30',
            'dimension' => 'required|string|max:30',
            'weight'    => 'required|numeric',
            'chamber'   => 'required|integer',
            'pockets'   => 'required|integer',
            'description' => ['required', 'string', function ($attribute, $value, $fail) {
                                $words = explode(' ', $value);
                                $nbWords = count($words);
                                if($nbWords < 200){
                                    $fail('The '.$attribute.' must be at least 200 words.');
                                }
                            }], 

            // Meta validation
            'meta_description' => ['required', 'string', function ($attribute, $value, $fail) {
                                    $words = explode(' ', $value);
                                    $nbWords = count($words);
                                    if($nbWords > 100){
                                        $fail('The '.$attribute.' must be within 80 words.');
                                    }
                                }], 

            // Attribute validation
            'sku'       => 'required|string|unique:attributes,sku,'.$id.',id',
            'color'     => 'required|string',
            'meta_color'     => 'required|string',
            'stock'     => 'required|integer',
            'images'    => 'required|array|max:10',
            'images.*'  => 'string|distinct',
        ]);
    }

    protected function product_validator(array $data, $id = NULL)
    {
        return Validator::make($data, [
            'title'     => 'required|string|unique:products,title,'.$id.',id',
            'model'     => 'required|string|max:255|unique:products,model,'.$id.',id',
            'category_id'=> 'required|integer',
            'subcategory_id'=> 'required|integer',
            'price'     => 'required|numeric',
            'material' => 'required|string|max:30',
            'dimension' => 'required|string|max:30',
            'weight'    => 'required|numeric',
            'chamber'   => 'required|integer',
            'pockets'   => 'required|integer',
            'tags'      => 'required|array|max:10',
            'tags.*'    => 'integer|distinct',
            'description' => 'required|string|min:255', 
        ]);
    }
    
    public function validate_input(Request $request)
    {
        $this->validator($request->all(), $request->id)->validate();
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        
        $newProduct = Product::create([
            'title' => $request->title,
            'model' => $request->model,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'price' => $request->price,
            'material' => $request->material,
            'dimension' => $request->dimension,
            'weight' => $request->weight,
            'chamber' => $request->chamber,
            'pockets' => $request->pockets,
            'description' => $request->description,
        ]);

        $newProduct->tags()->sync($request->tags);
        $newProductReport = $newProduct->report()->create();
        $newProductMeta = $this->create_meta($request, $newProduct);
        $newProductAttribute = $this->create_attribute($request, $newProduct);

        if (!($newProduct && $newProductMeta && $newProductAttribute)) {

            if ($request->expectsJson()) {
                return ['warning' => 'Failed! New product is not created.'];
            }

            return back()->with('warning', 'Failed! New product is not created.');
        }

        event(new NewProductCreated($newProduct));

        if ($request->expectsJson()) {
            return ['status' => 'New product created successfully!'];
        }
        
        return back()->with('status', 'New product created successfully!');
    }

    public function preview($category, $subcategory, Product $product, $slug)
    {

        $attribute = $product->attributeFirst();
        if (!$product->reviewed) {
            $product = $product->meta()->update([
                'reviewed' => 1
            ]);
        }

        return view('pages.product-details')->with(['product' => $product, 'attribute' => $attribute]);
    }


    public function publish ($id)
    {
        $product = Product::findOrFail($id);
        $productPublished = $product->meta()->update([
            'published' => 1,
            'reviewed' => 1
        ]);
        
        if ($productPublished) {
            Alert::success('Product has been published successfully.', 'Success')->persistent("Close this");
            return back();
        }
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        if (!$product->meta->reviewed) {
            $product = $product->meta()->update([
                'reviewed' => 1
            ]);
        }
        return view('backend.pages.products.show')->with(compact('product'));
    }

    public function validate_edit_input(Request $request, $id)
    {
        $this->validator($request->all(), $id)->validate();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('backend.pages.products.edit')->with(compact('product'));
    }

    public function update(Request $request)
    {
        $this->product_validator($request->all(), $request->id)->validate();
        $user = Auth::guard('admin')->user();
        $product = Product::findOrFail($request->id);
        $updateProduct = $product->update([
            'title' => $request->title,
            'model' => $request->model,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'price' => $request->price,
            'material' => $request->material,
            'dimension' => $request->dimension,
            'weight' => $request->weight,
            'chamber' => $request->chamber,
            'pockets' => $request->pockets,
            'description' => $request->description,            
        ]);

        $product->tags()->sync($request->tags);

        $updateMeta = $product->meta->update([
            'title' => $request->title,
            'updated_by' => $user->username,
        ]);

        if ($updateProduct) {
            return ['status' => 'Product "'.$product->model.'" updated successfully.'];
        } else {
            return ['warning' => 'Something went wrong!', 'Oops..!'];
        }
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        if ($product) {
            $delete_product = $product->delete();
            if ($delete_product) {
                return ['status' => 'Product has been removed successfully.'];
            } else {
                return ['warning' => 'Product has not been removed successfully.'];
            }
        }
    }

    public function destroy($id)
    {
        $product = Product::onlyTrashed()->get();
        if ($product) {
            $delete_product = $product->history()->forceDelete();
            if ($delete_product) {
                return back()->with('status', 'Product has been destroyed permanently.');
            } else {
                return back()->with('warning', 'Product has not been destroyed permanently.');
            }
        }
    }
    
    public function archive()
    {
        $trashed_products = Product::onlyTrashed()->get();
        return view('backend.pages.products.archive', ['trashed_products' => $trashed_products]);
    }

    public function restore($id)
    {
        $trashed_item = Product::onlyTrashed()->findOrFail($id);
        $trashed_item->restore();
        return back()->with('status', "Product has been resotred successfully.");
    }
    
    protected function create_meta(Request $request, Product $product)
    {
        return $newProductMeta = $product->meta()->create([
            'model' => $product->model,
            'slug' => str_slug($product->title),
            'title' => $product->title,
            'description' => $request->meta_description,
            'created_by' => Auth::guard('admin')->user()->username,
        ]);
    }

    protected function create_attribute(Request $request, Product $product)
    {        
        $files = $request->images;
        $images = explode(",", $files[0]);
        return $newProductAttribute = $product->attributes()->create([
            'product_id' => $product->id,
            'sku' => $request->sku,
            'color' => $request->color,
            'stock' => $request->stock,
            'images' => $images,
            'meta_color' => $request->meta_color,
        ]);

    }

    public function viewProductRreivew($productId, $reviewId)
    {
        $product = Product::where('id', $productId)->first();

        return view('pages.product-details')->with(compact('product'));
    }
    
    public function update_product_feature(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $updateProductFeature = $product->update([
            'feature_id' => $request->feature_id,
        ]);

        if ($updateProductFeature) {
            Alert::success('Product feature updated successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::success('Something went wrong!', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function upload_file(Request $request)
    {
        if ($request->model == '' || $request->sku == '') {
            return ['warning' => 'File not uploaded successfully!'];
        }

        if ($request->hasFile('files')) {
            $publicPath = public_path('storage/backend/products/'.$request->model.'/'.$request->sku);
            $images = [];
            $originalPath = ($publicPath.'/original');
            $mediumPath = ($publicPath.'/medium');
            $thumbnailPath = ($publicPath.'/thumbnail');
            $paths = [$originalPath, $mediumPath, $thumbnailPath];

            foreach ($request->file('files') as $image) {
                $fileName = $image->getClientOriginalName();
                $images[] = $fileName;
                $loop = 0;

                foreach ($paths as $path) {
                    
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    if ($loop == 0) {
                        $uploadImage = Image::make($image)->save($path.'/'.$fileName);
                    } elseif ($loop == 1) {
                        $uploadImage = Image::make($image)->resize(400, 400, function($constraint) {
                            $constraint->aspectRatio();
                        })->save($path.'/'.$fileName);
                    } elseif ($loop == 2) {
                        $uploadImage = Image::make($image)->resize(120, 120, function($constraint) {
                            $constraint->aspectRatio();
                        })->save($path.'/'.$fileName);
                    }
                    $loop++;
                }
            }
            return $images;
        }
    }

    public function remove_file(Request $request)
    {
        $model = $request->model;
        $sku = $request->sku;
        $name = $request->name;
        $publicPath = public_path('storage/backend/products/'.$model.'/'.$sku);
        $thumbnails = [$publicPath.'/original/'.$name, $publicPath.'/medium/'.$name, $publicPath.'/thumbnail/'.$name];
        foreach ($thumbnails as $thumbnail) {
            if (file_exists($thumbnail)) {
                unlink($thumbnail);
            }
        }
        return "success";
    }

    public function remove_files(Request $request)
    {
        $model = $request->model;
        $sku = $request->sku;
        $publicPath = public_path('storage/backend/products/'.$model.'/'.$sku);
        if (is_dir($publicPath)) {
            $images_deleted = $this->delete_folder($publicPath);
            if ($images_deleted) {
                return "success";
            } else {
                return "error";
            }
        }
    }

    public function delete_folder($dirname)
    {
        if (is_dir($dirname)){
            $dir_handle = opendir($dirname);
        }

        if (!$dir_handle){
            return false;
        }

        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file)){
                    unlink($dirname."/".$file);
                }
                else {
                    $this->delete_folder($dirname.'/'.$file);
                }
            }
        }

        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }
    

}
