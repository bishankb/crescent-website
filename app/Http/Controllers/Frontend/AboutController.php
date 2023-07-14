<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Product;

class AboutController extends Controller
{
    public function index()
    {
        $users = $this->getMembers();
        $products = $this->getProducts();
        return view('frontend.about', compact('users', 'products'));
    }

    private function getMembers() {
    	$users = User::whereHas('role', function ($query) {
                            $query->where('name', '!=' , 'admin');
                        })->where('active', 1)->get();
    	return $users;
    }

    private function getProducts() {
        $products = Product::where('status', 1)->get();
        return $products;
    }
}
