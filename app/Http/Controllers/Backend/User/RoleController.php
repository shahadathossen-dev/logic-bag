<?php

namespace App\Http\Controllers\Backend\User;

use Alert;
use Illuminate\Http\Request;
use App\Models\Backend\User\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
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
            'name'     => 'required|string|max:40|unique:roles,name,'.$id.',id',
        ]);
    }

    public function index ()
    {
        $roles = Role::all();
    	return view('backend.pages.roles.index')->with(compact('roles'));
    }

    public function create ()
    {
    	return view('backend.pages.roles.create');
    }

    public function store (Request $request)
    {
        $this->validator($request->all())->validate();
        $newRole = Role::create([
        	'name' => $request->name,
        ]);

        if ($newRole) {
            Alert::success('New role "'.$newRole->name.'" created successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::success('Something went wrong!', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function show (Role $role)
    {
        return view('backend.pages.roles.details')->with(compact('role'));
    }

    public function edit (Role $role)
    {
        return view('backend.pages.roles.edit')->with(compact('role'));
    }

    public function update (Request $request)
    {
        $this->validator($request->all())->validate();
        $role = Role::findOrFail($request->id)->update(['name' => $request->name]);
        return back()->with('status', 'Role has been updated successfully.');
    }

    public function destroy (Role $role)
    {
        $role->delete();
        Alert::success('Role has been removed successfully.', 'Success')->persistent("Close this");
        return back();
    }
}
