<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\confirmMail;
use App\Models\Package;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // dd("COnd");
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username'      => ['required', 'string', 'max:20', 'unique:users'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'first_name'    => ['required', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'cell'          => ['required', 'string', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
       
        $remember_token = md5(time().rand());
        
        // dd(' Normal Create ');

        $mailData = array(
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'token' => $remember_token
        );

        Mail::to($data['email'])->send(new confirmMail($mailData));
      
      
        $token_data=array(
            'name'=> $data['first_name'].' '.$data['last_name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
            'mobile' => $data['cell'],
            'lastLogin' => date('Y-m-d H:i:s'),
            'role' => 'user',
            'email_verified_at'=>Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' =>Carbon::now()
            );
       
      DB::connection('mysql2')->table('users')->insert($token_data);


        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'cell' => $data['cell'],
            'referral_id' => $data['referral_id'],
            'role'      => 'customer',
            'remember_token' => $remember_token,
            'password' => Hash::make($data['password']),
        ]);
    }
}
