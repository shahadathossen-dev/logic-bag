<?php

namespace App\Http\Controllers\Product;

use Image;
use Alert;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Product\Attribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
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

    protected function validator(array $data, $id = NULL)
    {
        return Validator::make($data, [
            'product_id'=> 'required|integer',
            'sku'       => 'required|string|max:15|unique:attributes,sku,'.$id.',id',
            'color'     => 'required|string|unique:attributes,color,'.$id.',id,color,'.Input::get('product_id'),
            // 'color'     => ['required', 'string', Rule::unique('attributes')->where(function ($query) {
            //     return $query->where('product_id', $id);
            // })],
            // 'meta_color'     => ['required', 'string', Rule::unique('attributes')->where(function ($query) {
            //     return $query->where('product_id', $id);
            // })],
            'stock'     => 'required|integer',
            'images'    => 'required|array|max:10',
            'images.*'  => 'string|distinct',
            'meta_color'     => 'required|string|unique:attributes,meta_color,'.$id.',id,meta_color,'.Input::get('product_id'),
        ]);
    }

    public function validate_input(Request $request)
    {
        $this->validator($request->all())->validate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('backend.pages.products.attributes.add')->with(compact('product'));
    }

    public function store(Request $request)
    {
        // var_dump($request->images);
        $this->validator($request->all())->validate();
        $files = $request->images;
        $images = explode(",", $files[0]);
        $newProductAttribute = Attribute::create([
            'product_id' => $request->product_id,
            'sku' => $request->sku,
            'color' => $request->color,
            'meta_color' => $request->meta_color,
            'stock' => $request->stock,
            'images' => $images,
        ]);
        if ($newProductAttribute) {
            return ['status' => "New attribute '".$newProductAttribute->sku."' created successfully."];
        } else {
            return ['warning' => "Error! New attribute is not created."];
        }
    }

    public function show(Attribute $attribute)
    {
        return view('backend.pages.products.attributes.details')->with(compact('attribute'));
    }
  
    public function getProductImages($model, $sku)
    {
        $publicPath = public_path('storage/backend/products/'.$model.'/'.$sku.'/thumbnail');
        $urlPath = url('storage/backend/products/'.$model.'/'.$sku.'/thumbnail');
        if (is_dir($publicPath)) {
            $images = File::files($publicPath);
            $imagesObj = [];
            foreach ($images as $image) {
                $imagesObj[] = [
                    'size' => File::size($image),
                    'name' => File::basename($image),
                    'location' => $urlPath.'/'.File::basename($image),
                ];
            }
            return $imagesObj;
        } else {
            return ['warning' => 'Not found!'];
        }
    }
    
    public function edit(Request $request, Attribute $attribute)
    {
        if ($request->ajax()) {
            return view('backend.pages.partials.modals.edit-attribute')->with(compact('attribute'));
        }
        return view('backend.pages.products.attributes.edit')->with(compact('attribute'));
    }

    public function update(Request $request)
    {
        $this->validator($request->all(), $request->id)->validate();
        $attribute = Attribute::find($request->id);
        $files = $request->images;
        $images = explode(",", $files[0]);
        $updateProductAttribute = $attribute->update([
            'sku' => $request->sku,
            'color' => $request->color,
            'stock' => $request->stock,
            'images' => $images,
            'meta_color' => $request->meta_color,
        ]);


        if ($updateProductAttribute) {
            
            if ($request->ajax()) {
                return ['status' => 'Attribute is updated successfully!'];
            }

            Alert::success('Attribute updated successfully.', 'Success')->persistent("Close this");
            return back();

        } else {

            if ($request->ajax()) {
                return ['warning' => 'Failed! Attribute is not updated successfully.'];
            }

            Alert::warning('Something went wrong!', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function destroy(Attribute $attribute)
    {
        $delete_attribute = $attribute->delete();
        if ($delete_attribute) {
            return ['status' => 'Attribute has been removed successfully.'];
        } else {
            Alert::success('Something went wrong!', 'Oops..!')->persistent("Close this");
            return back();
        }
    }
}
