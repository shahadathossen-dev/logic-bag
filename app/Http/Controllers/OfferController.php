<?php

namespace App\Http\Controllers;

use Alert;
use Illuminate\Http\Request;
use App\Models\Frontend\Offer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    protected function validator(array $data, $id = NULL)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:100|unique:offers,name'.$id,
            'model'     => 'required|integer|exists:products,model|unique:offers,model,'.$id.'|unique:discounts,model',
            'discount'     => 'required|numeric|max:4',
            'expiry_date'   => 'required|date|after_or_equal:today',
        ]);
    }

    public function index ()
    {
        $offers = Offer::all();

        return view('backend.pages.offers.index')->with(compact('offers'));
    }

    public function create ()
    {
        return view('backend.pages.offers.add-offer');
    }

    public function store (Request $request)
    {
        $request->offer_id = $this->getNextOfferNumber();
        $this->validator($request->all())->validate();

        $newOfferItem = Offer::create([
            'offer_id' => $request->offer_id,
            'name' => $request->name,
            'model' => $request->model,
            'discount' => $request->discount,
            'expiry_date' => $request->expiry_date,
        ]);

        Alert::success('New offer item created successfully.', 'Success')->persistent("Close this");
        return back();
    }

    public function show ($id)
    {
        $offer = Offer::findOrFail($id);
        return view('backend.pages.offers.offer-details')->with(compact('offer'));
    }

    public function edit ($id)
    {
        $offer = Offer::findOrFail($id);
        return view('backend.pages.offers.edit-offer')->with(compact('offer'));
    }

    public function update (Request $request)
    {
        $offer = Offer::findOrFail($request->id);
        $this->validator($request->all(), $request->id)->validate();

        $updateOffer = $offer->update([
            'name' => $request->name,
            'model' => $request->model, 
            'discount' => $request->discount,
            'expiry_date' => $request->expiry_date,
        ]);

        if ($updateOffer) {
            Alert::success('Offer item has been updated successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::Warning('Something went wrong.', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function destroy (Request $request)
    {
        $offerItem = Offer::findOrFail($request->id)->delete();
        Alert::success('Offer item has been removed successfully.', 'Success')->persistent("Close this");
        return back();
    }

    protected function getNextOfferNumber()
    {
        // Get the last created order
        $lastOffer = DB::table('orders')->orderBy('created_at', 'desc')->first();

        if ( ! $lastOffer )
            // We get here if there is no order at all
            // If there is no number set it to 0, which will be 1 at the end.

            $number = 0;
        else 
            $number = substr($lastOffer->offer_id, 3);

        // If we have ORD000001 in the database then we only want the number
        // So the substr returns this 000001

        // Add the string in front and higher up the number.
        // the %05d part makes sure that there are always 6 numbers in the string.
        // so it adds the missing zero's when needed.
     
        return 'OFR' . sprintf('%06d', intval($number) + 1);
    }

}
