<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        return view('frontend.product-single', compact('product'));
    }
}
