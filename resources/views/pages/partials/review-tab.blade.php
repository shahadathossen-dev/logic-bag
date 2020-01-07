@php 
  $customer = Auth::guard()->user(); 
@endphp
<div id="review" class="tab-pane fade show active" role="tabpanel" aria-labelledby="review-tab">
   	<div class="row">
   		<div class="col-md-8">
   			<h3 class="text-right">{{count($product->reviews)}} Reviews</h3>
   			<div class="review-pane">
	   			@php
	   			$reviews = $product->reviews->sortByDesc('created_at');
	   			@endphp
	   			@if ($reviews)
	   			@foreach ($reviews as $review)
	   			<div class="review row">
			   		<div class="col-md-2">
		   				<img class="user-img" src="{{asset('storage/frontend/customers/'.$review->reviewer->avatar)}}"/>
			   		</div>
			   		<div class="col-md-10 no-gutters">
				   		<div class="desc">
				   			<h4>
				   				<span class="text-left">
		   						{{$review->reviewer->name}}
				   				</span>
			   					<span class="minimize" title="Minimize"><i class="far fa-window-minimize"></i></span>

				   			</h4>
				   			<p class="star">
				   				<span class="rating_r rating_r_{{$review->rating}} banner_2_rating">
									<i></i><i></i><i></i><i></i><i></i>
								</span>
				   				<span class="text-right">{{$review->created_at->format('d M Y H:i')}}</span>
				   			</p>
				   			<p>{{$review->comment}}</p>
			   			</div>
			   			@auth
			   			<div class="edit-panel">
			   				@if ($customer->id == $review->customer_id)
		   					<span class="edit" title="Edit">
		   						<a class="edit-review" data-target="#review-form" href="{{route('edit.review', ['id' => $review->id])}}">
		   							<i class="fa fa-edit"></i> Edit
			   					</a>
			   				</span>
			   				@endif
		   					<span class="reply-btn float-right" title="Reply">Reply <i class="fa fa-reply"></i></span>
			   			</div>
				   		<div class="col-md-12 no-gutters">
						   	<div class="reply-form-field" style="display: none;">
								<form class="reply-form text-right" method="POST" action="{{route('post.reply')}}">
			                        @csrf
									<input type="hidden" name="customer_id" value="{{$customer->id}}">
									<input type="hidden" name="review_id" value="{{$review->id}}">
									<textarea style="display: inline; max-width: 70%;" class="input form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" placeholder="Your Reply" required></textarea>&nbsp;
									@if ($errors->has('comment'))
			                            <span class="invalid-feedback" role="alert">
			                                <strong>{{ $errors->first('comment') }}</strong>
			                            </span>
			                        @endif
									<button style="display: inline; vertical-align: top;" class="btn btn-primary" type="submit">Reply</button>
								</form>
							</div>
						</div>
			   			@endauth
			   		</div>

			   		<div class="col-md-10 offset-md-2 no-gutters">
				   		<div class="reply-pane">
				   			@php
	   						$replies = $review->replies;
				   			@endphp
				   			@if (count($replies) > 0)
							@foreach ($replies as $reply)
							@php
								$replier = $reply->replier;
							@endphp
				   			<div class="reply row">
						   		<div class="col-md-2">
							   		<div class="user-img">
							   			@if ($replier instanceof App\Models\Backend\User)
						   				<img class="user-img" src="{{asset('storage/backend/users/thumbnail/'.$replier->profile->avatar)}}"/>
							   			@else
							   			<img class="user-img" src="{{asset('storage/frontend/customers/'.$replier->avatar)}}"/>
							   			@endif
							   		</div>
								</div>
						   		<div class="col-md-10 pl-0">
							   		<div class="desc">
							   			<h4>
							   				@if ($replier instanceof App\Models\Backend\User)
                                                <span class="text-left">{{$replier->name()}}</span>
                                            @else
                                                <span class="text-left">{{$replier->name}}</span>
                                            @endif
							   				<span class="text-right">{{$reply->created_at->format('d M Y H:i')}}</span>
							   			</h4>
							   			<p>{{$reply->comment}}</p>
							   			
							   		</div>
							   		<div class="edit-panel">
					   					<span class="edit">
			   								@auth
			   								@if ($customer->id == $reply->customer_id)
					   						<a class="edit-reply" href="{{route('edit.reply', ['id' => $reply->id])}}">
					   							<i class="fa fa-edit closed"></i><i class="far fa-file-alt open" style="display: none"></i> Edit
					   						</a>
					   						@endif
						   					@endauth
					   					</span>
						   			</div>
							   	</div>
							   	@auth
			   					@if ($customer->id == $reply->customer_id)
								<div class="col-md-12">
								   	<div class="reply-edit-form-field" style="display: none;">
										<form class="reply-edit-form text-right" method="POST" action="{{route('update.reply')}}">
					                        @csrf
											<input type="hidden" name="customer_id" value="{{$reply->customer_id}}">
											<input type="hidden" name="review_id" value="{{$reply->review_id}}">
											<input type="hidden" name="id" value="{{$reply->id}}">
											<textarea style="display: inline; max-width: 70%;" class="input form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" placeholder="Your Reply" required>{{$reply->comment}}</textarea>&nbsp;
											@if ($errors->has('comment'))
					                            <span class="invalid-feedback" role="alert">
					                                <strong>{{ $errors->first('comment') }}</strong>
					                            </span>
					                        @endif
											<button style="display: inline; vertical-align: top;" class="btn btn-primary" type="submit">Update</button>
										</form>
									</div>
								</div>
								@endif
								@endauth
				   				<!-- Reply form field could be here -->
							</div>
							@endforeach
				   			@endif
						</div>
					</div>
		   		</div>
		   		@endforeach
		   		@endif
   			</div>
   			<div class="pagination-links">
   				{{-- {{ $reviews->links() }} --}}
   			</div>
   		</div>
   		<div class="col-md-4 col-md-push-1">
   			<div class="rating-wrap">
	   			<h3 class="pane-title">Give a Review</h3>
	   			<!-- Review Form -->
				<div id="review-form">
					@if (!count($product->reviews) > 0)
						{{-- <span class="alert alert-success">Be the first one to review this product.</span> --}}
						<p style="color: green; line-height: 15px; margin-bottom: 10px;">Be the first one to review this product<span style="color: red;">*</span></p>
					@endif
					<form class="review-form" method="POST" action="{{route('post.review')}}">
                        @csrf
                        @auth
							<input type="hidden" name="customer_id" value="{{$customer->id}}">
						@else
						<div class="form-group">
							<input class="input form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" placeholder="Your Name" required>
							@if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
						</div>
						<div class="form-group">
							<input class="input form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" placeholder="Your Email" required>
							@if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
						</div>
						@endauth
						<input type="hidden" name="product_id" value="{{$product->id}}">
						<div class="form-group">
							<textarea class="input form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" placeholder="Your Comment" required></textarea>
							@if ($errors->has('comment'))
	                            <span class="invalid-feedback" role="alert">
	                                <strong>{{ $errors->first('comment') }}</strong>
	                            </span>
	                        @endif
						</div>
						<div class="input-rating">
							<span>Your Rating: </span>
							<div class="stars form-group {{ $errors->has('rating') ? 'is-invalid' : '' }}">
								<input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
								<input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
								<input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
								<input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
								<input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
								@if ($errors->has('rating'))
	                                <span class="invalid-feedback" role="alert">
	                                    <strong>{{ $errors->first('rating') }}</strong>
	                                </span>
	                            @endif
							</div>
						</div>
						<button class="btn btn-primary" type="submit">Submit</button>
					</form>
				</div>
				<!-- /Review Form -->
	   		</div>

	   		{{-- <div id="reply-update-form" class="reply-form-wrap" style="display: none;">
	   			<h3 class="pane-title">Update Reply</h3>
				<form id="" class="reply-form text-right" method="POST" action="{{route('update.reply')}}">
                    @csrf
					<input type="hidden" name="customer_id" value="{{$customer->id}}">
					<input type="hidden" name="review_id" value="">
					<input type="hidden" name="id" value="">
					<div class="form-group">
						<textarea class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" placeholder="Your Reply" required></textarea>&nbsp;
						@if ($errors->has('comment'))
	                        <span class="invalid-feedback" role="alert">
	                            <strong>{{ $errors->first('comment') }}</strong>
	                        </span>
	                    @endif
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Update</button>
					</div>
				</form>
			</div> --}}
   		</div>
   	</div>
</div>