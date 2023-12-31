<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * return view wallet controller
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function wallet(){
        $user = User::find(Auth::user()->id);
        if($user->payment_status == 0){
            return redirect()->route('register.payment');
        }else if($user->payment_status == 1){
            return redirect()->route('payment.verify');
        }else{
            return view('wallet');
        }
    }
}
