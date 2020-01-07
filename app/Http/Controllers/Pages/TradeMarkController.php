<?php

namespace App\Http\Controllers\Pages;

use Image;
use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Frontend\Pages\TradeMarks;
use Illuminate\Support\Facades\Validator;

class TradeMarkController extends Controller
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
            'type'      => 'required|string|unique:trade_marks,type,'.$id.',id',
            'content'   => 'required|string',
        ]);
    }

    protected function image_validator(array $data, $id = NULL)
    {
        return Validator::make($data, [
            'type'      => 'required|string|unique:trade_marks,type,'.$id.',id',
            'content'   => 'required|image',
        ]);
    }

    public function index ()
    {
        $trade = TradeMarks::whereType('logo')->first();
        return view('backend.pages.home.index')->with(compact('trade'));
    }

    public function create_logo ()
    {
        return view('backend.pages.home.create-logo')->with(compact('trade'));
    }

    public function store_logo (Request $request)
    {
        $this->image_validator($request->all())->validate();
        
        if ($request->hasFile('content')) {
            $image = $request->file('content');
            $fileName = $this->uploadImage($image);
        }

        $newContent = TradeMarks::create([
            'type' => $request->type,
            'content' => $fileName,
        ]);

        Alert::success('New logo uploaded successfully.', 'Success')->persistent("Close this");
        return back();
    }

    protected function uploadImage($file)
    {
        $publicPath = public_path('storage/frontend/bgs');
        $fileName = uniqid().'_'.$file->getClientOriginalName();

        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0777, true);
        }

        $uploadImage = Image::make($file)->save($publicPath.'/'.$fileName);

        return $fileName;
    }

    public function view_logo ()
    {
        $content = TradeMarks::whereType('home')->firstOrFail();
        return view('backend.pages.home.view')->with(compact('content'));
    }

    public function edit_logo ()
    {
        $logo = TradeMarks::whereType('logo')->firstOrFail();
        return view('backend.pages.home.edit-logo')->with(compact('logo'));
    }

    public function update_logo (Request $request)
    {
        $logo = TradeMarks::whereType($request->type)->firstOrFail();
        $this->image_validator($request->all(), $logo->id)->validate();

        $oldLogo = public_path('storage/frontend/bgs/'.$request->content);
        if (file_exists($oldLogo)) {
            unlink($oldLogo);
        }

        if ($request->hasFile('content')) {
            $newLogo = $request->file('content');
            $filename = $this->uploadImage($newLogo);
        }

        $updateLogo = $logo->update([ 'content' => $filename]);

        if ($updateLogo) {
            Alert::success('Logo has been updated successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::Warning('Something went wrong.', 'Oops..!')->persistent("Close this");
            return back();
        }
    }
    
    public function create ($trade)
    {
        return view('backend.pages.home.create')->with(compact('trade'));
    }

    public function store (Request $request)
    {
        $this->validator($request->all())->validate();
        
        $newContent = TradeMarks::create([
            'type' => $request->type,
            'content' => $request->content,
        ]);

        if ($newContent) {
            Alert::success('New '.ucfirst($newContent->type).' uploaded successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::Warning('Something went wrong.', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function view ($type)
    {
        $trade = TradeMarks::whereType($type)->firstOrFail();
        return view('backend.pages.home.view')->with(compact('trade'));
    }

    public function edit ($type)
    {
        $trade = TradeMarks::whereType($type)->firstOrFail();
        return view('backend.pages.home.edit')->with(compact('trade'));
    }

    public function update (Request $request)
    {
        $content = TradeMarks::whereType($request->type)->firstOrFail();

        $this->validator($request->all(), $content->id)->validate();

        $updateContent = $content->update([ 'content' => $request->content]);

        if ($updateContent) {
            Alert::success(ucfirst($content->type).' has been updated successfully.', 'Success')->persistent("Close this");
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
