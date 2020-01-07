<!-- Footer -->
<footer class="footer">
	<div class="container">
		<div class="row">

			<div class="col-md-4 footer-left">
				<div class="logo_container">
					<div class="logo"><a href="#">Logic Bag</a></div>
				</div>
				<div class="footer_column footer_contact">
					<div class="footer_title">Got Question? Call Us 24/7</div>
					<div class="footer_phone"><i class="topbar-social-item fa fa-phone"></i> +880-1847-277630</div>
					<div class="footer_contact_text">
						<p>124/A, Chowrangi Bhaban (4th floor),</p>
						<p> New Elephant Road, Dhaka-1205</p>
					</div>
					<div class="footer_social">
						<ul>
							<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#"><i class="fab fa-youtube"></i></a></li>
							<li><a href="#"><i class="fab fa-google"></i></a></li>
							<li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="col-md-8">
				<div class="footer-right">
					<div class="row">
						<div class="col footer-menu">
							<h3>Who We Are</h3>
							<ul>
								<li><a href="{{route('contact-us')}}">About Us</a></li>
								<li><a href="#">Delivery Information</a></li>
								<li><a href="#">Terms & Conditions</a></li>
								<li><a href="#">Returns & Refunds</a></li>					 
							</ul>
						</div>
						<div class="col footer-menu">
							<h3>Customer Service</h3>
							<ul>
								<li><a href="#">Our Branches</a></li>
								<li><a href="contact.html">Help Center</a></li>
								<li><a href="contact.html">Newsletter</a></li>
								<li><a href="#">Careers</a></li>					 
							</ul>
						</div>
						<div class="col footer-menu last">
							<h3>Your Account</h3>
							<ul>
								<li><a href="#">Personal Information</a></li>
								<li><a href="{{ route('user.wishes') }}">Your Wishlist</a></li>
								<li><a href="{{route('contact-us')}}">Addresses</a></li>
								<li><a href="#">Gift Vouchers</a></li>
								<li><a href="#">Track your order</a></li>					 					 
							</ul>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</footer>
<!-- End Footer -->

<!-- Scroll to Top -->
	<a href="#" id="scroll-top" class="btn btn-default smooth-scroll" title="Home" role="button">
		<i class="fa fa-angle-up fa-3x"></i>
	</a>
<!-- End Scroll to Top -->

<!-- Copyright -->
<div class="copyright">
	<div class="container">
		<div class="row">
			<div class="col">
				
				<div class="copyright_container d-flex flex-sm-row flex-column align-items-center justify-content-start">
					<div class="copyright_content"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved by Logic bag | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> <a href="https://colorlib.com" target="_blank">Coding Plus</a>
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					</div>
					<div class="logos ml-sm-auto">
						<ul class="logos_list">
							<li><a href="#"><img src="{{asset('resource/img/copyright/logos_1.png')}}" alt=""></a></li>
							<li><a href="#"><img src="{{asset('resource/img/copyright/logos_2.png')}}" alt=""></a></li>
							<li><a href="#"><img src="{{asset('resource/img/copyright/logos_3.png')}}" alt=""></a></li>
							<li><a href="#"><img src="{{asset('resource/img/copyright/logos_4.png')}}" alt=""></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Copyright -->
@include('layouts.modules.scripts')