<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ContactUs;

class ContactUsController extends Controller
{
    public function index()
    {
        $contact_us = ContactUs::first();
        return view('frontend.contact-us', compact('contact_us'));
    }
}
