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
                // 'image256'      => storage_path('profile_images/' . $out->image256),
                'image256'      => Storage::disk('public')->get('/profile_images').$out->image256,
                'email'         => $out->email,
                'is_signed_up'  => $out->firstname > '' ? "YES" : "NO"
            ];
        }

        return response()->json([
            'response'      => true,
            'data'          => $toshow
        ], 200);

        // return response()->json([
        //     'response'      => true,
        //     'data'          => User::get([
        //         'id',
        //         DB::raw("CONCAT(lastname, ', ', firstname) as name"),
        //         'image256',
        //         'email',
        //         DB::raw('(CASE WHEN firstname IS NULL THEN "NO" ELSE "YES" END) AS is_signed_up')
        //     ])
        // ], 200);
    }

    public function edituser($id = null, Request $request){
        if($id > ''){

            // $validate = Validator::make($request->all(), [
            //     'firstname'     => 'required|string',
            //     'lastname'      => 'required|string',
            //     'profile_image' => 'required, mimes:jpeg,jpg,gif,png'
            // ]);

            $id = Crypt::decryptString($id);
            return view('additionaldata', ['data' => $id]);
            // $datatoedit = MainRepository::userlookupviaid($id);
            // return $updateUser = MainRepository::updateuser($request, $datatoedit->id);
        }
    }

    public function editinformation(Request $request){
        $updateUser = MainRepository::updateuser($request);
        // $getuserinfo = User::where('id', $request->id)->first();
        if($updateUser){
            return view('/welcome', ['data' => $request->id]);
        }
    }

    public function sendwelcome($email){
        sleep(500);
        Mail::to($email)->send(new WelcomeEmail);
    }

    public function deleteuser(Request $request){
        User::where('id', $request->id)->delete();
    }
}
