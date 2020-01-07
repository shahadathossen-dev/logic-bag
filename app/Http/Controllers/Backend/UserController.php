<?php

namespace App\Http\Controllers\Backend;

use Image;
use Alert;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Backend\User;
use App\Models\Frontend\Customer;
use App\Http\Controllers\Controller;
use App\Models\Backend\User\Profile;
use App\Events\Backend\NewUserCreated;
use App\Events\Backend\NewUserApproved;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname'     => 'required|string|max:255',
            'lname'     => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users',
            'username'  => 'required|string|max:255|unique:users',
            'role_id'   => 'required|integer',
            'password'  => 'string|min:6|confirmed',
        ]);
    }

    public function dashboard()
    {
        return view('backend.dashboard');
    }
    
    public function status_notice()
    {
        return view('backend.pages.users.role');
    }

    public function index()
    {
        $users = User::all();
        return view('backend.pages.users.index')->with(compact('users'));
    }

    public function create()
    {
        return view('backend.pages.users.create');
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new NewUserCreated($user = $this->createNewUser($request->all())));

        if ($user->profile()->create(array('user_id' =>  $user->id))){
            Alert::success('New user created successfully!', 'Great!')->persistent("Close this");
            return back();
        } else {
            return $this->sendFailedResponse();
        }
    }

    public function createNewUser(array $data){
        return User::create([
            'fname'     => $data['fname'],
            'lname'     => $data['lname'],
            'email'     => $data['email'],
            'username'  => $data['username'],
            'role_id'   => $data['role_id'],
            'verify_token'=> Str::random(40),
        ]);
    }
    
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('backend.pages.users.user-details')->with(compact('user'));
    }

    public function approve(User $user)
    {
        if ($user->approve()) {
            event(new NewUserApproved($user));
            return back()->with('status', 'User Profile has been approved successfully.');
        }
    }

    public function update(Request $request, $id)
    {
        $updateUser = User::findOrFail($id)->update(['role_id' => $request->role_id, 'status_id' => $request->status_id]);
        if ($updateUser) {
            Alert::success('User has been updated successfully', 'Great!')->persistent("Close this");
            return back();
        } else {
            return $this->sendFailedResponse();
        }
    }

    public function remove(User $user)
    {
        if ($user->delete()){
            Alert::success('User has been trashed successfully', 'Great!')->persistent("Close this");
            return back();
        } else {
            return $this->sendFailedResponse();
        }
    }

    public function delete($id)
    {
        $trashed_user = User::onlyTrashed()->findOrFail($id);
        
        if ($trashed_user->historyDelete()){
            Alert::success('User has been deleted permaenantly.', 'Great!')->persistent("Close this");
            return back();
        } else {
            return $this->sendFailedResponse();
        }
    }

    public function trash()
    {
        $users = User::onlyTrashed()->get();
        return view('backend.pages.users.trash', ['users' => $users]);
    }

    public function restore($id)
    {
        $trashed_user = User::onlyTrashed()->findOrFail($id);
        if ($trashed_user->restore()) {
            Alert::success('User has been restored successfully.', 'Great!')->persistent("Close this");
            return back();
        } else {
            return $this->sendFailedResponse(); 
        }
    }

    public function sendFailedResponse(){
        Alert::warning('Something went wrong!', 'Oops..!')->persistent("Close this");
        return back();
    }

    public function viewCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('backend.pages.customers.customer-details')->with(compact('customer'));
    }

}