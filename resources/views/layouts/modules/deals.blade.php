@php
	$stock = 0;
	$counter = 0;
	$active = 'active';
	$lastWeek = Illuminate\Support\Carbon::now()->subDays(7);
    $dealsItems = App\Models\Product::whereHas('order_item', function($query) use ($lastWeek){
    									$query->whereDate('created_at', '>=', $lastWeek);
    								})->withCount('order_item')  // Count the orders
                                    ->orderBy('order_item_count', 'desc')   // Order by the order_item count
                                    ->orderBy('created_at', 'desc')   // Order by the order_time count
                                    ->take(3)->published()    // Take the first 5
                                    ->get();
                                    
    if (count($dealsItems) < 4) {
        $dealsItems = App\Models\Product::published()->withCount('order_item')  // Count the orders
                                    ->orderBy('order_item_count', 'desc')   // Order by the order_item count
                                    ->orderBy('created_at', 'desc')   // Order by the order_time count
                                    ->join('metas', 'products.model', '=', 'metas.model')->orderBy('metas.views', 'desc')
                                    ->take(3)    // Take the first 5
                                    ->get();
    }

	$offers = App\Models\Frontend\Offer::all()->sortByDesc('sold')->take(3);
@endphp
<div class="col-md-4 col-lg-3">
	<div class="deals">
		<div class="deals_title">Deals of the Week</div>
		<div class="deals_slider_container">
			<!-- Deals Slider -->
			<div class="owl-carousel owl-theme deals_slider">	
				@foreach ($dealsItems as $product)
				<!-- Deals Item -->
				<div class="deals_item">
					<div class="deals_image">
						<img class="img-fluid" src="{{asset('/public/storage/backend/products/'.$product->model.'/'.$product->attributeFirst()['sku'].'/thumbnail/'.$product->attributeFirst()['images'][0])}}" alt="{{$product->attributeFirst()['images'][0].' image'}}">
					</div>
					<div class="deals_content">
						<div class="deals_info_line d-flex flex-row justify-content-start">
							<div class="deals_item_category"><a href="#">{{'Previous Price'}}</a></div>
							<div class="deals_item_price_a ml-auto"><strike>{{'BDT '.number_format($product->price, 2)}}</strike></div>
						</div>
						<div class="deals_info_line d-flex flex-row justify-content-start">
							<div class="deals_item_name">{{'Offer Price'}}</div>
							<div class="deals_item_price ml-auto">{{'BDT '.number_format($product->absolutePrice(), 2)}}</div>
						</div>
						<div class="available">
							<div class="available_line d-flex flex-row justify-content-start">
								<div class="available_title">Available: <span>
									@php
										foreach ($product->attributes as $attribute) {
									        $stock += $attribute->stock;
									    }
								        echo $stock;
									@endphp</span></div>
								<div class="sold_title ml-auto">Already sold: <span>{{$product->report->sales}}</span></div>
							</div>
							<div class="progress">
							  	<div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						@if ($product->hasOffer())
						<div class="deals_timer d-flex flex-row align-items-center justify-content-start">
							<div class="deals_timer_title_container">
								<div class="deals_timer_title">Hurry Up</div>
								<div class="deals_timer_subtitle">Offer ends in:</div>
							</div>
							<div class="deals_timer_content ml-auto">
								<div class="deals_timer_box clearfix" data-target-time="@php
                                        echo Carbon\Carbon::parse($offer->expiry_date)->format('M d, Y');
                                    @endphp">
									<div class="deals_timer_unit">
										<div id="deals_timer1_hr" class="deals_timer_hr"></div>
										<span>hours</span>
									</div>
									<div class="deals_timer_unit">
										<div id="deals_timer1_min" class="deals_timer_min"></div>
										<span>mins</span>
									</div>
									<div class="deals_timer_unit">
										<div id="deals_timer1_sec" class="deals_timer_sec"></div>
										<span>secs</span>
									</div>
								</div>
							</div>
						</div>
						@endif
					</div>
				</div>
				@endforeach						
			</div>
		</div>
		<div class="deals_slider_nav_container">
			<div class="deals_slider_prev deals_slider_nav"><i class="fa fa-chevron-left ml-auto"></i></div>
			<div class="deals_slider_next deals_slider_nav"><i class="fa fa-chevron-right ml-auto"></i></div>
		</div>
	</div>
</div>