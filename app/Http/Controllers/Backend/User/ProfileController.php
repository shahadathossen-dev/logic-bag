<?php

namespace App\Http\Controllers\Backend\User;

use Image;
use Alert;
use App\Models\Backend\User;
use Illuminate\Http\Request;
use App\Model\Backend\User\Profile;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Events\Backend\NewUserApproved;
use Illuminate\Support\Facades\Storage;

class PofileController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        return view('backend.pages.users.profile')->with(compact('user'));
    }

    public function edit()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        return view('backend.pages.users.edit-profile')->with(compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $fileTemp = $request->avatar;
            $originalName = $fileTemp->getClientOriginalName();
            $realNameOnly = pathinfo($originalName, PATHINFO_FILENAME);
            $originalExtension = $fileTemp->getClientOriginalExtension();
            $filename = $realNameOnly.'_'.uniqid().'.'.$originalExtension;

            // return $originalPath;
            $publicPath    = public_path('storage/backend/users/');
            $originalPath   = ($publicPath.'original/'.$filename);
            $mediumPath     = ($publicPath.'medium/'.$filename);
            $thumbnailPath  = ($publicPath.'thumbnail/'.$filename);

            $originalImg = Image::make($fileTemp)->save($originalPath);
            $mediumImg = Image::make($fileTemp)->resize(400, 400, function($constraint) {
                $constraint->aspectRatio();
            })->save($mediumPath);

            $thumbnailImg = Image::make($fileTemp)->resize(100, 100, function($constraint) {
                $constraint->aspectRatio();
            })->save($thumbnailPath);
        }

        $user->update([
            'fname' => $request->fname, 
            'lname' => $request->lname,
        ]);

        $updateProfile = $user->profile->update([
            'dob'       => $request->dob, 
            'phone'     => $request->phone, 
            'education' => $request->education, 
            'address'   => $request->address, 
            'skills'    => $request->skills, 
            'notes'     => $request->notes,
        	'avatar' 	=> $request->avatar ? $filename : $user->profile->avatar
        ]);

        if ($updateProfile) {
			Alert::success('Profile updated successfully', 'Success!')->persistent("Close this");
        	return redirect(route('admin.profile'));
        } else {
			Alert::warning('Something went wrong!', 'Oops..!')->persistent("Close this");
        }
        // return back()->with('status', 'User Profile has been updated successfully.');
    }

    public function change_password()
    {
        return view('backend.pages.users.change-password');
    }

    public function update_password(Request $request)
    {
        $this->validate($request, [
             'old_password' => 'required',
             'password' => 'required|string|min:6|confirmed'
        ]);

        $user = Auth::guard('admin')->user();

        if (Hash::check($request->old_password, $user->password)) {
            $updatePassword = $user->update(['password' => bcrypt($request->password)]);
            if ($updatePassword) {
                Alert::success('Password has been updated successfully', 'Great!')->persistent("Close this");
                return back();
            } else {
                Alert::warning('Something went wrong!', 'Oops..!')->persistent("Close this");
                return back();
            }
        } else {
            Alert::warning('Please, make sure you provide the right data!', 'Oops..!')->persistent("Close this");
            return back();
        }
    }
}

