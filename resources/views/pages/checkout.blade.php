
@php
    $page['breadcrumb'] =   [
            'Home' => route('welcome'),
            'Check Out' => route('order.checkout'),
        ];
    $page['title'] = 'Check Out';
    $subTotal = 0;
    $deliveryFee = 0;
@endphp
@extends('layouts.default')

@section('page_subtitle')
    {{$page['title']}}
@endsection

@section('meta_description')
We are introducing “Logic Manufacturing Co.” is one of the leading Bag & different IT related accessories manufacturers in Bangladesh. Logic Manufacturing Co. realizes that in order to achieve our mission and long-term goals, we must meet the needs of our valued customers and provide a safe and secure work environment for our working family. Logic is totally committed to being a company whose integrity and quality for service is unsurpassed in the bag & different IT related accessories industry. As a leading innovator in the design of computer carrying cases and travel bags, our mission is to provide travelers with more than just stylish and reliable bags. We strive for excellence and are passionate in our efforts to continue to shape and define the market for traveling bags. We aspire to be the best, focusing on the needs of travelers and producing solutions that meet their standards.
@endsection

@section('content')

@include('layouts.modules.preloader')
@include('layouts.modules.breadcrumb')
@if($cart)
<!-- Check out Area -->
<section id="checkout">
	<form action="{{route('order.place')}}" method="POST">
        @csrf
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 bg-light">
        			<!-- Billing Details -->
					<div class="billing-details">
						<div class="section-title">
							<h5 class="title">Billing address</h5>
						</div>

						<div class="row">
                            <div class="col-md-6 ">
								<div class="form-group">
									<input required class="form-control form-control-sm {{ $errors->has('bill-fname') ? ' is-invalid' : '' }}" type="text" name="bill-fname" placeholder="First Name">
									@if ($errors->has('bill-fname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bill-fname') }}</strong>
                                        </span>
                                    @endif
								</div>
							</div>
                            <div class="col-md-6 ">
								<div class="form-group">
									<input required class="form-control form-control-sm {{ $errors->has('bill-lname') ? ' is-invalid' : '' }}" type="text" name="bill-lname" placeholder="Last Name">
									@if ($errors->has('bill-lname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bill-lname') }}</strong>
                                        </span>
                                    @endif
								</div>
							</div>
                            <div class="col-12 ">
								<div class="form-group">
									<input required class="form-control form-control-sm {{ $errors->has('bill-email') ? ' is-invalid' : '' }}" type="email" name="bill-email" placeholder="Email">
									@if ($errors->has('bill-email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bill-email') }}</strong>
                                        </span>
                                    @endif
								</div>
							</div>
                            <div class="col-12 ">
								<div class="form-group">
									<input required class="form-control form-control-sm {{ $errors->has('bill-address') ? ' is-invalid' : '' }}" type="text" name="bill-address" placeholder="Address">
									@if ($errors->has('bill-address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bill-address') }}</strong>
                                        </span>
                                    @endif
								</div>
							</div>
                            <div class="col-12 ">
								<div class="form-group">
									<input required class="form-control form-control-sm {{ $errors->has('bill-union') ? ' is-invalid' : '' }}" type="text" name="bill-union" placeholder="Union/Thana">
									@if ($errors->has('bill-union'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bill-union') }}</strong>
                                        </span>
                                    @endif
								</div>
							</div>
							<div class="col-12 ">
								<div class="form-group">
									<input required class="form-control form-control-sm {{ $errors->has('bill-zipcode') ? ' is-invalid' : '' }}" type="text" name="bill-zipcode" placeholder="ZIP Code">
									@if ($errors->has('bill-zipcode'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bill-zipcode') }}</strong>
                                        </span>
                                    @endif
								</div>
							</div>
							<div class="col-12 ">
								<div class="form-group">
									<input required class="form-control form-control-sm {{ $errors->has('bill-city') ? ' is-invalid' : '' }}" type="text" name="bill-city" placeholder="City">
									@if ($errors->has('bill-city'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bill-city') }}</strong>
                                        </span>
                                    @endif
								</div>
							</div>
                            <div class="col-12 ">
								<div class="form-group">
									<input required class="form-control form-control-sm {{ $errors->has('bill-country') ? ' is-invalid' : '' }}" type="text" name="bill-country" placeholder="Country">
									@if ($errors->has('bill-country'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bill-country') }}</strong>
                                        </span>
                                    @endif
								</div>
							</div>
                            <div class="col-12 ">
								<div class="form-group">
									<input type="tel" class="form-control form-control-sm {{ $errors->has('bill-phone') ? ' is-invalid' : '' }} {{ $errors->has('bill-phone') ? ' is-invalid' : '' }}" name="bill-phone" pattern="[0-9]{5}-[0-9]{6}" placeholder="01xxx-xxxxxx" required>
									@if ($errors->has('bill-phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bill-phone') }}</strong>
                                        </span>
                                    @endif
								</div>
							</div>
                            <div class="col-md-6">
								<div class="form-group mb-0">
									<input type="hidden" name="ship" value="0">
									<input type="checkbox" checked="false" name="ship" value="1" role="button" id="shiping-address" data-toggle="collapse" data-target="#shipping-address" aria-expanded="false" aria-controls="collapseExample">
									<label for="shiping-address">
										<span></span>
										Ship to a diffrent address?
									</label>
								</div>
							</div>
						</div>
					</div>
					<!-- /Billing Details -->

					<!-- Shiping Details -->
					<div class="shiping-details">
						<div class="collapse" id="shipping-address">
							<div class="card-header">
								<div class="section-title">
									<h5 class="title">Shiping address</h5>
								</div>
							</div>
					  		<div class="card card-body bg-light">
								<div class="row">
		                            <div class="col-md-6 ">
										<div class="form-group">
											<input class="form-control form-control-sm {{ $errors->has('ship-fname') ? ' is-invalid' : '' }}" type="text" name="ship-fname" placeholder="First Name">
											@if ($errors->has('ship-fname'))
				                                <span class="invalid-feedback" role="alert">
				                                    <strong>{{ $errors->first('ship-fname') }}</strong>
				                                </span>
				                            @endif
										</div>
									</div>
		                            <div class="col-md-6 ">
										<div class="form-group">
											<input class="form-control form-control-sm {{ $errors->has('ship-lname') ? ' is-invalid' : '' }}" type="text" name="ship-lname" placeholder="Last Name">
											@if ($errors->has('ship-lname'))
				                                <span class="invalid-feedback" role="alert">
				                                    <strong>{{ $errors->first('ship-lname') }}</strong>
				                                </span>
				                            @endif
										</div>
									</div>
	                                <div class="col-12 ">
										<div class="form-group">
											<input class="form-control form-control-sm {{ $errors->has('ship-email') ? ' is-invalid' : '' }}" type="email" name="ship-email" placeholder="Email">
											@if ($errors->has('ship-email'))
				                                <span class="invalid-feedback" role="alert">
				                                    <strong>{{ $errors->first('ship-email') }}</strong>
				                                </span>
				                            @endif
										</div>
									</div>
	                                <div class="col-12 ">
										<div class="form-group">
											<input class="form-control form-control-sm {{ $errors->has('ship-address') ? ' is-invalid' : '' }}" type="text" name="ship-address" placeholder="Address">
											@if ($errors->has('ship-address'))
				                                <span class="invalid-feedback" role="alert">
				                                    <strong>{{ $errors->first('ship-address') }}</strong>
				                                </span>
				                            @endif
										</div>
									</div>
									<div class="col-12 ">
										<div class="form-group">
											<input class="form-control form-control-sm {{ $errors->has('ship-union') ? ' is-invalid' : '' }}" type="text" name="ship-union" placeholder="Union/Thana">
											@if ($errors->has('ship-union'))
				                                <span class="invalid-feedback" role="alert">
				                                    <strong>{{ $errors->first('ship-union') }}</strong>
				                                </span>
				                            @endif
										</div>
									</div>
									<div class="col-12 ">
										<div class="form-group">
											<input class="form-control form-control-sm {{ $errors->has('ship-zipcode') ? ' is-invalid' : '' }}" type="text" name="ship-zipcode" placeholder="ZIP Code">
											@if ($errors->has('ship-zipcode'))
				                                <span class="invalid-feedback" role="alert">
				                                    <strong>{{ $errors->first('ship-zipcode') }}</strong>
				                                </span>
				                            @endif
										</div>
									</div>
	                                <div class="col-12 ">
										<div class="form-group">
											<input class="form-control form-control-sm {{ $errors->has('ship-city') ? ' is-invalid' : '' }}" type="text" name="ship-city" placeholder="City">
											@if ($errors->has('ship-city'))
				                                <span class="invalid-feedback" role="alert">
				                                    <strong>{{ $errors->first('ship-city') }}</strong>
				                                </span>
				                            @endif
										</div>
									</div>
	                                <div class="col-12 ">
										<div class="form-group">
											<input class="form-control form-control-sm {{ $errors->has('ship-country') ? ' is-invalid' : '' }}" type="text" name="ship-country" placeholder="Country">
											@if ($errors->has('ship-country'))
				                                <span class="invalid-feedback" role="alert">
				                                    <strong>{{ $errors->first('ship-country') }}</strong>
				                                </span>
				                            @endif
										</div>
									</div>
	                                
	                                <div class="col-12 ">
										<div class="form-group">
											<input type="tel" class="form-control form-control-sm {{ $errors->has('ship-phone') ? ' is-invalid' : '' }}" name="ship-phone" pattern="[0-9]{5}-[0-9]{6}" placeholder="01xxx-xxxxxx">
											@if ($errors->has('ship-phone'))
				                                <span class="invalid-feedback" role="alert">
				                                    <strong>{{ $errors->first('ship-phone') }}</strong>
				                                </span>
				                            @endif
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Shiping Details -->

					<!-- Order notes -->
                    <!-- <div class="col-12 "> -->
					<div class="order-notes">
						<div class="form-group">
							<textarea class="form-control form-control-sm" name="note" placeholder="Order Notes"></textarea>
							@if ($errors->has('note'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('note') }}</strong>
                                </span>
                            @endif
						</div>
					</div>
					<!-- </div> -->
					<!-- /Order notes -->
                </div>
                <div class="col-sm-6">
                    <div class="order-details-confirmation">
						<div class="section-title">
                    		<h5>Your Order Details</h5>
                    	</div>
                        <div class="order-summary">
	                    	<table class="table table-striped">
	                    		<colgroup>
	                    			<col class="title"></col>
	                    			<col class="amount"></col>
	                    		</colgroup>
	                    		<thead>
	                    			
	                    		</thead>
	                    		<tbody>
	                    			<tr>
	                    				<th>Items</th>
	                    				<th>Color</th>
                                    	<th>Quantity</th>
	                    				<th class="text-right">Price (BDT)</th>
	                    			</tr>

									@foreach($cart as $model => $productModel)
                                	@foreach($productModel as $sku => $item)
	                    			<tr>
	                    				<th>{{$item->title}}</th>
	                    				<td>{{$item->attribute['color']}}</td>
	                    				<td>{{$item->quantity}}</td>
	                    				<td class="text-right">{{number_format($item->price, 2)}}</td>
	                    			</tr>
	                    			@php
	                                    $subTotal += ($item->quantity * $item->price);
	                                    $deliveryFee += ($item->quantity * 100);
	                                @endphp
									@endforeach
									@endforeach
	                    			<tr>
	                    				<th>Subtotal</th>
	                    				<th class="text-right" colspan="3">{{number_format($subTotal, 2)}}</th>
	                    			</tr>

	                    			<tr>
	                    				<th>Delivery</th>
	                    				<th class="text-right" colspan="3">
	                    					@if ($deliveryFee > 0)
		                                        {{number_format($deliveryFee, 2)}}
		                                    @else
		                                        {{'Free'}}
		                                    @endif
		                                </th>
	                    			</tr>
	                    			<tr>
	                    				<th>Total</th>
	                    				<th class="text-right" colspan="3">{{number_format($subTotal, 2)}}</th>
	                    			</tr>
	                    		</tbody>
	                    	</table>
	                    </div>
                        <div class="payment-mode" id="accordion" role="tablist" class="mb-2">
                        	<div class="form-group mb-0">
                        		@foreach (App\Models\Orders\PaymentMethod::all() as $payment)
	                            <div class="card">
	                                <div class="card-header" role="tab" id="{{str_slug($payment->mode)}}">
	                            		<input type="radio" {{str_slug($payment->mode) == "cash-on-delivery" ? 'checked' : 'disabled'}} name="payment-mode" value="{{$payment->id}}" data-toggle="collapse" data-target="#{{str_slug($payment->mode)}}-panel" aria-expanded="false" aria-controls="{{str_slug($payment->mode)}}-panel">
										<label for="ppl">
											<span></span>
	                                    	<h6>
												{{$payment->mode}}
	                                    	</h6>
										</label>
	                                </div>

	                                <div id="{{str_slug($payment->mode)}}-panel" class="collapse" role="tabpanel" aria-labelledby="{{str_slug($payment->mode)}}" data-parent="#accordion">
	                                    <div class="card-body">
	                                        <p>{{$payment->description}}</p>
	                                    </div>
	                                </div>
	                            </div>
                        		@endforeach
	                        </div>
                        </div>
                    	<div class="form-group mb-0">
	                        <div class="input-checkbox">
								<input type="hidden" class="form-control form-control-sm" name="offer_id" value="">
								<input type="checkbox" name="agree" value="agree" id="terms" required>
								<label for="terms">
									<span></span>
									I've read and accept the <a href="#">terms & conditions</a>
								</label>
							</div>
						</div>
                        <button type="submit" class="btn btn-success form-control" value="Place Order">Place Order</button>
                    </div>
                </div>
	        </div>
        </div>
    </form>
</section>
<!-- End Check out Area -->
@endif
@include('layouts.modules.recent')
@include('layouts.modules.characteristics')
@include('layouts.modules.newsletter')

@endsection