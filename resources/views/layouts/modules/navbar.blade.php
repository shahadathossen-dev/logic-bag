
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="http://www.logicbagbd.com"><img src="{{asset('resource/img/icons/logicbag-logo.png')}}" alt="Logic Bag Logo" class="img-fluid"></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	   	<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav mr-auto">
	        <li class="nav-item main_menu {{(Request::is('/') ? 'active' : '')}}">
	            <a class="nav-link text-uppercase" href="/">Home <span class="sr-only">(current)</span></a>
	        </li>
	        
	        <li class="nav-item main_menu {{(Request::is('/shop*') ? 'active' : '')}}">
	            <a class="nav-link text-uppercase" href="/shop">Shop</a>
	        </li>

	        <li class="nav-item dropdown megamenu_parent main_menu">
		        <a class="nav-link dropdown-toggle text-uppercase" href="#" id="megamenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Categories <i class="fa fa-angle-down"></i>
		        </a>
		        @include('layouts.modules.megamenu')
		    </li>

	        <li class="nav-item main_menu {{(Request::is('contact-us') ? 'active' : '')}}">
	            <a class="nav-link text-uppercase" href="{{route('contact-us')}}">Contacts</a>
	        </li>

	        <li class="nav-item main_menu {{(Request::is('about-us') ? 'active' : '')}}">
	            <a class="nav-link text-uppercase" href="{{route('about-us')}}">About Us</a>
	        </li>

	        <li class="nav-item main_menu">
	        	<form class="form-inline" action="{{route('shop.products.search')}}" method="POST" id="search">
	        		@csrf
	        		<div class="input-group">
				      	<input class="form-control mr-sm-2" type="text" placeholder="Type your search" name="keyword" id="keyword" aria-label="Search" autocomplete="off">
	        			<button type="submit" class="btn btn-outline-success">
				      		<i class="fa fa-search" aria-hidden="true"></i>
				      	</button>
	        		</div>
			    </form>
        		<div class="live-search">
			    	<ul class="search-result container">

			    	</ul>
			    </div>

	        </li>
	    </ul>
	    {{-- <div class="form-inline-1">
	    	<form action="{{route('shop.products.search')}}" method="POST" class="form-inline my-2 my-lg-0" id="search">
        		@csrf
		    	<button type="submit" class="btn btn-outline-success">
		      		<i class="fa fa-search" aria-hidden="true"></i>
		      	</button>
		      	<input name="keyword" id="keyword" class="form-control mr-sm-2" type="text" placeholder="Type your search" aria-label="Search">
	    	</form>
	    </div> --}}
	</div>

	<div class="header-icons" role="navigation">

		<span class="linedivide"></span>

		@include('layouts.modules.user-menu')

		<span class="linedivide"></span>

		@include('layouts.modules.cart')

	</div>
</nav>
<!-- End Nav Bar -->
