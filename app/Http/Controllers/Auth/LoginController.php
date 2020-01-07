<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Frontend\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Redirect;
use App\Events\Frontend\NewCustomerRegistered;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Obtain the customer information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $driver)
    {
        try {
            if ($driver == 'google') {
                $customer = Socialite::driver($driver)->stateless()->user();
            } else {
                $customer = Socialite::driver($driver)->user();
            }
        } catch (Exception $e) 
        {
            return redirect()->back()->with(compact(e));
        }

        $authCustomer = $this->findOrCreateCustomer($customer);

        Auth::guard()->login($authCustomer);

        return redirect()->intended($this->redirectPath()) ?: redirect($this->redirectTo);

        // All Providers
        // $user->getId();
        // $user->getNickname();
        // $user->getName();
        // $user->getEmail();
        // return $user->getAvatar();
        // $user->token;
    }

    public function findOrCreateCustomer($customer)
    {
        $oldCustomer = Customer::where('email', $customer->email)->first();

        if ($oldCustomer) {
            return $oldCustomer;
        }

        if ($customer->getAvatar()) {
            $arrContextOptions=['ssl'=>['verify_peer'=>false,'verify_peer_name'=>false]];
            $fileUrl = $customer->getAvatar();
            $file = file_get_contents($fileUrl, false, stream_context_create($arrContextOptions));
            $filename = str_slug($customer->getName()).'_'.uniqid().'.jpg';

            $storagePath    = public_path('storage/frontend/customers/');
            $path   = ($storagePath.$filename);
            if (!file_exists($storagePath)) {
                mkdir($path, 0777, true);
            }
            $image = Image::make($file)->save($path);
        }

        $fullName = $customer->getName();
        $nameArray = explode(' ', $fullName, 2);
        $fname = $nameArray[0];
        $lname = $nameArray[1];
        $email = $customer->getEmail();
        $password = str_random(6);
        $newCustomer = Customer::create([
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'password' => Hash::make($password),
            'avatar' => $filename,
            'email_verified_at' => Carbon::now(),
        ]);

        $newCustomer->palain_password = $password;

        event(new NewCustomerRegistered($newCustomer));

        return $newCustomer;
    }

}
