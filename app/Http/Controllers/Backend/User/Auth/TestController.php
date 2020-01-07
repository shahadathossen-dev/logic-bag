<?php

namespace App\Http\Controllers\Backend\User\Auth;

use Image;
use Illuminate\Support\Str;
use App\Model\Backend\User;
use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class TestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin')->except('createPassword');
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
            'fname'     => 'required|string|max:255',
            'lname'     => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'username'  => 'required|string|max:255|unique:users',
            'role'      => 'required|integer',
            'password'  => 'string|min:6|confirmed',
            'verify_token'  => 'string|max:100',
            'email_verified'  => 'boolean',
        ]);
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('backend.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if ($request->hasFile('avatar')) {
            $fileTemp = $request->avatar;
            $originalName = $fileTemp->getClientOriginalName();
            $realNameOnly = pathinfo($originalName, PATHINFO_FILENAME);
            $originalExtension = $fileTemp->getClientOriginalExtension();
            $filename = $realNameOnly.'_'.uniqid().'.'.$originalExtension;
            $fileImage = $fileTemp->storeAs('public/backend/users/original', $filename);
            $request->filename = $filename;
        }

        $newUser = Admin::create([

            'fname'     => $request->fname,
            'lname'     => $request->lname,
            'email'     => $request->email,
            'username'  => $request->username,
            'avatar'    => $request->avatar ? $filename : 'avatar.png',
            'role'      => $request->role,
            'verify_token'      => Str::random(40),

        ]);

        $thisUser = Admin::findOrFail($newUser->id);
        $this->sendEmail($thisUser);
        
        return back()->with('status', 'New user created successfully!');

        // event(new Registered($user = $this->create($request->all())));

    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if ($request->hasFile('avatar')) {
            $fileTemp = $request->avatar;
            $originalName = $fileTemp->getClientOriginalName();
            $realNameOnly = pathinfo($originalName, PATHINFO_FILENAME);
            $originalExtension = $fileTemp->getClientOriginalExtension();
            $filename = $realNameOnly.'_'.uniqid().'.'.$originalExtension;

            Storage::put('public/backend/users/original/'.$filename, fopen($fileTemp, 'r+'));
            Storage::put('public/backend/users/medium/'.$filename, fopen($fileTemp, 'r+'));
            Storage::put('public/backend/users/thumbnail/'.$filename, fopen($fileTemp, 'r+'));
            
            $publicPath    = public_path('storage/');
            $originalPath   = ($publicPath.'backend/users/original/'.$filename);
            $mediumPath     = ($publicPath.'backend/users/medium/'.$filename);
            $thumbnailPath  = ($publicPath.'backend/users/thumbnail/'.$filename);

            // return $originalPath;
            $mediumImg = Image::make($mediumPath)->resize(400, 400, function($constraint) {
                $constraint->aspectRatio();
            });

            $thumbnailImg = Image::make($thumbnailPath)->resize(100, 100, function($constraint) {
                $constraint->aspectRatio();
            });

            $mediumImg->save($mediumPath);
            $thumbnailImg->save($thumbnailPath);

            // $img = Image::make($thumbnailpath)->resize(100, 100)->save($thumbnailpath);
            
            // $fileImage = $fileTemp->storeAs('public/backend/users/original', $filename);
        }

        $newUser = Admin::create([

            'fname'     => $request->fname,
            'lname'     => $request->lname,
            'email'     => $request->email,
            'username'  => $request->username,
            'avatar'    => $request->avatar ? $filename : 'avatar.png',
            'role'      => $request->role,
            'verify_token'      => Str::random(40),

        ]);

        $thisUser = Admin::findOrFail($newUser->id);
        $this->sendEmail($thisUser);
        
        return back()->with('status', 'New user created successfully!');

        // event(new Registered($user = $this->create($request->all())));

    }

    /**
     * Send verification email to new created user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmail($thisUser)
    {
        Mail::to($thisUser['email'])->send(new VerificationMail($thisUser));
            
    }

    /**
     * Verifies email and creates new password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createPassword($email, $verify_token, Request $request)
    {
        $user = Admin::where(['email' => $email, 'verify_token' => $verify_token])->first();

        if ($user) {

            if ($request->isMethod('post')) {

                Admin::where(['email' => $email, 'verify_token' => $verify_token])->update(['email_verified' => 1, 'verify_token' => NULL, 'password' => Hash::make($request->password)]);

                $this->guard()->login($user);

                return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());

            } else {

                return view('backend.auth.create-password');
            }

         } else {
            return "Sorry, User not found";
         }
    }

}
