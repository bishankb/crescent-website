<header id="header" id="home">
	<div class="container">
		<button type="button" id="mobile-nav-toggle"><i class="lnr lnr-menu"></i></button>
		<div class="row align-items-center justify-content-between d-flex">
	      	<div id="logo">
		        <a href="{{route('frontend.home')}}"><img src="{{ asset('images/logo2.png') }}" width="60px" /></a>
	      	</div>
	      	<nav id="nav-menu-container">
		        <ul class="nav-menu">
		            <li class="menu-active"><a href="{{route('frontend.home')}}">Home</a></li>
		            <li><a href="{{route('frontend.about')}}">About</a></li>
		            <li><a href="{{route('frontend.service')}}">Service</a></li>
		            <li><a href="{{route('frontend.blog')}}">Blog</a></li>
		            <li><a href="{{route('frontend.contact-us')}}">Contact Us</a></li>
		        </ul>
	      	</nav>		    		
		</div>
	</div>
</header>