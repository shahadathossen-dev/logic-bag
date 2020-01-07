<?php

namespace App\Http\Controllers\Messages;

use Alert;
use Illuminate\Http\Request;
use App\Models\Frontend\Messages;
use App\Mail\Frontend\MessageReply;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Frontend\Messages\Replies;

class ReplyController extends Controller
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
            'message_id'     => 'required|string|exists:messages,ticket',
            'user_id'     => 'required|integer',
            'reply'     => 'required|string|max:255',
        ]);
    }

    public function reply (Request $request)
    {
        $this->validator($request->all())->validate();

    	$newReply = Replies::create([
        	'message_id' => $request->message_id,
        	'user_id' => $request->user_id,
        	'reply' => $request->reply,
        ]);

		if ($newReply && $this->replyMail ($newReply, $request->subject)) {
            Alert::success('Reply has been submitted successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            Alert::success('Something went wrong!', 'Oops..!')->persistent("Close this");
            return back();
        }

    }

    public function replyMail ($reply, $subject)
    {
        Mail::to($reply->message->user->email)->send(new MessageReply($reply, $subject));
        return true;
    }

    public function index ()
    {
        // $replies = Reply::all()->sortBy(function($reply) {
        //         return sprintf('%-12s%s', $reply->review_id, $reply->created_at);
        //     });
        $replies = Replies::all()->sortBy('created_at');
        return view('backend.pages.replies.index')->with(compact('replies'));
    }

    public function edit ($id)
    {
        $reply = Replies::findOrFail($id);
        return response()->json($reply);
    }

    public function show ($id)
    {
        $reply = Replies::findOrFail($id);

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

        $role = Replies::findOrFail($request->id)->update(['comment' => $request->comment]);
        Alert::success('Reply updated successfully!', 'Success..!')->persistent("Close this");
        return back();
    }

    public function updateReply (Request $request)
    {
        $reply = Replies::findOrFail($request->id);

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
        $reply = Replies::findOrFail($request->id)->delete();
        Alert::success('Reply has been removed successfully.', 'Success')->persistent("Close this");
        return redirect()->route('admin.replies');
    }
}
