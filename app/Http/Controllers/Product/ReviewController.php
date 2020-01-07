<?php

namespace App\Http\Controllers\Product;

use Alert;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Product\Review;
use App\Models\Frontend\Visitor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\Frontend\NewProductReview;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
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
            'product_id'     => 'required|integer|max:255',
            'comment'     => 'required|string|max:255',
            'rating'     => 'required|integer',
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'customer_id'     => 'required|integer',
            'product_id'     => 'required|integer',
            'comment'     => 'required|string|max:255',
            'rating'     => 'required|integer',
        ]);
    }


    public function create ($request)
    {
        return Review::create([
                'product_id' => $request->product_id,
                'customer_id' => $request->customer_id ?: NULL,
                'visitor_id' => $request->visitor_id ?: NULL,
                'comment' => $request->comment,
                'rating' => $request->rating,
            ]);
    }

    public function store (Request $request)
    {
    	if (Auth::guard()->check()) {
        	$this->validator($request->all())->validate();

    		if ($review = $this->create($request->all())) {
                event(new NewProductReview($review));
	            Alert::success('New review submitted successfully.', 'Success')->persistent("Close this");
	            return back();
	        } else {
	            $this->sendFailedResponse();
	        }
    	}

    	$this->vistorValidator($request->all())->validate();

		$visitor = Visitor::firstOrCreate(
            ['email' => $request->email],
        	['name' => $request->name]
        );

        $request->visitor_id = $visitor->id;

        if ($review = $this->create($request)) {
    		event(new NewProductReview($review));
            Alert::success('New review submitted successfully.', 'Success')->persistent("Close this");
            return back();
        } else {
            $this->sendFailedResponse();
        }
    }

    public function index ()
    {
        $reviews = Review::all();
        return view('backend.pages.reviews.index')->with(compact('reviews'));
    }

    public function product_reviews ($productId)
    {
        $reviews = Review::where('product_id', $productId)->get();
        $reviews->product_id = $productId;
    	return view('backend.pages.reviews.product-reviews')->with(compact('reviews'));
    }

    public function show ($id)
    {
        $review = Review::findOrFail($id);
        if (!$review->reviewed) {
            $review->update([
                'reviewed' => 1
            ]);
        }
        return view('backend.pages.reviews.review-details')->with(compact('review'));
    }

    public function edit ($id)
    {
        $review = Review::findOrFail($id);
        return response()->json($review);
    }

    public function update (Request $request)
    {
        $this->validator($request->all())->validate();
        $review = Review::findOrFail($request->id)->update(['comment' => $request->comment, 'rating' => $request->rating]);
        Alert::success('Review updated successfully!', 'Success!')->persistent("Close this");
        return back();
    }

    public function updateReview (Request $request)
    {
        $review = Review::findOrFail($request->id);

    	if ($review->isApproved()) {
    		$review->update([
                'approved' => 0,
            ]);

        	Alert::success('Review has been updated successfully.', 'Success')->persistent("Close this");
        	return back();
    	}

		$review->update([
            'reviewed' => 1,
            'approved' => 1,
        ]);

    	Alert::success('Review has been updated successfully.', 'Success')->persistent("Close this");
        return back();
    }

    public function trash()
    {
        $trashed_reviews = Review::onlyTrashed()->get();
        return view('backend.pages.reviews.trash', ['trashed_reviews' => $trashed_reviews]);
    }

    public function restore(Request $request)
    {
        $review = Review::onlyTrashed()->findOrFail($request->id);
        $review->update([
            'updated_by' => $request->user()->username,
        ]);
        $review->restore();
        return back()->with('status', "Review has been resotred successfully.");
    }

    public function delete(Request $request)
    {
        $review = Review::findOrFail($request->id);

        if ($review) {
            $review->update([
                'updated_by' => $request->user()->username,
            ]);
            $delete_review = $review->delete();
            if ($delete_review) {
                Alert::success('Review has been removed successfully.', 'Success')->persistent("Close this");
                return redirect()->route('admin.reviews');
            } else {
                Alert::warning('Something went wrong.', 'Oops..')->persistent("Close this");
                return redirect()->route('admin.reviews');
            }
        }
    }

    public function destroy ($id)
    {
        $review = Review::onlyTrashed()->findOrFail($id);
        $review->replies()->forceDelete();
        $delete_review = $review->forceDelete();
        if ($delete_review) {
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

}
