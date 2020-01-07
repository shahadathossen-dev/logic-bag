
<div class="dropdown-menu mx-auto megamenu" id="megamenu" aria-labelledby="megamenuDropdown">
	<div class="row row_height_control">
  		<div class="col-md-9 row">
	    	@foreach ($categories as $category)
	    	<!-- .col-md-3  -->
	  		<div class="col-md-3 col-sm-6 border-right">
	    		<div class="megamenu_child">
	    			<a class="dropdown-link" href="{{route('shop.products.category.subcategory', ['category' => str_slug($category->title), 'subcategory' => 'all'])}}">
		  				<h6 class="title text-uppercase">
		  					{{$category->title}}
		  				</h6>
		  			</a>
	        		<ul class="nav flex-column sub_menu">
	        			@foreach ($category->subcategories as $subcategory)
	        			<li class="dropdown-item" data-target="bags"><a class="dropdown-link" href="{{route('shop.products.category.subcategory', ['category' => str_slug($category->title), 'subcategory' => str_slug($subcategory->title)])}}">{{$subcategory->title}}</a></li>
	        			@endforeach
		                
		            </ul>
	  			</div>
	      	</div>
	    	<!-- /.col-md-3  -->
	    	@endforeach
      	</div>

      	<div class="col-md-3 col-sm-6">
    		@include('layouts.modules.nav-slider')
  		</div>
  	<!-- /.col-md-3  -->
	</div>
  	<!--  /.row  -->
</div>