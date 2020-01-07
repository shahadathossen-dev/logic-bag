@php
    $discountedItems = App\Models\Product::has('wish')->withCount('wish')
									->get()
									->sortByDesc('wish_count')
									->take(10);
@endphp
<!-- Featured Product Area -->
<section id="featured-product">
    <div class="container-fluid">
        <div class="f_p_inner">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                	@include('layouts.modules.feature-slider')
                </div>
                <div class="col-md-8 col-lg-9">
                    <div class="fillter_slider_inner">
                        <ul class="portfolio_filter">
                            <li class="active" data-filter="*"><a href="#">Featured</a></li>
                            <li data-filter=".woman"><a href="#">On Sale</a></li>
                            <li data-filter=".shoes"><a href="#">Best Rated</a></li>
                            <li data-filter=".bags"><a href="#">Bags</a></li>
                        </ul>
                    	<div class="fillter_slider owl-carousel">
	                        <div class="l_product_item woman">
	                            <div class="product-thumbnail">
		                            <div class="l_p_img front">
		                                <img src="resource/img/featured-product/l-product-3.jpg" alt="">
		                            </div>
		                            <div class="l_p_img back">
		                                <img src="resource/img/featured-product/l-product-1.jpg" alt="">
		                            </div>
									
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">New</li>
										<li class="item_mark item_hot">Hot</li>
										<li class="item_mark item_sale">Sale</li>
									</ul>

									<div class="product-overlay">
		                            	<span data-id="1669" class="quick-view" data-toggle="modal" data-target="#single-product-modal">
		                            		Quick View
		                            	</span>
										<span data-id="1668" class="view-details">View Details</span>
		                            </div>
	                        	</div>
	                            <div class="l_p_text">
	                               <ul>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-pie-chart"></i></a></li>
	                                    <li><a class="add_cart_btn" href="#"><i class="fa fa-shopping-cart"></i></a></li>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-heart"></i></a></li>
	                                </ul>
	                                <h4 class="product-name">Summer Dress</h4>
	                                <h5>$45.05</h5>
	                            </div>
	                        </div>
	                        <div class="l_product_item shoes">
	                            <div class="product-thumbnail is_new">
		                            <div class="l_p_img front">
		                                <img src="resource/img/featured-product/l-product-8.jpg" alt="">
		                            </div>
		                            <div class="l_p_img back">
		                                <img src="resource/img/featured-product/l-product-5.jpg" alt="">
		                            </div>
									
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">New</li>
										<li class="item_mark item_hot">Hot</li>
										<li class="item_mark item_sale">Sale</li>
									</ul>

									<div class="product-overlay">
		                            	<span data-id="1669" class="quick-view" data-toggle="modal" data-target="#single-product-modal">
		                            		Quick View
		                            	</span>
										<span data-id="1668" class="view-details">View Details</span>
		                            </div>
	                        	</div>
	                            <div class="l_p_text">
	                               <ul>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-pie-chart"></i></a></li>
	                                    <li><a class="add_cart_btn" href="#"><i class="fa fa-shopping-cart"></i></a></li>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-heart"></i></a></li>
	                                </ul>
	                                <h4 class="product-name">Ricky Shirt</h4>
	                                <h5>$45.05</h5>
	                            </div>
	                        </div>
	                        <div class="l_product_item woman">
	                            <div class="product-thumbnail">
		                            <div class="l_p_img front">
		                                <img src="resource/img/featured-product/l-product-6.jpg" alt="">
		                            </div>
		                            <div class="l_p_img back">
		                                <img src="resource/img/featured-product/l-product-2.jpg" alt="">
		                            </div>
									
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">New</li>
										<li class="item_mark item_hot">Hot</li>
										<li class="item_mark item_sale">Sale</li>
									</ul>

									<div class="product-overlay">
		                            	<span data-id="1669" class="quick-view" data-toggle="modal" data-target="#single-product-modal">
		                            		Quick View
		                            	</span>
										<span data-id="1668" class="view-details">View Details</span>
		                            </div>
	                        	</div>

	                            <div class="l_p_text">
	                               <ul>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-pie-chart"></i></a></li>
	                                    <li><a class="add_cart_btn" href="#"><i class="fa fa-shopping-cart"></i></a></li>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-heart"></i></a></li>
	                                </ul>
	                                <h4 class="product-name">High Heel</h4>
	                                <h5><del>$130.50</del>  $110</h5>
	                            </div>
	                        </div>
	                        <div class="l_product_item shoes">
	                            <div class="product-thumbnail on_sale">
		                            <div class="l_p_img front">
		                                <img src="resource/img/featured-product/l-product-7.jpg" alt="">
		                            </div>
		                            <div class="l_p_img back">
		                                <img src="resource/img/featured-product/l-product-4.jpg" alt="">
		                            </div>
									
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">New</li>
										<li class="item_mark item_hot">Hot</li>
										<li class="item_mark item_sale">Sale</li>
									</ul>

									<div class="product-overlay">
		                            	<span data-id="1669" class="quick-view" data-toggle="modal" data-target="#single-product-modal">
		                            		Quick View
		                            	</span>
										<span data-id="1668" class="view-details">View Details</span>
		                            </div>
	                        	</div>
	                            <div class="l_p_text">
	                               <ul>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-pie-chart"></i></a></li>
	                                    <li><a class="add_cart_btn" href="#"><i class="fa fa-shopping-cart"></i></a></li>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-heart"></i></a></li>
	                                </ul>
	                                <h4 class="product-name">Fossil Watch</h4>
	                                <h5>$250.00</h5>
	                            </div>
	                        </div>
	                        <div class="l_product_item bags">
	                        	<div class="product-thumbnail">
		                            <div class="l_p_img front">
		                                <img src="resource/img/featured-product/l-product-2.jpg" alt="">
		                            </div>
		                            <div class="l_p_img back">
		                                <img src="resource/img/featured-product/l-product-3.jpg" alt="">
		                            </div>
									
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">New</li>
										<li class="item_mark item_hot">Hot</li>
										<li class="item_mark item_sale">Sale</li>
									</ul>

									<div class="product-overlay">
		                            	<span data-id="1669" class="quick-view" data-toggle="modal" data-target="#single-product-modal">
		                            		Quick View
		                            	</span>
										<span data-id="1668" class="view-details">View Details</span>
		                            </div>
	                        	</div>
	                            <div class="l_p_text">
	                               <ul>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-pie-chart"></i></a></li>
	                                    <li><a class="add_cart_btn" href="#"><i class="fa fa-shopping-cart"></i></a></li>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-heart"></i></a></li>
	                                </ul>
	                                <h4 class="product-name">Travel Bags</h4>
	                                <h5><del>$45.50</del>  $40</h5>
	                            </div>
	                        </div>
	                        <div class="l_product_item woman">
	                        	<div class="product-thumbnail has_discount">
		                            <div class="l_p_img front">
		                                <img src="resource/img/featured-product/l-product-1.jpg" alt="">
		                            </div>
		                            <div class="l_p_img back">
		                                <img src="resource/img/featured-product/l-product-2.jpg" alt="">
		                            </div>

									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">New</li>
										<li class="item_mark item_hot">Hot</li>
										<li class="item_mark item_sale">Sale</li>
									</ul>

		                            <div class="product-overlay">
		                            	<span data-id="1669" class="quick-view" data-toggle="modal" data-target="#single-product-modal">
		                            		Quick View
		                            	</span>
										<span data-id="1668" class="view-details">View Details</span>
		                            </div>
	                            </div>
	                            <div class="l_p_text">
	                                <ul>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-pie-chart"></i></a></li>
	                                    <li><a class="add_cart_btn" href="#"><i class="fa fa-shopping-cart"></i></a></li>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-heart"></i></a></li>
	                                </ul>
	                                <h4 class="product-name">Womens Libero</h4>
	                                <h5><del>$45.50</del>  $40</h5>
	                            </div>
                            </div>
	                        <div class="l_product_item bags">
	                        	<div class="product-thumbnail">
	                        		<div class="l_p_img front">
		                                <img src="resource/img/featured-product/l-product-2.jpg" alt="">
		                            </div>
		                            <div class="l_p_img back">
		                                <img src="resource/img/featured-product/l-product-4.jpg" alt="">
		                            </div>
									
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">New</li>
										<li class="item_mark item_hot">Hot</li>
										<li class="item_mark item_sale">Sale</li>
									</ul>

									<div class="product-overlay">
		                            	<span data-id="1669" class="quick-view" data-toggle="modal" data-target="#single-product-modal">
		                            		Quick View
		                            	</span>
										<span data-id="1668" class="view-details">View Details</span>
		                            </div>

	                        	</div>
								
	                            <div class="l_p_text">
	                               <ul>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-pie-chart"></i></a></li>
	                                    <li><a class="add_cart_btn" href="#"><i class="fa fa-shopping-cart"></i></a></li>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-heart"></i></a></li>
	                                </ul>
	                                <h4 class="product-name">Oxford Shirt</h4>
	                                <h5>$85.50</h5>
	                            </div>
	                        </div>
	                        <div class="l_product_item bags">
	                            <div class="product-thumbnail is_hot">
		                            <div class="l_p_img front">
		                                <img src="resource/img/featured-product/l-product-4.jpg" alt="">
		                            </div>
		                            <div class="l_p_img back">
		                                <img src="resource/img/featured-product/l-product-6.jpg" alt="">
		                            </div>
									
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">New</li>
										<li class="item_mark item_hot">Hot</li>
										<li class="item_mark item_sale">Sale</li>
									</ul>

									<div class="product-overlay">
		                            	<span data-id="1669" class="quick-view" data-toggle="modal" data-target="#single-product-modal">
		                            		Quick View
		                            	</span>
										<span data-id="1668" class="view-details">View Details</span>
		                            </div>
	                        	</div>
	                            <div class="l_p_text">
	                               <ul>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-pie-chart"></i></a></li>
	                                    <li><a class="add_cart_btn" href="#"><i class="fa fa-shopping-cart"></i></a></li>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-heart"></i></a></li>
	                                </ul>
	                                <h4 class="product-name">Nike Shoes</h4>
	                                <h5><del>$130</del> $110</h5>
	                            </div>
	                        </div>
	                        <div class="l_product_item bags">
	                        	<div class="product-thumbnail">
		                            <div class="l_p_img front">
		                                <img src="resource/img/featured-product/l-product-1.jpg" alt="">
		                            </div>
		                            <div class="l_p_img back">
		                                <img src="resource/img/featured-product/l-product-2.jpg" alt="">
		                            </div>

		                            <div class="product-overlay">
		                            	<span data-id="1669" class="quick-view" data-toggle="modal" data-target="#single-product-modal">
		                            		Quick View
		                            	</span>
										<span data-id="1668" class="view-details">View Details</span>
		                            </div>
	                            </div>
	                            <div class="l_p_text">
	                                <ul>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-pie-chart"></i></a></li>
	                                    <li><a class="add_cart_btn" href="#"><i class="fa fa-shopping-cart"></i></a></li>
	                                    <li class="p_icon"><a href="#"><i class="fa fa-heart"></i></a></li>
	                                </ul>
	                                <h4 class="product-name">Womens Libero</h4>
	                                <h5><del>$45.50</del>  $40</h5>
	                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Featured Product Area -->