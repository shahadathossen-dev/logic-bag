	
	<!-- jQuery -->
	<script type="text/javascript" src="{{asset('vendor/jquery/jquery-3.2.1.min.js')}}"></script>

	<!-- bootstrap -->
	<script type="text/javascript" src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>

	<!-- Images Loaded -->
	<script type="text/javascript" src="{{asset('vendor/imagesloaded/imagesloaded.pkgd.js')}}"></script>

	<!-- WOW Master -->
	<script type="text/javascript" src="{{asset('vendor/wow-master/wow.js')}}"></script>

	<!-- Parallax Master -->
	<script type="text/javascript" src="{{asset('vendor/parallax/parallax.js')}}"></script>

	<!-- Owl Carousel -->
	<script type="text/javascript" src="{{asset('vendor/owlcarousel/js/owl.carousel.js')}}"></script>
	
	<!-- Isotope -->
	<script type="text/javascript" src="{{asset('vendor/isotope/isotope.pkgd.min.js')}}"></script>
	
	<!-- Image Zoom -->
	<script type="text/javascript" src="{{asset('vendor/zoom-master/jquery.zoom.js')}}"></script>

	<!-- Magnifi Popup Master -->
	<script type="text/javascript" src="{{asset('vendor/magnific-popup-master/js/jquery.magnific-popup.js')}}"></script>
	
	<!-- Magnifier Js -->
	<script type="text/javascript" src="{{asset('vendor/magnifier/js/magnifier.js')}}"></script>
	<script type="text/javascript" src="{{asset('vendor/magnifier/js/event.js')}}"></script>

	<!-- Jquery Nice Select -->
	<script type="text/javascript" src="{{asset('vendor/nice-select/js/jquery.nice-select.min.js')}}"></script>
	
	<!-- Sweet Alert -->
	<script type="text/javascript" src="{{asset('backend/plugins/sweetalert/sweetalert2.min.js')}}"></script>
	@include('sweet::alert')

	<script type="text/javascript">
		
		// $('.add_cart_btn').each(function(){
		// 	var productName = $(this).parent().parent().parent().find('h4').html();
		// 	$(this).on('click', function(event){
		// 		event.preventDefault();
		// 		swal(productName, "is added to cart !", "success");
		// 	});
		// });

		// $('.add-to-cart').each(function(){
		// 	var productName = $('.entry-summary .entry-title > a').html();
		// 	$(this).on('click', function(event){
		// 		event.preventDefault();
		// 		swal(productName, "is added to cart !", "success");
		// 	});
		// });

		// $('.block2-btn-addwishlist').each(function(){
		// 	var productName = $(this).parent().parent().parent().find('.block2-name').html();
		// 	$(this).on('click', function(){
		// 		swal(productName, "is added to wishlist !", "success");
		// 	});
		// });
	</script>

	<!-- Custom script -->
	<script type="text/javascript" src="{{asset('js/main.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/custom.js')}}"></script>


	</body>
</html>