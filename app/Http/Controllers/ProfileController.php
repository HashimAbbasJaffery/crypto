<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\confirmMail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;


class ProfileController extends Controller
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
     * load profile view with user data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function tokens_dashboard(){
        $user = file_get_contents('https://token.mycryptopoolmirror.com/sale/check_email/'.Auth()->user()->email);
       
        if($user==1){
            $token_email=Session::get('emailtoken');
            $token_password=Session::get('tokenpassword');
            $email = $this-> encryptIt_member($token_email);
            $password = $this-> encryptIt_member($token_password);
            return redirect('https://token.mycryptopoolmirror.com/sale/token_login/'.$email.'/'.$password.'/'); 
            //return redirect('https://token.mycryptopoolmirror.com/sale/');    
           
        }else{
        $name = Auth()->user()->first_name.Auth()->user()->last_name;
        $password = Auth()->user()->password;
        $client = new Client();
        
        $response = $client->request('GET', 'https://token.mycryptopoolmirror.com/sale/register_member/'.$name.'/'.Auth()->user()->email.'/active');
        $res = $response->getBody();
        if($res){
            return redirect('https://token.mycryptopoolmirror.com/sale/');   
        }
        return redirect('https://token.mycryptopoolmirror.com/sale/');
        }
    }
    
    function encryptIt_member($string)
        {
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'mnbvcxzbRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhUqwe=';
        $secret_iv = 'mnbvcxzGGEERuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhUqwe=';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
        }
        
    function decryptIt_member($string)
        {
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'mnbvcxzbRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhUqwe=';
        $secret_iv = 'mnbvcxzGGEERuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhUqwe=';
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
        
        }
    public function profile(){
      
        $user = User::find(Auth::user() -> id);
        if($user->payment_status == 0){
            return redirect()->route('register.payment');
        }else if($user->payment_status == 1){
            return redirect()->route('payment.verify');
        }else{
            return view('profile', [
                'user_data' => $user,
            ]);
        }
    }

    /**
     * change password from profile page
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function passwordChange(Request $request){
        $user = User::find($request->user_id);
     
        if(password_verify($request->old_password, $user['password'])){
            if($request->new_password === $request -> confirm_password){
                if($request->old_password === $request -> new_password){
                    return '<div class="alert alert-warning"><strong>Warning!</strong> Please try another password. <button class="close" data-dismiss="alert" type="button">&times;</button></div>';
                }else{
                    $new_password=password_hash($request -> new_password, PASSWORD_DEFAULT);
                    $data=array('password'=>$new_password);
                    DB::connection('mysql2')->table('users')->where('email',Auth::user()->email)->update($data);
                    
                    $user->password = password_hash($request -> new_password, PASSWORD_DEFAULT);
                    $user->update();
                    $member_updated=array('updated_at'=>$user->updated_at);
                    DB::connection('mysql2')->table('users')->where('email',Auth::user()->email)->update($member_updated);
                    
                    if($request->is_login == false) {
                        Auth::logout();
                        return route('login');
                    }else{
                        return '<div class="alert alert-success"><strong>Success!</strong> Password updated successful. <button class="close" data-dismiss="alert" type="button">&times;</button></div>';
                    }
                }
            }else{
                return '<div class="alert alert-warning"><strong>Warning!</strong> Password not matched. <button class="close" data-dismiss="alert" type="button">&times;</button></div>';
            }
        }else{
            return '<div class="alert alert-danger"><strong>Danger!</strong> Password doesn\'t matched. <button class="close" data-dismiss="alert" type="button">&times;</button></div>';
        }
    }
    
    /**
     * change user email and password
     */
    
    public function infoChange(Request $request){
        $user = User::find(Auth::user() -> id);
        
        if(User::where('email', $request->email)->count() > 0){
            return '<div class="alert alert-danger"><strong>Danger!</strong> Email already exists. <button class="close" data-dismiss="alert" type="button">&times;</button></div>';
        }else{
            $remember_token = md5(time().rand());
        
            $mailData = array(
                'name' => $user->first_name.' '.$user->last_name,
                'email' => $request->email,
                'token' => $remember_token
            );
    
            Mail::to($request->email)->send(new confirmMail($mailData));
            
            $data=array('email'=>$request->email,'mobile'=>$request->cell);
            DB::connection('mysql2')->table('users')->where('email',Auth::user()->email)->update($data);
    
            
            $user->email = $request->email;
            $user->cell = $request->cell;
            $user->remember_token = $remember_token;
            $user->update(); 
            
            $member_updated=array('updated_at'=>$user->updated_at);
            DB::connection('mysql2')->table('users')->where('email',$request->email)->update($member_updated);
            return '<div class="alert alert-success"><strong>Danger!</strong> Data updated successfully. <button class="close" data-dismiss="alert" type="button">&times;</button></div>';
        }
    }

    /**
     * change name from profile page
     * @param Request $request
     * @return string
     */
    public function nameChange(Request $request){
       
        $user = User::find(Auth::user()->id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->update();
        
        $data=array('name'=>$request->first_name.' '.$request->last_name);
        DB::connection('mysql2')->table('users')->where('email',Auth::user()->email)->update($data);
        $member_updated=array('updated_at'=>$user->updated_at);
        DB::connection('mysql2')->table('users')->where('email',Auth::user()->email)->update($member_updated);
        
        return '<div class="alert alert-success"><strong>Success!</strong> Data updated successful. <button class="close" data-dismiss="alert" type="button">&times;</button></div>';
    }

    /**
     * update profile image from profile controller
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateImage(Request $request, $id){
        $data = User::find($id);

        $this -> validate($request, [
            'photo' => 'required | mimes:jpeg,jpg,png,gif,png',
        ],[
            'photo.required' => 'Please select an image before.'
        ]);

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $unique_name = md5(time().rand()).'.'.$file->getClientOriginalExtension();
            $file->move('media/profileImages', $unique_name);

            if(!empty($data->photo) && file_exists('media/profileImages/'.$data->photo)){
                unlink('media/profileImages/'.$data->photo);
            }
        }

        $data->photo = $unique_name;
        $data->update();

        return redirect()->back()->with('success', 'Images updated successful');

    }
       
}
