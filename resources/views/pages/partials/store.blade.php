@php
	if (session('products')) {
		$products = session('products');
	}
@endphp

@if ($products->links())
	@section('pagination')
		{{ $products->links() }}
	@endsection
@endif

<!-- Product Topbar -->
<div class="product-topbar d-flex align-items-center justify-content-between">
	<div class="container">
		<div class="row">
        	<div class="col-md-6">
        		<div class="product-sorting d-flex">
                    <p>Sort by:</p>
                    <form action="#" method="get">
                        <select name="select" class="nice-select" id="sort">
                            <option value="rating desc">Popularity</option>
                            <option value="created desc" selected>Newest</option>
                            <option value="price asc">Lowest - Higher</option>
                            <option value="price desc">Highest - Lower</option>
                        </select>
                        <input type="submit" class="d-none" value="">
                    </form>
                </div>
        	</div>
            <div class="col-md-6">
            	<div class="product-sorting d-flex float-right">
                    <p>Show:</p>
                    <form action="#" method="get">
                        <select name="perpage" class="nice-select" id="perpage">
                            <option value="12">12</option>
                            <option value="16">16</option>
                            <option value="24">24</option>
                            <option value="28">28</option>
                        </select>
                        <input type="submit" class="d-none" value="">
                    </form>
                    <div class="pagination-links">
                    	@if (View::hasSection('pagination'))
                    		@yield('pagination')
                    	@endif
		   			</div>
                </div>
            </div> 
        </div>
	</div>
</div>
<!-- End Product Topbar -->

<!-- Product Desk -->
<div class="parallax parallax-window" data-parallax="scroll" data-image-src="{{asset('resource/img/bgs/featured_bg.jpg')}}">
	<!-- Leather Tab -->
	<div class="products animated slideInRight">
		@if ($products)
		<div class="row no-gutters-lg" id="container">
			@foreach ($products as $product)
			<div class="col-sm-6 col-md-4 col-lg-3 item {{str_slug($product->subcategory->title)}}" data-rating="{{$product->ratingAverage()}}" data-price="{{$product->price}}" data-created="{{$product->created_at}}">
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
	                    	<a id="quick-show-modal" class="quick-view" data-toggle="modal" href="{{route('view.product', ['category' => str_slug($product->category->title), 'subcategory' => str_slug($product->subcategory->title), 'model' => $product->model, 'slug' => $product->meta->slug, 'color' => str_slug($product->attributeFirst()->color)])}}">
	                    		Quick View
	                    	</a>
							<a href="{{route('view.product', ['category' => str_slug($product->category->title), 'subcategory' => str_slug($product->subcategory->title), 'model' => $product->model, 'slug' => $product->meta->slug, 'color' => str_slug($product->attributeFirst()->color)])}}" class="view-details">View Details</a>
	                    </div>
	            	</div>
	                <div class="l_p_text">
	                   <ul>
	                        <li class="p_icon compare-btn"><a href="{{route('compare.item.add', ['model' => $product->model])}}"><i class="fas fa-chart-pie"></i></a></li>
	            			<li><a class="cart-btn" href="{{route('cart.item.add', ['model' => $product->model, 'sku' => $product->attributeFirst()->sku])}}"><i class="fa fa-shopping-cart"></i></a></li>
	                        <li class="p_icon"><a class="wish-btn" href="{{route('wish.item.add', ['product' => $product->model, 'attribute' => $product->attributeFirst()->sku, 'color' => str_slug($product->attributeFirst()->color)])}}"><i class="fa fa-heart"></i></a></li>
	                    </ul>
	                    <h4 class="product-name">{{$product->title}}</h4>
						@if($product->hasDiscount())
	                    	<h5><del>{{'BDT '.number_format($product->price, 2)}}</del>  BDT {{number_format($product->absolutePrice(), 2)}}</h5>
	                    @else
	                    	<h5>BDT {{number_format($product->price, 2)}}</h5>
	                	@endif
	                </div>
	            </div>
	        </div>
			@endforeach
		</div>
		@endif
	</div>
	<!-- Leather Tab -->							

</div>
<!-- End Product Desk -->