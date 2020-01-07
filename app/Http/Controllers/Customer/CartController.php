<?php

namespace App\Http\Controllers\Customer;

use Alert;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Product\Attribute;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    protected $data = array();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $session_id = session()->getId();
        // $sessionData = $request->session()->all();
        $cart = Session::get('cart');

        if(!$cart || count($cart) < 1){

            if ($request->ajax()) {
                abort(404);
            }

            Alert::warning('No item found in your cart', 'Oops..!')->persistent("Close this");
            return redirect()->route('welcome');
        }
        
        return view('pages.cart')->with(compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function add(Request $request, Product $product, $sku)
    {
        $attribute = $product->attribute($sku);

        if (!$attribute) {
            abort(404);
        }
 
        if ($product->isAvailable($sku, 1)) {

            $cart = session()->get('cart');
            $quantity = 1;

            if($cart && isset($cart[$product->model][$sku])) {
                
                $data = [
                    'warning',
                    'Item already exists in your cart!',
                    NULL
                ];

                return $this->sendResponse($request, $this->prepareResponseData($data));

            }

            if ($newItem = $this->save($cart, $product, $attribute, $quantity)) {
                $data = [
                    'success',
                    'Item is added to your cart successfully!',
                    $newItem
                ];
                
                return $this->sendResponse($request, $this->prepareResponseData($data));
            }

        } else {

            $data = [
                    'warning',
                    'Quantity required is not in stock right now. Please, check in again later!',
                    NULL
                ];

            return $this->sendResponse($request, $this->prepareResponseData($data));
        }
 
    }

    public function store(Request $request)
    {
        $model = $request->model;
        $sku = $request->sku;
        $quantity = $request->quantity;

        $product = Product::where('model', $model)->firstOrFail();
        $attribute = $product->attribute($sku);

        if (!$attribute) {
            abort(404);
        }
 
        if ($product->isAvailable($sku, $quantity)) {
            
            $cart = session()->get('cart');

            if($cart && isset($cart[$model][$sku])) {
                $data = [
                    'warning',
                    'Item already exists in your cart!',
                    NULL
                ];
                
                return $this->sendResponse($request, $this->prepareResponseData($data));

            }
            
            if ($newItem = $this->save($cart, $product, $attribute, $quantity)) {
                $data = [
                    'success',
                    'Item is added to your cart successfully!',
                    $newItem
                ];
                return $this->sendResponse($request, $this->prepareResponseData($data));
            }
            
        } else {
            
             $data = [
                'warning',
                'Product is out of stock right now. Please, check out later.',
                NULL
            ];
                
            return $this->sendResponse($request, $this->prepareResponseData($data));

        }
    }
    
    public function update(Request $request)
    {
        $id = explode('.', $request->id);
        $model = $id[0];
        $oldSku = $id[1];
        $newSku = $request->sku;
        $quantity = $request->quantity;
        $product = Product::where('model', $model)->firstOrFail();
        $attribute = $product->attribute($newSku);

        if (!$attribute) {
            abort(404);
        }

        $cart = session()->get('cart');

        if(!isset($cart[$model][$oldSku])) {
            abort(404);
        }

        if ($product->isAvailable($newSku, $quantity)) {
            
            $product->sku = $newSku;
            $product->quantity = $quantity;

            $cart[$model][$newSku] = $product;

            if ($oldSku !== $newSku) {
                unset($cart[$model][$oldSku]);
                session()->put('cart', $cart);
            }

            if ($newItem = $this->save($cart, $product, $attribute, $quantity)) {
                $data = [
                    'success',
                    'Cart updated successfully!', 
                    $newItem
                ];
                return $this->sendResponse($request, $this->prepareResponseData($data));
            }
        }
    }

    public function destroy(Request $request, $model, $sku)
    {
        // if requested item is not in cart
        if (!$request->session()->exists('cart.'.$model.'.'.$sku)){
            abort(404);
        }

        $cart = session()->get('cart');
        unset($cart[$model][$sku]);
        session()->put('cart', $cart);

        if (empty($cart[$model])) {
            unset($cart[$model]);
            session()->put('cart', $cart);
        }

        if (empty($cart)) {

            Session::forget('cart');

            $data = [
                'warning',
                'No item is left in your cart!', 
                Null
            ];
            
            return $this->sendResponse($request, $this->prepareResponseData($data));

        }

        $data = [
            'success',
            'Item is removed from your cart!',
            $cart
        ];
       
        return $this->sendResponse($request, $this->prepareResponseData($data));

    }

    protected function save ($cart, $product, $attribute, $quantity)
    {

        $attributes = $product->attributes->each(function ($attribute){
                    return ['color' => $attribute->color, 'sku' => $attribute->sku];
                });

        $itemAttribute = ['color' => $attribute->color, 'sku' => $attribute->sku, 'images' => $attribute->images];

        $item = (object) [

            'model' => $product->model,
            'title' => $product->title,
            'price' => $product->absolutePrice(),
            'quantity' => $quantity,
            'attributes' => $attributes,
            'meta' => $product->meta,
            'attribute' => $itemAttribute,
        ];
        
        $cart[$product->model][$attribute->sku] = $item;
        session()->put('cart', $cart);
        return $item;
    }
    
    protected function prepareResponseData($data = array()){
        $this->data['responseType'] = $data[0];
        $this->data['responseText'] = $data[1];
        $this->data['responseData'] = $data[2];

        if ($data[0] == 'success') {
            $this->data['responseTitle'] = ucfirst($data[0]);
        } elseif ($data[0] == 'warning') {
            $this->data['responseTitle'] = 'Oops..';
        }
        
        return $this->data;
    }

    protected function sendResponse($request, $data){

        if (request()->expectsJson()) {
            return [$data['responseType'] => $data['responseText'], 'data' => $data['responseData']];
        }

        Alert::{$data['responseType']}($data['responseText'], $data['responseTitle'])->persistent("Great!");
        return back();
    }
}
