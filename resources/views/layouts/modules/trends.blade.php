@php
	$trendItems = App\Models\Product::published()->whereHas('wish')->withCount('wish')            // Count the errors
								    ->orderBy('wish_count', 'desc')   // Order by the error count
								    ->take(5)                           // Take the first 5
								    ->get();
	if (count($trendItems) < 4) {
		$trendItems = App\Models\Product::published()->withCount('wish')         // Count the errors
								    ->orderBy('wish_count', 'desc')   // Order by the error count
									->join('metas', 'products.model', '=', 'metas.model')->orderBy('metas.views', 'desc')
								    ->take(5)                           // Take the first 5
								    ->get();
	}
@endphp
<!-- Trends -->
<section id="trends" class="parallax-window clear" data-parallax="scroll"  data-image-src="{{asset('resource/img/bgs/trends_background.jpg')}}">
	<div class="trends">
		<div class="container">
			<div class="row">
				
				<!-- Trends Content -->
				<div class="col-md-3">
					<div class="trends_container">
						<h2 class="trends_title">Trends {{date('Y')}}</h2>
						<div class="trends_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing Donec et.</p></div>
						<div class="trends_slider_nav">
							<div class="trends_prev trends_nav"><i class="fa fa-angle-left ml-auto"></i></div>
							<div class="trends_next trends_nav"><i class="fa fa-angle-right ml-auto"></i></div>
						</div>
					</div>
				</div>

				<!-- Trends Slider -->
				<div class="col-md-9">
					<div class="trends_slider_container">
						<!-- Trends Slider -->
						<div class="owl-carousel owl-theme trends_slider">
							@foreach ($trendItems as $product)
							<!-- Trends Slider Item -->
							<div class="l_product_item">
	                            <div class="product-thumbnail
	                            @if($product->hasDiscount())
	                            	{{ 'has_discount' }}
	                            @elseif($product->isNew())
	                            	{{ 'is_new' }}
	                            @elseif($product->isHot())
	                            	{{ 'is_hot' }}
	                            @elseif($product->isOnSale())
	                            	{{ 'on_sale' }}
	                            @else
	                             	{{''}}
	                            @endif">
		                            <div class="l_p_img front">
                        				<img src="{{asset('/public/storage/backend/products/'.$product->model.'/'.$product->attributeFirst()->sku.'/medium/'.$product->attributeFirst()->images[0])}}" alt="Not Found">
		                            </div>

		                            <div class="l_p_img back">
                        				<img src="{{asset('/public/storage/backend/products/'.$product->model.'/'.$product->attributeFirst()->sku.'/medium/'.$product->attributeFirst()->images[1])}}" alt="Not Found">
		                            </div>

									<ul class="item_marks">
										@if ($product->hasDiscount())
										<li class="item_mark item_discount">
											{{'-'.($product->discount->amount*100).'%'}}
										</li><span class="waves blue width55"></span>
										@else
										<li class="item_mark{{--  waves blue --}}
											@if($product->isNew())
												{{'item_new'}}
											@elseif($product->isHot())
												{{'item_hot'}}
											@elseif($product->isOnSale())
												{{'item_sale'}}
											@else
												{{''}}
											@endif">
											{{$product->feature->name}}
										</li><span class="waves blue width55"></span>
										@endif
									</ul>

									<div class="product-overlay">
		                            	<a id="quick-show-modal" class="quick-view" data-toggle="modal" href="{{route('view.product', ['category' => str_slug($product->category->title), 'subcategory' => str_slug($product->subcategory->title), 'product' => $product->model, 'slug' => $product->meta->slug, 'color' => str_slug($product->attributeFirst()->color)])}}">
				                    		Quick View
				                    	</a>
										<a href="{{route('view.product', ['category' => str_slug($product->category->title), 'subcategory' => str_slug($product->subcategory->title), 'product' => $product->model, 'slug' => $product->meta->slug, 'color' => str_slug($product->attributeFirst()->color)])}}" class="view-details">View Details</a>
		                            </div>
	                        	</div>
	                            <div class="l_p_text">
	                               <ul>
	                                    <li class="p_icon">
	                                    	<a class="compare-btn" href="{{route('compare.item.add', ['model' => $product->model])}}">
	                                    		<i class="fas fa-chart-pie"></i>
	                                    	</a>
	                                    </li>

                            			<li>
                            				<a class="cart-btn" href="{{route('cart.item.add', ['model' => $product->model, 'sku' => $product->attributeFirst()->sku, 'color' => str_slug($product->attributeFirst()->color)])}}">
                            					<i class="fa fa-shopping-cart"></i>
                            				</a>
                            			</li>

	                                    <li class="p_icon">
	                                    	<a class="wish-btn" href="{{route('wish.item.add', ['product' => $product->model, 'attribute' => $product->attributeFirst()->sku, 'color' => str_slug($product->attributeFirst()->color)])}}">
	                                    		<i class="fa fa-heart"></i>
	                                    	</a>
	                                    </li>
	                                </ul>
	                                <h4 class="product-name">{{$product->title}}</h4>
									@if($product->hasDiscount())
	                                	<h5><del>{{'BDT '.number_format($product->price, 2)}}</del> BDT {{number_format($product->absolutePrice(), 2)}}</h5>
	                                @else
	                                	<h5>BDT {{number_format($product->price, 2)}}</h5>
	                            	@endif
	                            </div>
	                        </div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Trends -->