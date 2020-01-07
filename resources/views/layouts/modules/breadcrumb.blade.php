
@php
  $lastValue = end($page['breadcrumb']);
  $lastKey = key($page['breadcrumb']);
@endphp
<!-- Breadcrumps -->
<section id="breadcrumb" style="background-image: url('{{asset("resource/img/shop/cover/cover-img-1.jpg")}}');">
	<div class="overlay">
		<div class="section_title wow animated fadeInDown text-center" data-wow-duration=".5s" data-wow-delay=".5s">
			<p class="h4">{{$page['title']}}</p>
			<img class="img-fluid" src="{{asset('resource/img/icons/underline.png')}}" alt="Underline Decoration">
		</div>
		<nav aria-label="breadcrumb" >

		  	<ol class="breadcrumb justify-content-center animated fadeInLeft slow" data-wow-duration="1s" data-wow-delay="1s">
		  		{{-- <li>You are here: </li>&nbsp; --}}
		  		@foreach ($page['breadcrumb'] as $title => $route)
		  			@if ($lastKey === $title)
                		<li class="breadcrumb-item active">{{$title}}</li>
              		@else
			    		<li class="breadcrumb-item"><a href="{{$route}}">{{$title}}</a></li>
			    	@endif
		  		@endforeach
		  	</ol>
		</nav>
	</div>
</section>
<!-- End Breadcrumps -->
