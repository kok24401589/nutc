<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Hash;
use App\User;
use DB;

class RegisterController extends Controller
{
    //
    public function index(){
        if(request()->has("register"))
        {
            $input = request()->all();
            $rule = [
                "user_email" => [
                    "required",
                    "max:200",
                    "email"
                ],
                "user_pw" => [
                    "required",
                    "same:user_repw",
                    "alpha_num",
                    "min:3",
                ],
                "user_repw" => [
                    "required",
                    "alpha_num",
                    "min:3",
                ],
                "user_name" => [
                    "required",
                    "max:50",
                ],
            ];
            $validator = Validator::make($input,$rule);
            if($validator->fails())
            {
                return redirect("signup")
                     ->withErrors($validator)
                     ->withInput();
            }
            else
            {
                $input["user_pw"] = Hash::make($input["user_pw"]);
                // dd($input);
                // User::create($input);
                DB::Table('users')
                   ->insert(['user_email'=>$input["user_email"],
                            'user_pw'=>$input["user_pw"],
                            'user_name'=>$input["user_name"]]);
                return redirect("signin");
                
            }
        }
        return view("admin/back_register");
    }
}
