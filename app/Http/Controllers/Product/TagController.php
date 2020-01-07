<?php

namespace App\Http\Controllers\Product;

use Alert;
use App\Models\Product\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
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
            'name'     => 'required|string|max:40|unique:tags,name,'.$id.',id',
        ]);
    }

    public function index ()
    {
        $tags = Tag::all();
    	return view('backend.pages.tags.index')->with(compact('tags'));
    }

    public function create ()
    {
    	return view('backend.pages.tags.add-tag');
    }

    public function store (Request $request)
    {
        $this->validator($request->all())->validate();
        $newTag = Tag::create([
        	'name' => $request->name,
        ]);

        if ($newTag) {
            Alert::success('New tag "'.$newTag->name.'" created successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::warning('Something went wrong!', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function show (Tag $tag)
    {
        return view('backend.pages.tags.tag-details')->with(compact('tag'));
    }

    public function edit (Tag $tag)
    {
        return view('backend.pages.tags.edit-tag')->with(compact('tag'));
    }

    public function update (Request $request)
    {
        $this->validator($request->all())->validate();
        $tag = Tag::findOrFail($request->id)->update(['name' => $request->name]);
        Alert::success('Tag has been updated successfully.', 'Success')->persistent("Close this");
        return back();
    }

    public function destroy (Tag $tag)
    {
        $tag->delete();
        Alert::success('Tag has been removed successfully.', 'Success')->persistent("Close this");
        return back();
    }

}
