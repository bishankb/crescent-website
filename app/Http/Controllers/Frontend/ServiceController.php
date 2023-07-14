<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;

class ServiceController extends Controller
{
    public function index()
    {
    	$services = $this->getServices();
        return view('frontend.service', compact('services'));
    }

    private function getServices() {
    	$services = Service::where('status', 1)->get();
    	return $services;
    }
}
