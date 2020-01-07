<?php

namespace App\Http\Controllers\Pages;

use Image;
use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Frontend\Pages\PageContent;

class AboutPageController extends Controller
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
            'page'      => 'required|string',
            'content'   => ['required', 'string', function ($attribute, $value, $fail) {
                                $words = explode(' ', $value);
                                $nbWords = count($words);
                                if($nbWords < 200){
                                    $fail('The '.$attribute.' must be at least 200 words.');
                                }
                            }],
        ]);
    }

    public function index ()
    {
        $content = PageContent::wherePage('about')->first();
    	return view('backend.pages.about.index')->with(compact('content'));
    }

    public function create ()
    {
    	return view('backend.pages.about.create');
    }

    public function store (Request $request)
    {
        $this->validator($request->all())->validate();

        $newContent = PageContent::create([
            'page' => $request->page,
        	'content' => $request->content,
        ]);

        Alert::success('New content created successfully.', 'Success')->persistent("Close this");
        return back();
    }

    protected function uploadImage($file)
    {
        $publicPath = public_path('storage/backend/sliders/');
        $originalPath = ($publicPath.'/original');
        $thumbnailPath = ($publicPath.'/thumbnail');
        $paths = [$originalPath, $thumbnailPath];
        $fileName = uniqid().'_'.$file->getClientOriginalName();
        $loop = 0;

        foreach ($paths as $path) {
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if ($loop == 0) {
                $uploadImage = Image::make($file)->save($path.'/'.$fileName);
            } else {
                $uploadImage = Image::make($file)->resize(120, 60, function($constraint) {
                    $constraint->aspectRatio();
                })->save($path.'/'.$fileName);
            }
            $loop++;
        }

        return $fileName;
    }

    public function view ()
    {
        $content = PageContent::wherePage('about')->firstOrFail();
        return view('backend.pages.about.view')->with(compact('content'));
    }

    public function edit ()
    {
        $content = PageContent::wherePage('about')->firstOrFail();
        return view('backend.pages.about.edit')->with(compact('content'));
    }

    public function update (Request $request)
    {
        $content = PageContent::wherePage($request->page)->firstOrFail();

        $updateContent = $content->update([ 'content' => $request->content]);

        if ($updateContent) {
            Alert::success('Content has been updated successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::Warning('Something went wrong.', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function destroy (Request $request)
    {
        $slider = Slider::findOrFail($request->id)->delete();
        Alert::success('Slider has been removed successfully.', 'Success')->persistent("Close this");
        return back();
    }



}
