<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendInvitation;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Validator, MainRepository, Mail, DB, Storage;

class ApiController extends Controller
{
    //
    public function sendinvitation($email, $id){
        $hasheddata = Crypt::encryptString($id);
        $mail = Mail::to($email)->send(new SendInvitation($hasheddata));
    }

    public function getusers(){
        $data = User::get();
        $toshow = [];

        foreach($data as $out){
            $toshow[] = [
                'id'            => $out->id,
                'name'          => $out->lastname . ', ' . $out->firstname,
                'image256'      => Storage::disk('public')->get('/profile_images').$out->image256,
                'email'         => $out->email,
                'is_signed_up'  => $out->firstname > '' ? "YES" : "NO"
            ];
        }

        return response()->json([
            'response'      => true,
            'data'          => $toshow
        ], 200);

    }

    public function edituser($id = null, Request $request){
        if($id > ''){
            $id = Crypt::decryptString($id);
            $user = User::where('id', $id)->whereNotNull('')->first();
            // return view('additionaldata', ['data' => $id]);
            if($user){
                return response()->json([
                    'response'      => true,
                    'message'       => "Valid"
                ], 200);
            }
            return response()->json([
                'response'      => false,
                'message'       => "Invalid"
            ], 422);
        }
    }

    public function editinformation(Request $request){
        $updateUser = MainRepository::updateuser($request);
        if($updateUser){
            return response()->json([
                'response'      => true,
                'message'       => "Success"
            ], 200);
        }
        return response()->json([
            'response'          => false,
            'message'           => "Failed"
        ], 422);
        // $getuserinfo = User::where('id', $request->id)->first();
        // if($updateUser){
        //     return view('/welcome', ['data' => $request->id]);
        // }
    }

    public function sendwelcome($email){
        Mail::to($email)->send(new WelcomeEmail);
    }

    public function deleteuser(Request $request){
        User::where('id', $request->id)->delete();
    }
}
