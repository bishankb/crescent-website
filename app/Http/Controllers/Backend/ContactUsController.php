<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ContactUs;
use Auth;

class ContactUsController extends Controller
{
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {   
        $contact_us = ContactUs::first();
        if(isset($contact_us)) {
            return view('backend.contact-us.edit', compact('contact_us'));
        } else {
            return view('backend.contact-us.edit');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $contact_us = ContactUs::first();

        $this->validate(
            $request,
            [
                'address'           => 'nullable|min:2|max:100',
                'phone1'            => 'nullable|min:5|max:20',
                'phone2'            => 'nullable|min:5|max:20',
                'phone3'            => 'nullable|min:5|max:20',
                'phone4'            => 'nullable|min:5|max:100',
                'email'             => 'nullable|email',
                'facebook'          => 'nullable|min:2|max:100',
                'google_plus'       => 'nullable|min:2|max:100',
                'map_embedded_link' => 'nullable|min:2',
            ]
        );       

        if (!$contact_us) {
            $contact_us = ContactUs::create(
                [
                    'address'           => request('address'),
                    'phone1'            => request('phone1'),
                    'phone2'            => request('phone2'),
                    'phone3'            => request('phone3'),
                    'phone4'            => request('phone4'),
                    'email'             => request('email'),
                    'facebook'          => request('facebook'),
                    'twitter'           => request('twitter'),
                    'google_plus'       => request('google_plus'),
                    'map_embedded_link' => request('map_embedded_link')
                ]
            );
        } else {
            $contact_us->update(
                [
                    'address'           => request('address'),
                    'phone1'            => request('phone1'),
                    'phone2'            => request('phone2'),
                    'phone3'            => request('phone3'),
                    'phone4'            => request('phone4'),
                    'email'             => request('email'),
                    'facebook'          => request('facebook'),
                    'twitter'           => request('twitter'),
                    'google_plus'       => request('google_plus'),
                    'map_embedded_link' => request('map_embedded_link')
                ]
            );
        }

        if ($contact_us) {
            flash('Contact Us detail updated successfully.')->success();
            return redirect(route('contact-us.edit', $contact_us));
        } 
        flash('There was some intenal error while updating the contact us detail.')->error();
        return redirect(route('contact-us.edit, $contact_us'));
    }
}
