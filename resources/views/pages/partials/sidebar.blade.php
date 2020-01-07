<div class="sidebar">
	<div class="section-title">
		<h5>Product Filter</h5>
	</div>
	<div class="fancy-collapse-panel">
		<div class="panel-group" id="accordion">
		  	<div class="card">
			    <div class="card-header" id="categories-card">
			    	<h4 class="card-title">
                        <a class="" data-filter="" data-toggle="collapse" href="#category-panel" data-parent="#accordion" data-target="#category-panel" aria-expanded="true" aria-controls="category-panel">Categories
                        </a>
                    </h4>
			    </div>

			    <div id="category-panel" class="collapse show" aria-labelledby="categories-card" data-parent="#accordion">
				    <div class="card-body">
                 		<ul class="categories">
                         	<li class="category
                            @if (Request::is('shop') || Request::is('shop/products/search*') || Request::is('shop/tag/products/*'))
                                {{'active'}}
                            @endif" data-category="all"><a href="{{route('shop')}}">All</a></li>
							@foreach ($categories as $category)
                         	<li class="category {{(Request::is('shop/products/'.str_slug($category->title).'/*') ? 'active' : '')}}" data-category="{{str_slug($category->title)}}">
                         		<a href="{{route('shop.products.category.subcategory', ['category' => strtolower($category->title), 'subcategory' => 'all'])}}">
                         			{{$category->title}}
                         		</a>
                         	</li>
                 			@endforeach
                        </ul>
				    </div>
			    </div>
		  	</div>
		</div>
	</div>
	<div class="fancy-collapse-panel">
		<div class="panel-group" id="accordion">
		  	<div class="card">
			    <div class="card-header" id="subcategories-card">
			    	<h4 class="card-title">
                        <a class="" data-filter="" data-toggle="collapse" href="#subcategories-panel" data-parent="#accordion" data-target="#subcategories-panel" aria-expanded="true" aria-controls="subcategories-panel">Subcategories
                        </a>
                    </h4>
			    </div>

			    <div id="subcategories-panel" class="collapse show" aria-labelledby="subcategories-card" data-parent="#accordion">
				    <div class="card-body">
                 		<ul class="subcategories">
                         	
                        </ul>
				    </div>
			    </div>
		  	</div>
		</div>
	</div>
</div>
<div class="sidebar">
	<div class="section-title">
		<h5>Price Search</h5>
	</div>
	<form method="POST" action="{{route('shop.products.price.search')}}" id="price-search">
		@csrf
      	<div class="row">
        	<div class="col-md-6 form-group">
                <label for="minimum">Price from:</label>
              	<select name="minimum" class="nice-select" id="minimum">
                    <option value="200">200</option>
                    <option value="500">500</option>
                    <option value="800">800</option>
                    <option value="1000">1000</option>
                    <option value="1500">1500</option>
                    <option value="2000">2000</option>
                </select>
        	</div>
        	<div class="col-md-6 form-group">
        		<label for="maximum">Price to:</label>
      			<select name="maximum" class="nice-select" id="maximum">
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                    <option value="1500">1500</option>
                    <option value="2000">2000</option>
                    <option value="3000">3000</option>
                    <option value="5000">5000</option>
              	</select>
        	</div>
      	</div>
    	<div class="col-md-12 form-group">
  			<input id="search" type="submit" value="Search" class="btn btn-primary btn-block form-control">
    	</div>
	</form>
</div>

