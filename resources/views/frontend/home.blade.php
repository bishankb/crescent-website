@extends('layouts.frontend')

@section('content')
	<section class="banner-area relative" id="home">
		<div class="overlay overlay-bg"></div>	
		<div class="container">
			<div class="row fullscreen d-flex align-items-center justify-content-start">
				<div class="banner-content col-lg-9">
					<h1 class="text-white">
						Crescent Engineering Consultancy				
					</h1>
					<p class="pt-20 text-white justify">
						We are a creative group of planning, design, civil and IT project management professionals. We are committed to resolve complexity and realize opportunity in the way clients and partners develop the world. 
					</p>
					<p class=" pb-20 text-white justify">
						With a sharp sense of purpose we take clients from inspiration – through conceptualization – to the realization of design and project delivery in the built environment.
					</p>
					<a href="#" class="primary-btn text-uppercase">Read More</a>
				</div>											
			</div>
		</div>					
	</section>

	<section class="feature-area section-gap" id="feature">
		<div class="container">
			<div class="row d-flex justify-content-center">
				<div class="col-md-8 pb-40 header-text">
					<h1>Some Features that Makes us Unique</h1>
					<p>
						Standing out from the crowd
					</p>
				</div>
			</div>
			<div class="row">
				@foreach($features as $feature)
					<div class="col-lg-4 col-md-6">
						<div class="single-feature">
							<h4>{!! $feature->feature_icon !!}</span>{{ $feature->title }}</h4>
							<p>
								{{ $feature->description }}
							</p>
						</div>
					</div>
				@endforeach				
			</div>
		</div>	
	</section>

	@if(count($blogs) > 0)
		<section class="blog-area section-gap" id="blog">
			<div class="container">
				<div class="row d-flex justify-content-center">
					<div class="menu-content pb-40 col-lg-8">
						<div class="title text-center">
							<h1 class="mb-10">Latest From Our Blog</h1>
							<p>Some of our blogs are</p>
						</div>
					</div>
				</div>					
				<div class="row">
					@foreach($blogs as $blog)
						<div class="col-lg-3 col-md-6 single-blog">
							<div class="thumb">
								<img class="img-fluid" src="@isset($blog->image->filename) /storage/media/blog/{{$blog->image->filename}} @endisset" alt="" style="height: 180px; object-fit: cover;">
							</div>
							<p class="date">{{ $blog->created_at->format('d M Y') }}</p>
							<a href="{{ route('frontend.blog.show', $blog->slug) }}"><h4>{{ str_limit($blog->title, $limit = 50, $end = '...') }}</h4></a>
							<p>
								{!! str_limit($blog->description, $limit = 100, $end = '...') !!}
							</p>								
						</div>
					@endforeach						
				</div>
			</div>	
		</section>
	@endisset
@endsection