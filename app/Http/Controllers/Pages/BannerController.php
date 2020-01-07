<?php

namespace App\Http\Controllers\Pages;

use Image;
use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Frontend\Pages\Banner;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
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
            'model'=> 'required|integer|exists:products,model|unique:banners,model,'.$id,
            'banner'     => 'required|image',
        ]);
    }

    public function index ()
    {
        $banners = Banner::all();

    	return view('backend.pages.banners.index')->with(compact('banners'));
    }

    public function create ()
    {
    	return view('backend.pages.banners.add-banner');
    }

    public function store (Request $request)
    {
        $this->validator($request->all())->validate();
        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $filename = $this->uploadImage($banner);
        }

        $newBanner = Banner::create([
            'model' => $request->model,
        	'banner' => $filename,
        ]);

        Alert::success('New banner created successfully.', 'Success')->persistent("Close this");
        return back();
    }

    protected function uploadImage($file)
    {
        $publicPath = public_path('storage/backend/banners/');
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
        $banner = Banner::findOrFail($id);
        return view('backend.pages.banners.banner-details')->with(compact('banner'));
    }

    public function edit ($id)
    {
        $banner = Banner::findOrFail($id);
        return view('backend.pages.banners.edit-banner')->with(compact('banner'));
    }

    public function update (Request $request)
    {
        $banner = Banner::findOrFail($request->id);

        if ($request->hasFile('banner')) {

            $this->validator($request->all(), $request->id)->validate();
            $newBanner = $request->file('banner');
            $filename = $this->uploadImage($newBanner);

        } else {

            $this->validate($request, [
                'model'     => 'required|string|max:40|exists:products,model|unique:banners,model,'.$request->id,
            ]);

            $filename = $banner->banner;
        }

        $updateBanner = $banner->update(['model' => $request->model, 'banner' => $filename]);

        if ($updateBanner) {
            Alert::success('Banner has been updated successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::Warning('Something went wrong.', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function destroy (Request $request)
    {
        $banner = Banner::findOrFail($request->id)->delete();
        Alert::success('Banner has been removed successfully.', 'Success')->persistent("Close this");
        return back();
    }



}
