@php
	$favProducts = App\Models\Product::published()->whereHas('wish')->withCount('wish')->orderBy('wish_count', 'desc')->get()->take(5);
	if (count($favProducts) < 4) {
		$favProducts = App\Models\Product::published()->get()->take(5);
	}
@endphp
<div class="megamenu_child nav_slide_container mx-auto">
	<h6 class="title text-uppercase"><i class="fa fa-space-shuttle"></i> New Arrival</h6>
	<div id="nav_dropdown_carousel" class="carousel slide nav_slider" data-ride="carousel">
	  	<ol class="carousel-indicators slide_indicator">
	  		@php $active = 'active'; $counter = 0; @endphp
	  		@foreach ($favProducts as $product)
		    <li data-target="#nav_dropdown_carousel" data-slide-to="{{$counter}}" class="{{$active}}"></li>
		    @php $active = ''; $counter++; @endphp
	  		@endforeach
	  	</ol>
	  	<div class="carousel-inner">
		    @php $active = 'active'; @endphp
	  		@foreach ($favProducts as $product)
		    <div class="carousel-item text-center {{$active}}">
		      	<img class="d-block w-100" src="{{asset('/public/storage/backend/products/'.$product->model.'/'.$product->attributeFirst()->sku.'/medium/'.$product->attributeFirst()->images[0])}}" alt="">
		      	<a class="btn btn-success cart-btn" href="{{route('cart.item.add', ['model' => $product->model, 'sku' => $product->attributeFirst()->sku])}}" type="button"><i class="fa fa-shopping-cart"></i> {{$product->price}}/-</a>
		      	<button class="btn btn-default wish-btn" type="button"><i class="fa fa-heart"></i> Wishlist</button>
		    </div>
		    @php $active = ''; @endphp
	  		@endforeach
	  	</div>
	</div>
</div>