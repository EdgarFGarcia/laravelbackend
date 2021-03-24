<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendInvitation;
use App\Jobs\WelcomeMessage;
use Validator;
use Mail;
use App\Mail\SendInvitation as mailservice;
use App\Models\User;
use MainRepository;
use Illuminate\Support\Facades\Crypt;

class DispatchInvitation extends Controller
{
    //
    public function dispatchinvitation(Request $request){

        $validate = Validator::make($request->all(), [
            'email'         => 'required|email|unique:users'
        ]);

        if($validate->fails()){
            $error = $validate->messages()->first();
            return response()->json([
                'response'  => false,
                'message'   => $error
            ], 422);
        }

        $user = User::create([
            'email'     => $request->email
        ]);

        $hasheddata = Crypt::encryptString($user->id);

        MainRepository::updateuseraddhash($user->id, $hasheddata);

        // Mail::to($request->email)->send(new mailservice($hasheddata));

        $sendemail = new SendInvitation($request->email, $user->id);
        dispatch($sendemail);
        return response()->json([
            'response'      => true,
            'message'       => "Sending Invitation Successful"
        ], 200);
    }

    public function sendwelcomemessage(Request $request){
        $getuseremail = User::where('id', $request->id)->first(['email']);
        $on = \Carbon\Carbon::now()->addMinutes(5);
        $dispatchwelcome = new WelcomeMessage($getuseremail->email);
        dispatch($dispatchwelcome)->delay($on);
    }
}
