<?php

namespace App\Http\Controllers\Product;

use Alert;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Product\Meta;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MetaController extends Controller
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
		    'description'     => 'required|string',
        ]);
	}

    public function show ($model)
    {
        $meta = Meta::whereModel($model)->firstOrFail();
        return view('backend.pages.products.meta.show')->with(compact('meta'));
    }

    public function edit ($model)
    {
        $meta = Meta::whereModel($model)->firstOrFail();
        return view('backend.pages.products.meta.edit')->with(compact('meta'));
    }

    public function update (Request $request)
    {
        $this->validator($request->all(), $request->id)->validate();

        $meta = Meta::findOrFail($request->id);

        $updateMeta = $meta->update([
            'description' => $request->description,
            'updated_by' => Auth::guard('admin')->user()->username,
        ]);

        if ($updateMeta) {
            Alert::success('Product meta has been updated successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::warning('Order not found.', 'Oops!')->persistent("Close this");
            return back();
        }

    }

}
