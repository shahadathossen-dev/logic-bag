@php
	$sliders = App\Models\Frontend\Pages\Slider::all();
	$counter = 0;
	$active = 'active';
@endphp

<!-- Home Slider -->
<section id="slider-section">
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	  	<ol class="carousel-indicators">
		    @foreach ($sliders as $slider)
			    <li data-target="#carouselExampleIndicators" data-slide-to="{{$counter}}" class="{{$active}}"></li>

		    @php 
		    	if ($counter != count($sliders)-1) {
		    		$active = '';
		    	} else {
		    		$active = 'active';
					$counter = 0;
		    	}
		    	$counter++; 
	    	@endphp
		    @endforeach
	  	</ol>
	  	<div class="carousel-inner">
		    <!-- parallax-master  -->
		    @foreach ($sliders as $slider)
			    <div class="carousel-item {{$active}}">
			      	<img class="d-block w-100" src="{{asset('/public/storage/backend/sliders/original/'.$slider->image)}}" alt="First slide">
			      	<div class="carousel-caption wow animated fadeInUp" data-wow-offset="10" data-wow-delay="1s">
					    <div class="container-fluid">
				   			<div class="row">
					   			<div class="col-sm-6">
					   				<div class="slider-text-inner">
					   					<div class="desc desc-{{$counter}} text-center">
			      							<img class="d-block w-100" src="{{asset('/public/storage/backend/products/'.$slider->item->model.'/'.$slider->item->attributeFirst()->sku.'/medium/'.$slider->item->attributeFirst()->images[0])}}" alt="">
						   					<a href="{{route('view.product', ['category' => str_slug($slider->item->category->title), 'subcategory' => str_slug($slider->item->subcategory->title), '$slider->item' => $slider->item->model, 'slug' => $slider->item->meta->slug, 'color' => str_slug($slider->item->attributeFirst()->color)])}}" class="btn btn-primary wow animated fadeInLeft" data-wow-delay="2s">Shop Collection</a>
					   					</div>
					   				</div>
					   			</div>
					   		</div>
				   		</div>
				  	</div>
			    </div>
		    @php $active = ''; $counter++; @endphp
		    @endforeach
	  	</div>
	  	<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
	    	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    	<span class="sr-only">Previous</span>
	  	</a>
	  	<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		    <span class="carousel-control-next-icon" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
	  	</a>
	</div>
</section>
<!-- End Home Slider -->