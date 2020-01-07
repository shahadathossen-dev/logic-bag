@php
    $page['breadcrumb'] =   [
            'Home' => route('welcome'),
            'Product Details' => route('user.compare.table'),
        ];
    $page['title'] = 'Product Details';
	$keywordsArray = [$product->title, $product->model];
    $tags = $product->tags;
	foreach ($tags as $tag) {
		$keywordsArray[] = $tag->name;
		$keywords = implode(', ', $keywordsArray);
	}
@endphp

@extends('layouts.default')

@section('page_subtitle')
{{$page['title']}}
@endsection

@section('meta_keywords')
{{$keywords}}
@endsection

@section('meta_description')
{{$product->meta->description}}
@endsection

@section('content')

@include('layouts.modules.preloader')
@include('layouts.modules.breadcrumb')
@if($product)

<!-- Product Details Area -->
<section id="product">
    <div class="container">
    	<section class="product-upper">
    		<div class="row justify-content-md-center">
		      	<div class="col-sm-6 col-lg-4">
					<div class="quick-view-gallery">
      					@if ($attribute)
							<div class="quick-view-main-gallery">
								<span class="product-gallery-trigger" title="View full page">
									<i class="fas fa-expand"></i>
								{{-- <span class="gallery-title">
									Gallery
								</span> --}}
								</span>
									
									<!-- <img id="thumb" src="resource/img/p-categories-list/product-l-1.jpg" alt="" data-large-img-url="resource/img/p-categories-list/product-l-1.jpg" data-large-img-wrapper="preview"> -->
								<img class="image-popup" src="{{asset('/public/storage/backend/products/'.$attribute->product->model.'/'.$attribute->sku.'/original/'.$attribute->images[0])}}" alt="{{ucfirst($attribute->images[0])}}" title="{{ucfirst($attribute->images[0])}}" data-mfp-src="{{asset('/public/storage/backend/products/'.$attribute->product->model.'/'.$attribute->sku.'/original/'.$attribute->images[0])}}"/>

								<!-- Preloader -->
								<div id="pd-loader-wrapper">
								    <div id="pd-loader"></div>
								</div>
								<!-- End Preloader -->
							</div>

								<div class="quick_view_slider_container">
								<!-- Image Slider -->
								<div class="owl-carousel quick_view_slider">
									<!-- Image Slider Item -->
									@foreach ($attribute->images as $image)
									@php
										$nameArray = explode('.', $image);
										$name = array_shift($nameArray);
									@endphp
									<div class="quick-item-img">
										<img class="" title="{{$name.' image'}}" src="{{asset('/public/storage/backend/products/'.$attribute->product->model.'/'.$attribute->sku.'/thumbnail/'.$image)}}" data-mfp-src="{{asset('/public/storage/backend/products/'.$attribute->product->model.'/'.$attribute->sku.'/original/'.$image)}}" alt="{{$name.' image'}}">
							  		</div>
									@endforeach
							  	</div>
							  	<!-- Quick Slider Navigation -->
								<div class="quick_nav quick_prev"><i class="fa fa-chevron-left"></i></div>
								<div class="quick_nav quick_next"><i class="fa fa-chevron-right"></i></div>
							</div>
						@endif
					</div>
			      	<hr>
					<div class="product-meta">
						<table>
							<tr class="">
								<td class="col-group-1">
									<span class="meta-title">Category</span>       
								</td>
								<td>
									: <span class="meta-desc category"><a class="dropdown-link" href="{{route('shop.products.category.subcategory', ['category' => str_slug($product->category->title), 'subcategory' => 'all'])}}">{{$product->category->title}}</a></span>
								</td>
							</tr>
							<tr class="">
								<td class="col-group-1">
									<span class="meta-title">Tags</span>
								</td>
								<td>
									: <span class="meta-desc tags">
										@foreach($product->tags as $tag)
										<a href="{{route('shop.products.tag', ['name' => str_slug($tag->name)])}}"><span class="bg-info elevation-2 round-label">{{$tag->name}}</span></a>
										@endforeach
									 </span>
								</td>
							</tr>
						</table>
					</div>
					<hr>
						<div class="share-links-wrapper mr-auto">
			      			<span class="title">Share this: </span>
			      			<div class="share-links">
			      				<a class="share-facebook share-link" href="http://www.facebook.com/sharer.php?m2w&s=100&p[url]=http://velikorodnov.com/wordpress/flatastic/classic/product/women-skirts-flowers/&p[images][0]=http://velikorodnov.com/wordpress/flatastic/classic/wp-content/uploads/2014/12/23_111.jpg&p[title]=Women skirts flowers" target="_blank" title="Facebook">
			      					<i class="fab fa-facebook-square"></i>
			      				</a>
			      				<a class="share-twitter share-link" href="https://twitter.com/intent/tweet?text=Women skirts flowers&url=http://velikorodnov.com/wordpress/flatastic/classic/product/women-skirts-flowers/" target="_blank" title="Twitter"><i class="fab fa-twitter-square"></i></a>
			      				<a class="share-googleplus share-link" href="https://plus.google.com/share?url=http://velikorodnov.com/wordpress/flatastic/classic/product/women-skirts-flowers/" target="_blank" title="Google +"><i class="fab fa-google-plus-square"></i></a>
			      				<a class="share-linkedin share-link" href="https://www.linkedin.com/shareArticle?mini=true&url=http://velikorodnov.com/wordpress/flatastic/classic/product/women-skirts-flowers/&title=Women skirts flowers" target="_blank" title="Linkedin"><i class="fab fa-linkedin"></i></a>
			      				<a class="share-pinterest share-link" href="https://pinterest.com/pin/create/link/?url=http://velikorodnov.com/wordpress/flatastic/classic/product/women-skirts-flowers/&media=http://velikorodnov.com/wordpress/flatastic/classic/wp-content/uploads/2014/12/23_111.jpg" target="_blank" title="Pinterest"><i class="fab fa-pinterest-square"></i></a>
			      			</div>
			      		</div>
		      	</div>
		      	<div class="col-sm-6 col-lg-6 single-product-summary">
		      		{{-- <div id="preview" style=" position: absolute; width: 200px; height: 200px;"></div> --}}

					<div class="summary entry-summary">
						<h1 itemprop="name" class="product_title entry-title">
							{{$product->title}}
						</h1>
						<div class="rating_r
						@if (is_float($product->ratingAverage()))
							@if ($product->ratingAverage() > 1 && $product->ratingAverage() < 2)
								{{'rating_r_1_plus'}}
							@elseif ($product->ratingAverage() > 2 && $product->ratingAverage() < 3)
								{{'rating_r_2_plus'}}
							@elseif ($product->ratingAverage() > 3 && $product->ratingAverage() < 4)
								{{'rating_r_3_plus'}}
							@elseif ($product->ratingAverage() > 4 && $product->ratingAverage() < 5)
								{{'rating_r_4_plus'}}
							@endif
						@else
				            @if($product->ratingAverage() == 1)
				                {{'rating_r_1'}}
				            @elseif($product->ratingAverage() == 2)
				                {{'rating_r_2'}}
				            @elseif($product->ratingAverage() == 3)
				                {{'rating_r_3'}}
				            @elseif($product->ratingAverage() == 4)
				                {{'rating_r_4'}}
				            @elseif($product->ratingAverage() == 5)
				              {{'rating_r_5'}}
				            @endif
						@endif
						banner_2_rating">
							<i></i><i></i><i></i><i></i><i></i>
							(@if (count($product->reviews) > 1)
								{{count($product->reviews)}} Customer reviews
							@else
								{{count($product->reviews)}} Customer review
							@endif)
						</div>
						<hr>

						<section class="product-section">
							<div class="product-meta">
								<table>
									<tr>
										<td class="col-group-1">
											<span class="meta-title">Sold By</span>
										</td>
										<td>
											: <span class="owner">Logic Bag</span>
										</td>
									</tr>
									
									<tr class="model_wrapper">
										<td class="col-group-1">
											<span class="meta-title">Model</span>
										</td>
										<td>
											: <span class="model">{{$product->model}}</span>
										</td>
									</tr>
									<tr class="stock_wrapper">
										<td class="col-group-1">
											<span class="meta-title">Availability</span>       
										</td>
										<td>
											: <span class="stock
											@if ($attribute->stock > 10)
												{{'in-stock'}}
											@endif">
											@if ($attribute->stock > 0)
												{{$attribute->stock}} in stock
											@else
												{{'Out of Stock'}}											
											@endif
											</span>
										</td>
									</tr>
									<tr>
										<td class="col-group-1">
											Price
										</td>
										<td class="price h5"> : <span class="currencySymbol">BDT</span>
											<span class="amount">{{$product->price}}</span>
										</td>
									</tr>
								</table>
							</div><!--/ .product_meta-->
						</section><!--/ .product-section-->

						<section class="attribute-section">
							<form action="{{ route('store.cart.item') }}" method="POST" class="add-cart-form">
								@csrf
								<input type="hidden" id="model" name="model" value="{{$product->model}}">
								<table>
									<tr class="sku_wrapper">
										<td class="col-group-1">
											<span class="meta-title">SKU</span>
										</td>
										<td>
											: <span class="sku">{{$attribute->sku}}</span>
										</td>
									</tr>
									<tr>
										<td class="col-group-1">
											Color
										</td>
										<td>
											<div class="form-group mb-0">
												<div class="colors">
													@php $checked = 'checked'; @endphp
													@foreach ($product->attributes as $productAttribute)
													<div class="single-color">
														
														<input type="radio" name="sku" value="{{$productAttribute->sku}}" {{$checked}} id="{{$productAttribute->sku}}"
														@if ($attribute->sku == $productAttribute->sku)
															{{'checked'}}
														@endif>
													    <label for="{{$productAttribute->sku}}">
													      <span class="color" style="background: {{$productAttribute->meta_color}};">
													      </span>
													    </label>
												    </div>
													@php $checked = ''; @endphp
													@endforeach
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td class="col-group-1">
											Quantity
										</td>
										<td>
											<div class="form-group mb-0">
												<div class="input-group">
			                                    	<span class="input-group-btn">
				                                       	<button class="quantity-left-minus btn" onclick="var result = document.getElementById('quantity'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 1 ) result.value--;return false;">
				                                          <i class="fa fa-minus"></i>
				                                       	</button>
			                                   		</span>
			                                    	<input type="text" id="quantity" name="quantity" class="input-number" value="1" min="1" max="100">
			                                    	<span class="input-group-btn">
				                                       	<button class="quantity-right-plus btn" onclick="var result = document.getElementById('quantity'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;">
				                                            <i class="fas fa-plus"></i>
				                                        </button>
			                                    	</span>
			                                 	</div>
		                                 	</div>
										</td>
									</tr>
								</table>
								<div class="product-action">
									<div class="form-group mb-0">
										<div class="input-group">
											<button type="submit" role="button" class="btn btn-success p_icon add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button> &nbsp;
		                                    <a href="{{route('wish.item.add', ['product' => $product->model, 'attribute' => $attribute->sku, 'color' => str_slug($attribute->color)])}}" class="btn btn-primary p_icon wish-btn"><i class="fa fa-heart"></i></a> &nbsp;
		                                    <a href="{{route('compare.item.add', ['model' => $product->model])}}" class="btn btn-warning compare-btn"><i class="fa fa-chart-pie"></i></a>
										</div>
									</div>
								</div>
							</form>
						</section>
						<hr>
						<section class="product-meta">
							<div class="product-short-description">
								<p class="short-description">{{$product->meta->description}}</p>
							</div>						
						</section><!--/ .product-section-->
					</div><!-- .summary -->
				</div><!--/ .single-product-summary-->
        	</div>
    	</section>

        <hr>

    	<section class="product-bottom">
            <div class="row justify-content-md-center">
				<div class="col-lg-10">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="jute" aria-selected="false">Reviews</a>
					  	</li>
						<li class="nav-item">
							<a class="nav-link" id="specificatoins-tab" data-toggle="tab" href="#specificatoins" role="tab" aria-controls="jute" aria-selected="false">Specificatoins</a>
					  	</li>
					  	<li class="nav-item">
							<a class="nav-link" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="leather" aria-selected="true">Description</a>
					  	</li>
					  	
					</ul>
					
					<div class="tab-content">

						@include('pages.partials.review-tab')

			         	<div id="specificatoins" class="tab-pane fade" role="tabpanel" aria-labelledby="specificatoins-tab">
			         		<table id="product" class="table table-bordered table-striped mb-3">
                                <thead>
                                    <tr>
                                        <th class="text-right" width="20%">Property</th>
                                        <th width="80%">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><th class="text-right">{{ 'Title' }}</th><td>{{ $product['title'] }}</td></tr>
                                    <tr><th class="text-right">{{ 'Model' }}</th><td>{{ $product['model'] }}</td></tr>
                                    <tr><th class="text-right">{{ 'Category' }}</th><td>{{ $product->category->title }}</td></tr>
                                    <tr><th class="text-right">{{ 'Subcategory' }}</th><td>{{ $product->subcategory->title }}</td></tr>
                                    <tr><th class="text-right">{{ 'Material' }}</th><td>{{ $product['material'] }}</td></tr>
                                    <tr><th class="text-right">{{ 'Dimension' }}</th><td>{{ implode(' x ', explode(',', $product->dimension)) }}</td></tr>
                                    <tr><th class="text-right">{{ 'Weight' }}</th><td>{{ number_format((float)$product->weight, 3, '.', '')." kg" }}</td></tr>
                                    <tr><th class="text-right">{{ 'Chamber' }}</th><td>{{ $product['chamber'] }}</td></tr>
                                    <tr><th class="text-right">{{ 'Pockets' }}</th><td>{{ $product['pockets'] }}</td></tr>

                                    @if ($product->hasDiscount())
                                    <tr><th class="text-right">{{ 'Discount' }}</th><td>{{($product->discount->discount*100)}}%</td></tr>
                                    @endif

                                    @if ($product->hasFeature())
                                    <tr><th class="text-right">{{ 'Feature' }}</th><td><span class="elevation-2 round-label
                                    	@if($product->isFeatured() || $product->isTopRated()){{'bg-success'}}@elseif($product->isNew()){{'bg-primary'}}@elseif($product->isHot()){{'bg-danger'}}@elseif($product->isOnSale()){{'bg-warning'}}@endif">{{($product->feature->name)}}</span></td>
                                    </tr>

                                    <tr><th class="text-right">{{ 'Tags' }}</th>
                                        <td class="meta-desc">
                                        	@foreach($product->tags as $tag)
											<a href="#"><span class="bg-info elevation-2 round-label">{{$tag->name}}</span></a>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
					   </div>

						<div id="description" class="tab-pane" role="tabpanel" aria-labelledby="description-tab">
							@php
								echo $product->description;
							@endphp
			         	</div>

		         	</div>
				</div>
			</div>
    	</section>
    </div>
</section>
<!-- End Featured Product Area -->
@endif
@include('layouts.modules.recent')
@include('layouts.modules.characteristics')
@include('layouts.modules.newsletter')

@endsection