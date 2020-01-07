<?php

namespace App\Http\Controllers\Backend\Auth;


use Image;
use App\Model\Backend\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\Backend\User\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\Backend\NewUserCreated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
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
        $this->middleware('auth:admin')->except(['createPassword']);
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
            'role_id'      => 'required|integer',
            'password'  => 'string|min:6|confirmed',
            'verify_token'  => 'string|max:100',
            'email_verified'  => 'boolean',
        ]);
    }
    
    /**
     * Verifies email and creates new password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createPassword(Request $request)
    {
        $user = User::findOrFail($request->id);

        $this->validate($request, [
             'password' => 'required|string|min:6|confirmed',
        ]);
        
        if($user->markEmailAsVerified()) {

            // $user->update(['password' => Hash::make($request->password), 'status_id' => 1, 'verify_token' => NULL]);
            $user->password = Hash::make($request->password);
            $user->status_id = 1;
            $user->verify_token = NULL;
            $user->save();
                        
            event(new Verified($user));

            if ($request->signin) {
                $this->guard()->login($user);
            }

            return $this->registered($request, $user)
                    ?: redirect($this->redirectPath());
        }

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

        event(new NewUserCreated($user = $this->create($request->all())));
        $user->profile()->create([
            'user_id' => $user->id,
        ]);

        return back()->with('status', 'New user created successfully!');
    }

    public function create(array $data){
        return User::create([

            'fname'     => $data['fname'],
            'lname'     => $data['lname'],
            'email'     => $data['email'],
            'username'  => $data['username'],
            'role_id'   => $data['role_id'],
            'verify_token'=> Str::random(40),

        ]);
    }


}
