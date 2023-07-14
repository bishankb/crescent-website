<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blog;
use App\Category;
use App\Tag;

class BlogController extends Controller
{
    public function index()
    {
    	$blogs =  Blog::where('status', 1)
                        ->blogsearch(request('search_blog'))
                        ->latest()
                        ->get();

        return view('frontend.blog-section.blog-list', compact('blogs'));
    }

    public function show(BLog $blog)
    {
        return view('frontend.blog-section.blog-single', compact('blog'));
    }

    public function categoryBlogs()
    {
    	$category = Category::where('slug', request('slug'))
    					 ->where('category_for', 'blog')
    					 ->where('status', 1)
    					 ->first();
    	$category_title = $category->title;
    	$blogs = $category->blogs;    	
        return view('frontend.blog-section.blog-category', compact('category_title', 'blogs'));
    }

    public function tagBlogs()
    {
        $tag = Tag::where('slug', request('slug'))
                         ->where('tag_for', 'blog')
                         ->where('status', 1)
                         ->first();
        $tag_title = $tag->title;
        $blogs = $tag->blogs;      
        return view('frontend.blog-section.blog-tag', compact('tag_title', 'blogs'));
    }
}
