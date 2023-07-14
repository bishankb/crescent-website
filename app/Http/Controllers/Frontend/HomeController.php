<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Feature;
use App\Blog;

class HomeController extends Controller
{
    public function index()
    {
    	$features = $this->getFeatures();
    	$blogs = $this->getBlogs();
        return view('frontend.home', compact('features', 'blogs'));
    }

    private function getFeatures() {
    	$features = Feature::get();
    	return $features;
    }

    private function getBlogs() {
    	$blogs = BLog::where('status', 1)->take(4)->latest()->get();
    	return $blogs;
    }
}
