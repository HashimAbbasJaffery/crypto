<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * live user count
     * @param Request $request
     * @return int
     */
    public function check_email($email){
        $user =  User::where('email',$email)->first();
        if($user){
            return 1;
        }else{
            return 0;
        }
    }
    public function fetch_data($email){
        $user =  User::where('email',$email)->first();
        if($user){
            return $user->id;
        }else{
            return 0;
        }
    }
    public function fetch_hash($email){
       $user =  User::where('email',$email)->first();
        if($user){
            return $user->password;
        }else{
            return 0;
        }
    }

}