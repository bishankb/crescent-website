<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Blog;
use App\Product;
use App\Service;
use App\Feature;
use App\User;

class DashboardController extends Controller
{
    public function index()
    {     
        $totalBlog = $this->totalBlogCount();
        $totalFeature = $this->totalFeatureCount();
        $totalProduct = $this->totalProductCount();
        $totalService = $this->totalServiceCount();
        $totalUser = $this->totalUserCount();
        
        return view('backend.dashboard', compact(
            'totalBlog',
            'totalFeature',
            'totalProduct',
            'totalService',
            'totalUser'
        ));
    }

    private function totalBlogCount()
    {
        return Blog::count();
    }

    private function totalFeatureCount()
    {
        return Feature::count();
    }

    private function totalProductCount()
    {
        return Product::count();
    }

    private function totalServiceCount()
    {
        return Service::count();
    }

    private function totalUserCount()
    {
        return User::count();
    }
}
