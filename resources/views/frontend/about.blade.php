@extends('layouts.frontend')

@section('content')
	<section class="banner-area relative" id="home">	
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						About Us				
					</h1>	
					<p class="text-white link-nav">
						<a href="{{ route('frontend.home') }}">Home </a> 
						<span class="lnr lnr-arrow-right"></span>About Us
					</p>
				</div>											
			</div>
		</div>
	</section>
	<section class="about-top-area section-gap">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 about-top-left about-paragrah">
					<h1>
						What we provide?
					</h1>
					<p>
						We believe that new value can be created wherever people, business, and technology collide. We help our clients harness that value through the creation of experiences, products, and services that play a meaningful role in people’s lives. Through human-centered design, we make the complex simple and relatable, no matter what medium or platform.
					</p>
					<p>
						We are determined to provide the best. The best people, the best products, the best services. We challenge old ways of doing things and help others embrace new technology through innovative design – with a relentless focus on best user experience and therefore take the extra step to provide our clients with everything they expect and then some.
					</p>
				</div>
				<div class="col-lg-6 about-top-right">
					<img class="img-fluid" src="{{asset('images/about-image.jpg')}}" alt="">
				</div>
			</div>
		</div>	
	</section>

	<section class="team-area section-gap" id="team">
		<div class="container">
			<div class="row d-flex justify-content-center">
				<div class="menu-content pb-70 col-lg-8">
					<div class="title text-center">
						<h1 class="mb-10">Our Team Members</h1>
						<p>Dedicated - Diligent - Dynamic</p>
					</div>
				</div>
			</div>						
			<div class="row team-member">
				@foreach($users as $user)
					<div class="col-lg-3 col-md-4 single-team">
					    <div class="thumb">
					        <img class="img-fluid" src="@isset($user->profile->image->filename) /storage/media/user/{{$user->profile->image->filename}} @endisset" alt="">
					        <div class="text-center team-contact">
								<h6><i class="fa fa-phone"> {{ $user->profile->phone1 }} </i></h6>
								<h6><i class="fa fa-envelope-o"> {{ $user->email }} </i></h6>
					        </div>
					    </div>
					    <div class="meta-text mt-30 text-center user-detail">
						    <h4>{{ $user->name }}</h4>
						    <p>{{ $user->profile->position }}</p>									    	
						    <p>{{ $user->profile->city }}</p>									    	
					    </div>
					</div>
				@endforeach																							
			</div>
		</div>	
	</section>

	<section class="product-area section-gap" id="product">
		<div class="container">
			<div class="row d-flex justify-content-center">
				<div class="menu-content pb-40 col-lg-8">
					<div class="title text-center">
						<h1 class="mb-10">Products</h1>
						<p>From members of our team.</p>
					</div>
				</div>
			</div>						
			<div class="row">
				@foreach($products as $product)
					<div class="col-lg-4">
						<div class="single-product">
							<a href="{{ route('frontend.product.show', $product->slug) }}">
								<div class="thumb">
									<img class="img-fluid" src="@isset($product->image->filename) /storage/media/product/{{$product->image->filename}} @endisset" alt="">
								</div>
								<div class="detail">
									<h4>{{ $product->title }}</h4>
								</div>
							</a>
						</div>
					</div>
				@endforeach
			</div>
		</div>	
	</section>
@endsection