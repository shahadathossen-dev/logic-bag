<?php

namespace App\Http\Controllers\Pages;

use Image;
use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Frontend\Pages\Slider;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
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
            'model'=> 'required|integer|exists:products,model|unique:sliders,model,'.$id.'id',
            'image'     => 'required|image',
        ]);
    }

    public function index ()
    {
        $sliders = Slider::all();

    	return view('backend.pages.sliders.index')->with(compact('sliders'));
    }

    public function create ()
    {
    	return view('backend.pages.sliders.add');
    }

    public function store (Request $request)
    {
        $this->validator($request->all())->validate();
        if ($request->hasFile('image')) {
            $slider = $request->file('image');
            $filename = $this->uploadImage($slider);
        }

        $newSlider = Slider::create([
            'model' => $request->model,
        	'image' => $filename,
        ]);

        Alert::success('New slider created successfully.', 'Success')->persistent("Close this");
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

    public function show ($id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.pages.sliders.details')->with(compact('slider'));
    }

    public function edit ($id)
    {
        $slider = Slider::findOrFail($id);
        return view('backend.pages.sliders.edit')->with(compact('slider'));
    }

    public function update (Request $request)
    {
        $slider = Slider::findOrFail($request->id);

        $publicPath = public_path('storage/backend/sliders/');
        $thumbnails = [$publicPath.'original/'.$slider->image, $publicPath.'/thumbnail/'.$slider->image];
        foreach ($thumbnails as $thumbnail) {
            if (file_exists($thumbnail)) {
                unlink($thumbnail);
            }
        }

        if ($request->hasFile('image')) {

            $this->validator($request->all(), $request->id)->validate();
            $sliderImg = $request->file('image');
            $filename = $this->uploadImage($sliderImg);
            $updateSlider = $slider->update(['model' => $request->model, 'image' => $filename]);

        } else {

            $this->validate($request, [
                        'model'     => 'required|string|max:40|exists:products,model|unique:sliders,model,'.$request->id.'id',
                    ]
                );

            $updateSlider = $slider->update(['model' => $request->model]);
        }


        if ($updateSlider) {
            Alert::success('Slider has been updated successfully.', 'Success')->persistent("Close this");
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
