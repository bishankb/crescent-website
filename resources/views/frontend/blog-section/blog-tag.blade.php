@extends('frontend.blog-section.blog-layout')

@section('blog-content')
	<div class="col-lg-8 post-list blog-post-list">
		<h2 class="header">
			<i class="fa fa-tags"></i> 
			{{ $tag_title }}
		</h2>
		@foreach($blogs as $blog)
			<div class="single-post">
				<img class="img-fluid" src="@isset($blog->image->filename) /storage/media/blog/{{$blog->image->filename}} @endisset" alt="">
				<h3 class="posted-info">
					Posted On <span>{{ $blog->created_at->format('d M Y') }}</span> by <span>{{ $blog->createdBy->name }}</span>
				</h3>
				<a href="{{ route('frontend.blog.show', $blog->slug) }}">
					<h2>
						{{ $blog->title }}
					</h2>
				</a>
				<p>
					{!! str_limit($blog->description, $limit = 300, $end = '....') !!}
				</p>
			</div>
		@endforeach
	</div>
@endsection