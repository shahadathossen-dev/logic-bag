
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
