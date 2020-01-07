<?php

namespace App\Http\Controllers\Product;

use Alert;
use Illuminate\Http\Request;
use App\Models\Product\Feature;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FeatureController extends Controller
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
            'name'     => 'required|string|max:40',
        ]);
    }

    public function index ()
    {
        $features = Feature::all();
    	return view('backend.pages.products.features.index')->with(compact('features'));
    }

    public function create ()
    {
    	return view('backend.pages.products.features.add-feature');
    }

    public function store (Request $request)
    {
        $this->validator($request->all())->validate();
        $newFeature = Feature::create([
        	'name' => $request->name,
        ]);

        if ($newFeature) {
            Alert::success('New feature "'.$newFeature->name.'" created successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::success('Something went wrong!', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function show ($id)
    {
        $feature = Feature::findOrFail($id);
        return view('backend.pages.products.features.feature-details')->with(compact('feature'));
    }

    public function edit ($id)
    {
        $feature = Feature::findOrFail($id);
        return view('backend.pages.products.features.edit-feature')->with(compact('feature'));
    }

    public function update (Request $request)
    {
        $this->validator($request->all())->validate();
        $feature = Feature::findOrFail($request->id)->update(['name' => $request->name]);
        return back()->with('status', 'Feature has been updated successfully.');
    }

    public function destroy (Request $request)
    {
        $feature = Feature::findOrFail($request->id)->delete();
        Alert::success('Feature has been removed successfully.', 'Success')->persistent("Close this");
        return back();
    }

}
