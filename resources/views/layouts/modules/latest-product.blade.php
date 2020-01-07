
<!-- Latest Products -->
<section id="latest-product">
	<div class="container-fluid">
		<div class="latest-product-inner">
			<div class="section_title wow animated fadeInDown text-center" data-wow-duration="1s" data-wow-delay=".5s">
				<p class="h3">Hot New Arrivals</p>
				<img class="img-fluid" src="{{asset('resource/img/icons/underline.png')}}" alt="Underline Decoration">
			</div>
			<div class="row">
				@include('layouts.modules.deals')
				@php
					$active = 'active';
					$showTab = 'show active';
			        $products_by_category = App\Models\Product::published()->get()
			            ->map(function ($product) {
			                return ['product' => $product, 'category' => $product->category->title];
			            })
			            ->groupBy('category')
			            ->sortByDesc('created_at');

			        $categories_products = [];

			        foreach ($products_by_category as $index => $category_products) {
			            $categories_products[$index] = $category_products->chunk(2);
			        }
				@endphp
				<div class="col-md-8 col-lg-9">
					@if (count($categories_products) > 0)
					<div class="latest-product">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							@foreach ($categories_products as $category => $category_products)
						  	<li class="nav-item">
								<a 
								class="nav-link {{$active}}"
						  		id="{{str_slug($category).'-tab'}}"
						  		data-toggle="tab" href="{{'#'.str_slug($category)}}"
						  		role="tab" aria-controls="{{str_slug($category)}}"
						  		aria-selected="true"
						  		>
						  			{{$category}}
						  		</a>
						  	</li>
							@php $active = '' @endphp
						  	@endforeach
						</ul>

						<div class="fixed-background" style="background-image:url('{{asset('resource/img/bgs/featured_bg.jpg')}}');">
							<div class="tab-content">
								@foreach ($categories_products as $category => $category_products)
								<!-- Product Tab -->
							  	<div
							  		class="tab-pane fade {{$showTab}}" id="{{str_slug($category)}}"
							  		role="tabpanel"
							  		aria-labelledby="{{str_slug($category).'-tab'}}"
						  		>
									<div class="row no-gutters">
										<div class="l_product_slider owl-carousel">
											@foreach ($category_products as $products_pair)
											<div class="col">
							                	<div class="item">
													@foreach($products_pair as $value)
													@php
														$product = $value['product'];
													@endphp
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
																	{{'-'.($product->discount->discount*100).'%'}}
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
            								@endforeach
										</div>
									</div>
							  	</div>
								<!-- Leather Tab -->
								@php $showTab = ''; @endphp
								@endforeach
							</div>
						</div>
					</div>
					@endif									
				</div>
			</div>
		</div>
	</div>		
</section>
<!-- End Latest Products -->

