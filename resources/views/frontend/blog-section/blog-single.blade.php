@extends('frontend.blog-section.blog-layout')

@section('blog-content')
	<div class="col-lg-8 post-list blog-post-list">
		<div class="single-post">
            <img class="img-fluid" src="@isset($blog->image->filename) /storage/media/blog/{{$blog->image->filename}} @endisset" alt="">
            <h3 class="posted-info">
                Posted On <span>{{ $blog->created_at->format('d M Y') }}</span> by <span>{{ $blog->createdBy->name }}</span>
            </h3>
			<h2>{{ $blog->title }}</h2>
			<div class="content-wrap">
				{!! $blog->description !!}
			</div>
            <div class="category">
                <span class="category-header">Category:  </span>
                <a href="#">{{ $blog->category->title }}</a>
            </div> 
            <ul class="tags">
                <span class="category-header">Tags:  </span>
                @foreach($blog->tags as $tag)
                    <li><a href="#">{{ $tag->title }}</a></li> /
                @endforeach
            </ul>         
		</div>
        <div id="disqus_thread"></div>  																		
	</div>
@endsection