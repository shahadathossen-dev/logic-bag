
<span class="dropdown">
	<a href="#" class="header-wrapicon1 dis-block dropdown-toggle text-uppercase" href="#" id="accountmenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<img src="{{asset('resource/img/icons/icon-header-01.png')}}" class="header-icon1" alt="ICON">
	</a>
	<ul class="dropdown-menu account-menu text-left" aria-labelled-by="accountmenuDropdown">
		
		@guest
			<li class="dropdown-item"><a class="dropdown-link" href="{{ route('login') }}">Login</a></li>
			<li class="dropdown-item"><a class="dropdown-link" href="{{ route('register') }}">Register</a></li>
        @else
        	<li class="dropdown-item"><a class="dropdown-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">Logout</a></li>

        	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

			<li class="dropdown-item"><a class="dropdown-link" href="{{ route('user.order.history') }}">Order History</a></li>
			<li class="dropdown-item"><a class="dropdown-link" href="{{ url('/my-account') }}">My Account</a></li>
			<li class="dropdown-item"><a class="dropdown-link" href="{{ route('user.wishes') }}">Wish List</a></li>
            
		@endguest

		<li class="dropdown-item"><a class="dropdown-link" href="{{route('user.compare.table')}}">Compare Table</a></li>
	</ul>
</span>