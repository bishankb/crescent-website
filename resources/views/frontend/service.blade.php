@extends('layouts.frontend')

@section('content')
	<section class="banner-area relative" id="home">	
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						Services			
					</h1>	
					<p class="text-white link-nav">
						<a href="{{ route('frontend.home') }}">Home </a> 
						<span class="lnr lnr-arrow-right"></span>Services
					</p>
				</div>											
			</div>
		</div>
	</section>

	<section class="service-area service-page-service section-gap" id="service">
		<div class="container">
			<div class="row d-flex justify-content-center">
				<div class="menu-content pb-40 col-lg-8">
					<div class="title text-center">
						<h1 class="mb-10">Our Offered Services</h1>
						<p>Our passion for what we do transfers into our services.</p>
					</div>
				</div>
			</div>						
			<div class="row">
				@foreach($services as $service)
					<div class="col-lg-4">
						<div class="single-service">
							<div class="thumb">
								<img class="img-fluid" src="@isset($service->image->filename) /storage/media/service/{{$service->image->filename}} @endisset" alt="">
							</div>
							<div class="detail">
								<h4>{{ $service->title }}</h4>
								<p>
									{{ $service->description}}
								</p>
							</div>
						</div>
					</div>
				@endforeach																
			</div>
		</div>	
	</section>
@endsection