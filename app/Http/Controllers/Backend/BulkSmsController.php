<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BulkSms;
use DB;
use App\Rules\ValidPhone;
use Validator;
use Illuminate\Support\Facades\Storage;
use File;
use App\Media;

class BulkSmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phones = BulkSms::get();
        return view('backend.bulksms.index', compact('phones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.bulksms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];

        foreach($request->input('phones') as $key => $phone) {
            $rules["phones.{$key}"] = ['bail', 'required', 'min:9',' max:11', new ValidPhone];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            foreach($request->input('phones') as $key => $phone) {
                BulkSms::create(['phone'=>$phone]);
            }

            return response()->json([
                'success'=>'Phone number(s) added successfully.'
            ]);
        }

        return response()->json([
            'error'=>$validator->errors()->all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Deleting the mass selected resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function massDestroy(Request $request)
    {
        $phoneNumbers = $request->phones;
        $phones = BulkSms::whereIn('phone', $phoneNumbers);

        if ($phones->delete()) {
            return [ 'success' => 'Phone Number(s) deleted successfully.'];
        }
        return [ 'error' => 'There was some intenal error while deleting the phone number(s).'];
    }

    /**
     * Deleting the mass selected resources from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function massSendMessage(Request $request)
    {
        $message = $request->message;
        $phoneNumbers = $request->phoneNumbers;
        $encodeMessage = urlencode($message);
        $formatNumbers = array_map(function($value) { 
            return '+977'.$value; 
        }, $phoneNumbers);
        $numbers = implode(',', $formatNumbers);

        $postData = [
            'From' => '+18646066071',
            'To' => $numbers,
            'Body' => $message,
        ];      

        $id = "ACb9b304e70ef59d240539d550fce621c7";
        $token = "fb966b5aa574a5fe1d3042f190d7ccaa";
        $url = "https://api.twilio.com/2010-04-01/Accounts/$id/Messages.json";

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_POST => true,
            CURLOPT_USERPWD => "$id:$token",
            CURLOPT_POSTFIELDS => $postData
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // Response
        $response = curl_exec($ch);

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return response()->json([
            'success' => 'Message sent successfully.',
            'status_code' => $status_code,
            'data' => json_decode($response),
        ]);
        curl_close($ch);
    }
}
