<?php

namespace App\Http\Controllers\Product\Review;

use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product\Review\Reply;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
{

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'review_id'     => 'required|integer',
            'customer_id'     => 'required|integer',
            'comment'     => 'required|string|max:255',
        ]);
    }

    protected function validatorUser(array $data)
    {
        return Validator::make($data, [
            'review_id'     => 'required|integer',
            'user_id'     => 'required|integer',
            'comment'     => 'required|string|max:255',
        ]);
    }

    public function store (Request $request)
    {
    	if ($request->user() == Auth::guard('admin')->user()) {
        	$this->validatorUser($request->all())->validate();
        	$newReply = Reply::create([
	        	'review_id' => $request->review_id,
	        	'user_id' => $request->user_id,
	        	'comment' => $request->comment,
                'reviewed' => 1,
	        ]);

    		if ($newReply) {
	            Alert::success('Reply has been submitted successfully.', 'Success')->persistent("Close this");
	            return back();
	        } else {
	            Alert::success('Something went wrong!', 'Oops..!')->persistent("Close this");
	            return back();
	        }
    	}

    	$this->validator($request->all())->validate();

		$newReply = Reply::create([
        	'review_id' => $request->review_id,
        	'customer_id' => $request->customer_id,
        	'comment' => $request->comment,
        ]);

		if ($newReply) {
            Alert::success('Reply has been submitted successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::success('Something went wrong!', 'Oops..!')->persistent("Close this");
            return back();
        }
    }

    public function index ()
    {
        // $replies = Reply::all()->sortBy(function($reply) {
        //         return sprintf('%-12s%s', $reply->review_id, $reply->created_at);
        //     });
        $replies = Reply::all()->sortBy('review_id');
        return view('backend.pages.replies.index')->with(compact('replies'));
    }

    public function edit ($id)
    {
        $reply = Reply::findOrFail($id);
        return response()->json($reply);
    }

    public function show ($id)
    {
        $reply = Reply::findOrFail($id);

        if (!$reply->reviewed) {
            $reply->update([
                'reviewed' => 1
            ]);
        }

        return view('backend.pages.replies.reply-details')->with(compact('reply'));
    }

    public function update (Request $request)
    {
        if ($request->user() == Auth::guard('admin')->user()) {
            $this->validatorUser($request->all())->validate();
        } else {
            $this->validator($request->all())->validate();
        }

        $role = Reply::findOrFail($request->id)->update(['comment' => $request->comment]);
        Alert::success('Reply updated successfully!', 'Success..!')->persistent("Close this");
        return back();
    }

    public function updateReply (Request $request)
    {
        $reply = Reply::findOrFail($request->id);

        if ($reply->isApproved()) {
            $reply->update([
                'reviewed' => 1,
                'approved' => 0,
            ]);

            Alert::success('Reply has been updated successfully.', 'Success')->persistent("Close this");
            return back();
        }

        $reply->update([
            'approved' => 1,
        ]);

        Alert::success('Reply has been updated successfully.', 'Success')->persistent("Close this");
        return back();
    }

    public function destroy (Request $request)
    {
        $reply = Reply::findOrFail($request->id)->delete();
        Alert::success('Reply has been removed successfully.', 'Success')->persistent("Close this");
        return redirect()->route('admin.replies');
    }
}
