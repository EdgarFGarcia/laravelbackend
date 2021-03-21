<?php
namespace App\Repositories;

use App\Models\User;
use Hash, Image;

class MainRepository{
    public static function updateuseraddhash($id, $hash){
        User::where('id', $id)
        ->update([
            'hash'  => $hash
        ]);
    }

    public static function userlookupviaid($id){
        return User::where('id', $id)->first();
    }

    public static function updateuser($data){
        $password = Hash::make($data->firstname . $data->lastname);

        //get filename with extension
        $filenamewithextension = $data->file('profile_image')->getClientOriginalName();
 
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
 
        //get file extension
        $extension = $data->file('profile_image')->getClientOriginalExtension();
 
        //filename to store
        $filenametostore = $filename.'_'.time().'.'.$extension;

        //Upload File
        $data->file('profile_image')->storeAs('public/profile_images', $filenametostore);
        $data->file('profile_image')->storeAs('public/profile_images/thumbnail', $filenametostore);

        //Resize image here
        $thumbnailpath = public_path('storage/profile_images/thumbnail/'.$filenametostore);
        $img = Image::make($thumbnailpath)->resize(64, 64, function($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($thumbnailpath);

        $profilepictureadmin = public_path('storage/profile_images/'.$filenametostore);
        $img = Image::make($profilepictureadmin)->resize(256, 256, function($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($profilepictureadmin);

        return User::where('id', $data->id)
        ->update([
            'firstname'     => $data->firstname,
            'lastname'      => $data->lastname,
            'password'      => $password,
            'image64'       => $filenametostore,
            'image256'      => $filenametostore,
            'hash'          => NULL
        ]);
    }
}