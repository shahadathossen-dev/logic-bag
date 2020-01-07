<?php

namespace App\Http\Controllers\Product;

Use Alert;
use Illuminate\Http\Request;
use App\Models\Product\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
    protected function validator(array $data, $id = NULL)
    {
        return Validator::make($data, [
            'title'     => 'required|string|max:40|unique:categories,title,'.$id.',id',
        ]);
    }

    public function index ()
    {
        $categories = Category::all();
    	return view('backend.pages.categories.index')->with(compact('categories'));
    }

    public function create ()
    {
    	return view('backend.pages.categories.add-category');
    }

    public function store (Request $request)
    {
        $this->validator($request->all())->validate();
        $newCategory = Category::create([
        	'title' => $request->title,
        ]);
        Alert::success('Category has been created successfully.', 'Success')->persistent("Close this");
        return back();
    }

    public function subcategories ($id)
    {
        return $subcategories = Category::findOrFail($id)->subcategories->pluck('title', 'id');
    }

    public function show ($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.pages.categories.category-details')->with(compact('category'));
    }

    public function edit ($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.pages.categories.edit-category')->with(compact('category'));
    }

    public function update (Request $request)
    {
        $this->validator($request->all(), $request->id)->validate();
        $updateCategory = Category::findOrFail($request->id)->update(['title' => $request->title]);
        if ($updateCategory) {
            Alert::success('Category has been updated successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::Warning('Something went wrong.', 'Oops..!')->persistent("Close this");
            return back();
        }
        return back()->with('status', 'Category has been updated successfully.');
    }

    public function destroy (Request $request)
    {
        $category = Category::findOrFail($request->id)->delete();
        Alert::success('Category has been removed successfully.', 'Success')->persistent("Close this");
        return back();
    }



}
