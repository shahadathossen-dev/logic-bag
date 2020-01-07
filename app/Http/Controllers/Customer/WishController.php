<?php

namespace App\Http\Controllers\Customer;

use Alert;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Product\Attribute;
use App\Models\Frontend\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Frontend\Customer\Wish;

class WishController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $wishes = Auth::guard()->user()->wishes()->paginate(1);

        if(!$wishes || count($wishes) < 1){
        
            if ($request->ajax()) {
                abort(404);
            }

            Alert::warning('No item found in your wish list!', 'Oops..!')->persistent("Close this");
            return redirect()->route('welcome');
        }
        
        if ($request->ajax()) {
            return view('pages.partials.wish-table')->with(compact('wishes'));
        }

        return view('pages.user.wishes.index')->with(compact('wishes'));
    }

    public function addToWish(Request $request, Product $product, Attribute $attribute)
    {	
        $customer = Customer::findOrFail(Auth::guard()->user()->id);

    	if ($customer->hasWish($product->model, $attribute->sku)) {

            $data = [
                'warning',
                'Item already exists in your wish list.',
                NULL
            ];
                
            return $this->sendResponse($request, $this->prepareResponseData($data));
    	}

    	$newWish = Wish::create([
    		'customer_id' => $customer->id,
    		'model' => $product->model,
    		'attribute' => $attribute->sku,
    	]);

    	if ($newWish) {

            $data = [
                'success',
                'Item is added to your wish list.',
                NULL
            ];
                
            return $this->sendResponse($request, $this->prepareResponseData($data));

    	} else {

            $data = [
                'warning',
                'Something went wrong!',
                NULL
            ];
                
            return $this->sendResponse($request, $this->prepareResponseData($data));
		}
    }

    public function destroy(Request $request, Product $product, Attribute $attribute)
    {
        $customer = Customer::findOrFail(Auth::guard()->user()->id);

        if (!$customer->hasWish($product->model, $attribute->sku)) {
            $data = [
                'warning',
                'Item does not exists in your wish list!',
                NULL
            ];
                
            return $this->sendResponse($request, $this->prepareResponseData($data));
        }

        $deleteWish = $customer->wish($product->model, $attribute->sku)->delete();

        if ($deleteWish) {
            $data = [
                'success',
                'Item removed from your wish list!',
                $customer->wishes
            ];
                
            return $this->sendResponse($request, $this->prepareResponseData($data));
        }
    }

    protected function prepareResponseData($data = array()){
        $this->data['responseType'] = $data[0];
        $this->data['responseText'] = $data[1];
        $this->data['responseData'] = $data[2];

        if ($data[0] == 'success') {
            $this->data['responseTitle'] = ucfirst($data[0]);
        } else if ($data[0] == 'warning') {
            $this->data['responseTitle'] = 'Oops..';
        }
        
        return $this->data;
    }

    protected function sendResponse($request, $data){

        if (request()->expectsJson()) {
            return [$data['responseType'] => $data['responseText'], 'wishes' => $this->data['responseData']];
        }

        Alert::{$data['responseType']}($data['responseText'], $data['responseTitle'])->persistent("Close");
        return back();
    }
}
