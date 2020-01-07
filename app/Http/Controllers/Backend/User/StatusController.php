<?php

namespace App\Http\Controllers\Backend\User;

use Alert;
use Illuminate\Http\Request;
use App\Models\Backend\User\Status;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
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
        $statuses = Status::all();
    	return view('backend.pages.status.index')->with(compact('statuses'));
    }

    public function create ()
    {
    	return view('backend.pages.status.create-status');
    }

    public function store (Request $request)
    {
        $this->validator($request->all())->validate();
        $newStatus = Status::create([
        	'name' => $request->name,
        ]);

        if ($newStatus) {
            Alert::success('New status "'.$newStatus->name.'" created successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::success('Something went wrong!', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function show (Status $status)
    {
        return view('backend.pages.status.status-details')->with(compact('status'));
    }

    public function edit (Status $status)
    {
        return view('backend.pages.status.edit-status')->with(compact('status'));
    }

    public function update (Request $request)
    {
        $this->validator($request->all())->validate();
        $status = Status::findOrFail($request->id)->update(['name' => $request->name]);
        return back()->with('status', 'Status has been updated successfully.');
    }

    public function destroy (Status $status)
    {
        $status->delete();
        Alert::success('Status has been removed successfully.', 'Success')->persistent("Close this");
        return back();
    }
}
