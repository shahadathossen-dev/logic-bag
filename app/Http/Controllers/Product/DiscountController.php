<?php

namespace App\Http\Controllers\Product;

use Alert;
use Illuminate\Http\Request;
use App\Models\Product\Discount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'model'=> 'required|integer',
            'discount'     => 'required|numeric|max:4',
        ]);
    }

    public function index ()
    {
        $discounts = Discount::all();
    	return view('backend.pages.products.discounts.index')->with(compact('discounts'));
    }

    public function create ()
    {
    	return view('backend.pages.products.discounts.add-discount');
    }

    public function store (Request $request)
    {
        $this->validator($request->all())->validate();
        $newDiscount = Discount::create([
            'model' => $request->model,
        	'discount' => $request->discount,
        ]);

        if ($newDiscount) {
            Alert::success('Discount created successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::success('Something went wrong!', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function show ($id)
    {
        $discount = Discount::findOrFail($id);
        return view('backend.pages.products.discounts.discount-details')->with(compact('discount'));
    }

    public function edit ($id)
    {
        $discount = Discount::findOrFail($id);
        return view('backend.pages.products.discounts.edit-discount')->with(compact('discount'));
    }

    public function update (Request $request)
    {
        $this->validator($request->all())->validate();
        $updateDiscount = Discount::findOrFail($request->id)->update(['discount' => $request->discount]);
        if ($updateDiscount) {
            Alert::success('Discount updated successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::success('Something went wrong!', 'Oops..!')->persistent("Close this");
            return back();
        }
        return back()->with('status', 'Discount has been updated successfully.');
    }

    public function destroy (Request $request, Discount $discount)
    {
        $delete_discount = $discount->delete();
        Alert::success('Discount has been removed successfully.', 'Success')->persistent("Close this");
        return back();
    }
}
