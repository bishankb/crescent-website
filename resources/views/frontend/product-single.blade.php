@extends('layouts.frontend')

@section('content')
	<section class="banner-area relative" id="home">	
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						Products			
					</h1>	
					<p class="text-white link-nav">
						<a href="{{ route('frontend.home') }}">Home </a> 
						<span class="lnr lnr-arrow-right"></span>Products
					</p>
				</div>											
			</div>
		</div>
	</section>

	<section class="product-single-area pt-30 pb-50">
		<div class="container">
			<div class="row d-flex justify-content-center">
				<div class="menu-content pb-15 col-lg-8">
					<div class="title text-center">
						<h1 class="mb-10">{{ $product->title }}</h1>
					</div>
				</div>
			</div>
		    <div class="row justify-content-center align-self-center">
				<div class="col-md-9">	
					<p>{{ $product->description }}</p>	
					<div class="product-single row">
			         	<div class="content-wrap col-md-6 product-desc">
						<h3 style="margin-bottom: 12px;">Features</h3>
							{!! $product->features !!}
						</div>
			         	<div class="col-md-5 col-xs-12">
							<img class="img-fluid" src="@isset($product->image->filename) /storage/media/product/{{$product->image->filename}} @endisset" alt="">
						</div>
					</div>		
				</div>
			</div>												
		</div>	
	</section>
@endsection