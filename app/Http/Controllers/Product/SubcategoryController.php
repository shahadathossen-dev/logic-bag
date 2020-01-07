<?php

namespace App\Http\Controllers\Product;

use Alert;
use Illuminate\Http\Request;
use App\Models\Product\Category;
use App\Models\Product\Subcategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
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
            'category_id'=> 'required|integer',
            'title'     => 'required|string|max:40|unique:subcategories,title,'.$id.',id,category_id,'.Input::get('category_id'),
        ]);
    }

    public function index ()
    {
        $subcategoriesCollection = Subcategory::all()
            ->map(function ($subcategory) {
                return ['subcategory' => $subcategory, 'category' => $subcategory->category->title];
            })
            ->groupBy('category')
            ->sortByDesc('created_at');

        $subcategories = $subcategoriesCollection->toArray();
        
    	return view('backend.pages.subcategories.index')->with(compact('subcategories'));
    }

    public function create ()
    {
        $categories = Category::all();
    	return view('backend.pages.subcategories.add-subcategory');
    }

    public function store (Request $request)
    {
        $this->validator($request->all())->validate();

        $newSubcategory = Subcategory::create([
            'category_id' => $request->category_id,
        	'title' => $request->title,
        ]);
        Alert::success('New subcategory created successfully.', 'Success')->persistent("Close this");
        return back();
    }

    public function show ($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        return view('backend.pages.subcategories.subcategory-details')->with(compact('subcategory'));
    }

    public function edit ($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        return view('backend.pages.subcategories.edit-subcategory')->with(compact('subcategory'));
    }

    public function update (Request $request)
    {
        $this->validator($request->all(), $request->id)->validate();

        $updateSubcategory = Subcategory::updateOrCreate(['id' => $request->id, 'category_id' => $request->category_id], ['category_id' => $request->category_id, 'title' => $request->title]);
        if ($updateSubcategory) {
            Alert::success('Subcategory has been updated successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::Warning('Something went wrong.', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function destroy (Request $request)
    {
        $subcategory = Subcategory::findOrFail($request->id)->delete();
        Alert::success('Subcategory has been removed successfully.', 'Success')->persistent("Close this");
        return back();
    }



}
