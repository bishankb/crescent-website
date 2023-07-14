<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  Auth;
use App\Mail\ViewerMailMailable;
use Mail;
use App\Notifications\ViewerMailNotification;
use App\User;
use Notification;

class ViewerMessageController extends Controller
{
    public function send(Request $request)
    {
        $viewer_message = new \stdClass();
        $viewer_message->name = request('name');
        $viewer_message->email = request('email');
        $viewer_message->phone = request('phone');
        $viewer_message->subject = request('subject');
        $viewer_message->message = request('message');

        if($viewer_message) {
            Mail::to('nepal.crescent@gmail.com')
                ->send(new ViewerMailMailable($viewer_message));

            $viewer_name = $viewer_message->name;

            $users = User::whereHas('role')->get();

            Notification::send($users, new ViewerMailNotification($viewer_name));
        }

        if ($viewer_message) {
            $notification = array(
                'message'    => 'Thank You For Your  Co-operation.',
                'alert-type' => 'success'
            );
            return redirect()->route('frontend.contact-us')->with($notification);
        } else {
            $notification = array(
                'message'    => 'Internal Error, Please try again later.',
                'alert-type' => 'error'
            );           
            return redirect()->route('frontend.contact-us')->with($notification);
        }
    }

    public function markAsRead()
    {
         if (Auth::user()->unreadNotifications) {

            Auth::user()->notifications->markAsRead();
            Auth::user()->readNotifications()->delete();

            flash('Notification(s) cleared successfully.')->success();
            return redirect()->back();
        }

        flash('There was some intenal error while clearing the notification(s).')->error();
        return redirect()->back();
    }
}
