@extends('layouts.frontend')

@section('content')
	<section class="banner-area relative" id="home">	
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						Blogs				
					</h1>	
					<p class="text-white link-nav">
						<a href="{{ route('frontend.home') }}">Home </a> 
						<span class="lnr lnr-arrow-right"></span>Blogs
					</p>
				</div>											
			</div>
		</div>
	</section>

	<section class="blog-posts-area section-gap">
		<div class="container">
			<div class="row">

				@yield('blog-content')

				<div class="col-lg-4 sidebar">
					<div class="single-widget search-widget">
						<form class="example" action="{{route('frontend.blog')}}" style="margin:auto;max-width:300px">
						  <input type="text" placeholder="Search Blogs" name="search_blog">
						  <button type="submit"><i class="fa fa-search"></i></button>
						</form>								
					</div>
					<div class="single-widget category-widget">
						<h4 class="title">Categories</h4>
						<ul>
							@foreach($categories as $category)
								<li>
									<a href="{{ route('frontend.blog.category', $category->slug)}}" class="justify-content-between align-items-center d-flex">
										<h6>{{ $category->title }}</h6> <span>{{ $category->blogs->count() }}</span>
									</a>
								</li>
							@endforeach
						</ul>
					</div>	

					<div class="single-widget tags-widget">
						<h4 class="title">Tags</h4>
						 <ul>
						 	@foreach($tags as $tag)
							 	<li>
							 		<a href="{{ route('frontend.blog.tag', $tag->slug)}}">{{ $tag->title }}</a>
							 	</li>
							@endforeach
						 </ul>
					</div>				

				</div>
			</div>
		</div>	
	</section>
@endsection