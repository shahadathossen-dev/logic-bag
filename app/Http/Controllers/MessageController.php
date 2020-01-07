<?php

namespace App\Http\Controllers;

use Alert;
use Illuminate\Http\Request;
use App\Models\Frontend\Visitor;
use App\Models\Frontend\Messages;
use App\Models\Frontend\Customer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Events\Frontend\NewCustomerMessage;

class MessageController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function vistorValidator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|string|max:40',
            'email' 	=> 'required|email|max:255',
            'subject'     => 'required|string|max:50',
            'message'     => 'required|string|max:255',
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'customer_id'     => 'required|integer',
            'subject'     => 'required|string|max:50',
            'message'     => 'required|string|max:255',
        ]);
    }


    public function create ($request)
    {
        return Messages::create([
                'ticket' => $this->getNextTicketNumber(),
                'visitor_id' => $request->visitor_id ?: NULL,
                'customer_id' => $request->customer_id ?: NULL,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);
    }

    public function post (Request $request)
    {
    	if (Auth::guard()->check()) {
        	$this->validator($request->all())->validate();
            $request->visitor_id = $visitor->id;

    		if ($message = $this->create($request->all())) {
                event(new NewCustomerMessage($message));
	            Alert::success('Your message has been submitted successfully.', 'Success')->persistent("Close this");
	            return back();
	        } else {
	            $this->sendFailedResponse();
	        }
    	}

    	$this->vistorValidator($request->all())->validate();

		$visitor = Visitor::firstOrCreate(
            ['email' => $request->email],
            ['name' => $request->name],
        );

        $request->visitor_id = $visitor->id;

        if ($message = $this->create($request)) {
    		event(new NewCustomerMessage($message));
            Alert::success('Your message has been submitted successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            $this->sendFailedResponse();
        }
    }

    public function index ()
    {
        $messages = Messages::withCount('replies')->get();
        return view('backend.pages.messages.index')->with(compact('messages'));
    }

    public function product_messages ($productId)
    {
        $messages = Messages::where('product_id', $productId)->get();
        $messages->product_id = $productId;
    	return view('backend.pages.messages.product-messages')->with(compact('messages'));
    }

    public function show ($id)
    {
        $message = Messages::withCount('replies')->findOrFail($id);
        if (!$message->reviewed) {
            $message->update([
                'reviewed' => 1
            ]);
        }
        return view('backend.pages.messages.details')->with(compact('message'));
    }

    public function edit ($id)
    {
        $review = Messages::findOrFail($id);
        return response()->json($review);
    }

    public function update (Request $request)
    {
        $this->validator($request->all())->validate();
        $review = Review::findOrFail($request->id)->update(['message' => $request->message, 'rating' => $request->rating]);
        Alert::success('Review updated successfully!', 'Success!')->persistent("Close this");
        return back();
    }

    public function updateReview (Request $request)
    {
        $message = Review::findOrFail($request->id);

    	if ($message->isApproved()) {
    		$message->update([
                'approved' => 0,
            ]);

        	Alert::success('Review has been updated successfully.', 'Success')->persistent("Close this");
        	return back();
    	}

		$message->update([
            'reviewed' => 1,
        ]);

    	Alert::success('Review has been updated successfully.', 'Success')->persistent("Close this");
        return back();
    }

    public function trash()
    {
        $trashed_messages = Review::onlyTrashed()->get();
        return view('backend.pages.messages.trash', ['trashed_messages' => $trashed_messages]);
    }

    public function restore(Request $request)
    {
        $message = Review::onlyTrashed()->findOrFail($request->id);
        $message->update([
            'updated_by' => $request->user()->username,
        ]);
        $message->restore();
        return back()->with('status', "Review has been resotred successfully.");
    }

    public function delete(Request $request)
    {
        $message = Review::findOrFail($request->id);

        if ($message) {
            $message->update([
                'updated_by' => $request->user()->username,
            ]);
            $delete_message = $message->delete();
            if ($delete_message) {
                Alert::success('Review has been removed successfully.', 'Success')->persistent("Close this");
                return redirect()->route('admin.messages');
            } else {
                Alert::warning('Something went wrong.', 'Oops..')->persistent("Close this");
                return redirect()->route('admin.messages');
            }
        }
    }

    public function destroy ($id)
    {
        $message = Review::onlyTrashed()->findOrFail($id);
        $message->replies()->forceDelete();
        $delete_message = $message->forceDelete();
        if ($delete_message) {
            Alert::success('Review has been destroyed permanently.', 'Success')->persistent("Close this");
            return back();
        } else {
            $this->sendFailedResponse();
        }
    }

    public function sendFailedResponse(){
        Alert::warning('Something went wrong!', 'Oops..!')->persistent("Close this");
        return back();
    }

    protected function getNextTicketNumber()
    {
        // Get the last created order
        $lastMessage = DB::table('messages')->orderBy('created_at', 'desc')->first();

        if ( ! $lastMessage )
            // We get here if there is no order at all
            // If there is no number set it to 0, which will be 1 at the end.

            $number = 0;
        else 
            $number = substr($lastMessage->ticket, 3);

        // If we have ORD000001 in the database then we only want the number
        // So the substr returns this 000001

        // Add the string in front and higher up the number.
        // the %05d part makes sure that there are always 6 numbers in the string.
        // so it adds the missing zero's when needed.
     
        return 'MSG' . sprintf('%06d', intval($number) + 1);
    }

}
