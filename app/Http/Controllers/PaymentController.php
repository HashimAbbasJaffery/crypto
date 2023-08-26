<?php														
														
namespace App\Http\Controllers;														
														
use App\Models\User;														
use Illuminate\Http\Request;														
use Illuminate\Support\Facades\Auth;														
use Illuminate\Support\Facades\DB;														
use Illuminate\Support\Facades\Session;														
use Illuminate\Support\Facades\Mail;														
use App\Mail\confirmMail;														
use App\Mail\Paymentmail;														
														
														
require_once('stripe-php/init.php');														
class PaymentController extends Controller														
{														
/**														
* Create a new controller instance.														
*														
* @return void														
*/														
														
	private $memberhsip_fee;													
	private $paypal_mode;													
	private $paypal_email;													
	private $publishable_key;													
	private $secret_key;													
														
public function __construct()														
{														
//$this->middleware('auth');														
		$this->memberhsip_fee	= '95';											
		//$this->paypal_url		= 'https://www.sandbox.paypal.com/cgi-bin/webscr';//sandbox										
		$this->paypal_url		= 'https://www.paypal.com/cgi-bin/webscr';//live										
		$this->paypal_email		= 'ubivismanagement@gmail.com';										
		$this->publishable_key	= 'pk_live_51MOOi9GNtB7KebUvbB20nYjFX8hNj9fewECygwac0HomtTifAwPY3q7SyUMa1HA6d9eRs9w5gkC1zOILpYBibzUb00ctJMcLIn';											
		$this->secret_key		= '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';										
}														
														
/**														
* get payment														
* @return \Illuminate\Http\RedirectResponse														
*/														
public function payment(){														
														
		//if($_SERVER['REMOTE_ADDR'] == '2404:3100:1040:85b1:1cd7:dca1:cc67:77f5'){												
			$id = Auth::user()->id;											
			$data = DB::table('users')											
->join('user_packages', 'user_packages.user_id', '=', 'users.id')->where('users.id', $id)->get();														
														
			$user_data = User::find(Auth::user()->id);											
			$user_data->payment_status = 1;											
			$user_data->save();											
														
			return view('gateways', [											
					'user_data'		=> $data[0],
					'memberhsip_fee'=> $this->memberhsip_fee,
					'paypal_url'	=> $this->paypal_url,
					'paypal_email'	=> $this->paypal_email,
					'publish_key'	=> $this->publishable_key,
					'secret_key'	=> $this->secret_key,
					'error'			=> ''						
				]);										
		/*} else{												
														
			$data = array(											
				name => Auth::user() -> first_name.' '.Auth::user() -> last_name,										
				description => "Pre-launch offer for CPM membership (** Price is subject to change without notice_Reserve your spot now!!)",										
				pricing_type => "fixed_price",										
				local_price => array(										
					amount => "95.00", //you must enter the price in quotes									
					currency => "USD"									
				),										
				metadata => array(										
					user_id => Auth::user()->id,									
					email    => Auth::user()->email,									
				),										
				redirect_url => route('home'),										
				cancel_url => route('home')										
			);											
														
			$post = json_encode( $data );											
			$api_key = '78462516-ef1b-4b0a-ab71-70f99176f2b1';											
														
			$ch = curl_init();											
														
			curl_setopt($ch, CURLOPT_URL, 'https://api.commerce.coinbase.com/charges/');											
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);											
			curl_setopt($ch, CURLOPT_POST, 1);											
														
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);											
														
			$headers = array();											
			$headers[] = 'Content-Type: application/json';											
			$headers[] = 'X-Cc-Api-Key: ' . $api_key;											
			$headers[] = 'X-Cc-Version: 2018-03-22';											
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);											
														
			$result = curl_exec($ch);											
			if (curl_errno($ch)) {											
				echo 'Error:' . curl_error($ch);										
			}											
			curl_close($ch);											
														
			$result_de = json_decode( $result );											
														
			$re_url = $result_de->data->hosted_url;											
			$user_data = User::find(Auth::user()->id);											
			$user_data->payment_status = 1;											
			$user_data->save();											
			return redirect()->intended($re_url);											
		}*/												
}														
														
	public function stripePayment(Request $request){													
														
		//echo '<pre>';print_r($_POST);exit;												
		$request->session()->forget('stripe_error');												
														
		$stripeToken	= (isset($_POST['stripeToken']) && !empty($_POST['stripeToken'])) ? ($_POST['stripeToken']) : '';											
		$cardNumber		= (isset($_POST['card_number']) && !empty($_POST['card_number'])) ? ($_POST['card_number']) : '';										
		$cardExpMonth	= (isset($_POST['card_expiry_month']) && !empty($_POST['card_expiry_month'])) ? ($_POST['card_expiry_month']) : '';											
		$cardExpYear	= (isset($_POST['card_expiry_year']) && !empty($_POST['card_expiry_year'])) ? ($_POST['card_expiry_year']) : '';											
		$cardCVC		= (isset($_POST['cvc_number']) && !empty($_POST['cvc_number'])) ? ($_POST['cvc_number']) : '';										
		$custName		= Auth::user() -> first_name.' '.Auth::user() -> last_name;										
		$custEmail		= Auth::user()->email;										
														
		$publish_key	= $this->publishable_key;											
		$secret_key		= $this->secret_key;										
														
		if($publish_key && $secret_key){												
			//check if stripe token exist to proceed with payment											
			if(!empty($stripeToken))											
			{											
				try {
				    
					//set stripe secret key and publishable key									
					$stripe	= array(								
								'secret_key'		=> $secret_key,				
								'publishable_key'	=> $publish_key					
							);							
					\Stripe\Stripe::setApiKey($stripe['secret_key']);									
					//add customer to stripe									
					$customer	= \Stripe\Customer::create(array(
								   'email'	=> $custEmail,
								   'source' => $stripeToken			
							));							
											
					$amount		= $this->memberhsip_fee;							
					$currency	= "usd";
					
					
					$payDetails	= \Stripe\Charge::create(array(
								   'customer'		=> $customer->id,
								   'amount'			=> $amount*100,/*Stripe is getting payment in cents, so we are multiplying with 100*/
								   'currency'		=> $currency,
								   'description'	=> "Pre-launch offer for CPM membership (** Price is subject to change without notice_Reserve your spot now!!)"					
								));
					
					
					
					
					
					$paymenyResponse= $payDetails->jsonSerialize();									
				    // 	echo '<pre>';print_r($paymenyResponse);exit;									
					// check whether the payment is successful									
					if($paymenyResponse['amount_refunded'] == 0 && empty($paymenyResponse['failure_code']) && $paymenyResponse['paid'] == 1 && $paymenyResponse['captured'] == 1)									
					{									
						// transaction details								
						$transaction_id_no	= $paymenyResponse['id'];							
						$amountPaid			= $paymenyResponse['amount'];					
						$balanceTransaction = $paymenyResponse['balance_transaction'];								
						$paidCurrency		= $paymenyResponse['currency'];						
						$paymentStatus		= $paymenyResponse['status'];						
						$paymentDate		= date("Y-m-d H:i:s");						
						//if order inserted successfully								
						if($transaction_id_no && $paymentStatus == 'succeeded')								
						{								
							$data_insert['txn_id']			= $transaction_id_no;				
							$data_insert['payment_status']	= 'Completed' ;						
														
							$user_id = Auth::user()->id;							
							$user = User::find( $user_id );							
							$user->payment_status = 2;							
							$user->webhook_response = 'Stripe';							
							$user->save();							
				//			$user_name		= Auth::user() -> first_name.' '.Auth::user() -> last_name;					
				//			$mail = "info@mycryptopoolmirror.com";							
//                         $mailData = array(														
//                         'name' => $user_name,														
//                         'email' => $mail,														
//                         'token' => $remember_token														
//                         );														
				//		Mail::to($mail)->send(new Paymentmail($mailData));								
														
							return redirect(route('home'));							
						}								
						else								
						{								
					$request->session()->put('stripe_error', 'Something went wrong. Please try again later.');									
						}								
					}									
					else									
					{									
				$request->session()->put('stripe_error', 'Something went wrong. Please try again later.');										
					}									
				} catch(Stripe_CardError $e) {										
					// Since it's a decline, Stripe_CardError will be caught									
					$body = $e->getJsonBody();									
					$err  = $body['error'];									
														
					//print('Status is:' . $e->getHttpStatus() . "\n");									
					//print('Type is:' . $err['type'] . "\n");									
					//print('Code is:' . $err['code'] . "\n");									
					// param is '' in this case									
					//print('Param is:' . $err['param'] . "\n");									
					//print('Message is:' . $err['message'] . "\n");									
														
					$request->session()->put('stripe_error', $err['message']);									
				} catch (Stripe_InvalidRequestError $e) {										
					// Invalid parameters were supplied to Stripe's API									
					$request->session()->put('stripe_error', 'Something went wrong. Please try again later.');									
				} catch (Stripe_AuthenticationError $e) {										
					// Authentication with Stripe's API failed									
					// (maybe you changed API keys recently)									
					$request->session()->put('stripe_error', 'Something went wrong. Please try again later.');									
				} catch (Stripe_ApiConnectionError $e) {										
					// Network communication with Stripe failed									
					$request->session()->put('stripe_error', 'Something went wrong. Please try again later.');									
				} catch (Stripe_Error $e) {										
					// Display a very generic error to the user, and maybe send									
					// yourself an email									
					$request->session()->put('stripe_error', 'Something went wrong. Please try again later.');									
				}
				
				catch (\Stripe\Error\Base $e) {
				    
					// Something else happened, completely unrelated to Stripe									
					$request->session()->put('stripe_error',$e->getMessage());		
				    
				}

				catch (Exception $e) {										
					// Something else happened, completely unrelated to Stripe									
					$request->session()->put('stripe_error', 'Something went wrong. Please try again later.');									
				}										
			}											
			else											
			{											
		$request->session()->put('stripe_error', 'Something went wrong. Please try again later.');												
			}											
		} else{												
	$request->session()->put('stripe_error', 'Something went wrong. Please try again later.');													
		}												
		return redirect(route('register.payment'));												
														
	}													
														
	public function coinbasePayment(){													
			
		$data = array(												
				'name' => Auth::user() -> first_name.' '.Auth::user() -> last_name,										
				'description' => "Pre-launch offer for CPM membership (** Price is subject to change without notice_Reserve your spot now!!)",										
				'pricing_type' => "fixed_price",										
				'local_price' => array(										
					'amount' => "95.00", //you must enter the price in quotes									
					'currency' => "USD"									
				),										
				'metadata' => array(										
					'user_id' => Auth::user()->id,									
					'email'    => Auth::user()->email,									
				),										
				'redirect_url' => route('home'),										
				'cancel_url' => route('home')										
			);											
		//echo '<pre>';print_r($data);exit;												
		$post = json_encode( $data );												
		$api_key = '78462516-ef1b-4b0a-ab71-70f99176f2b1';												
														
		$ch = curl_init();												
														
		curl_setopt($ch, CURLOPT_URL, 'https://api.commerce.coinbase.com/charges/');												
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);												
		curl_setopt($ch, CURLOPT_POST, 1);												
														
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);												
														
		$headers = array();												
		$headers[] = 'Content-Type: application/json';												
		$headers[] = 'X-Cc-Api-Key: ' . $api_key;												
		$headers[] = 'X-Cc-Version: 2018-03-22';												
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);												
														
		$result = curl_exec($ch);												
		if (curl_errno($ch)) {												
			echo 'Error:' . curl_error($ch);											
		}												
		curl_close($ch);												
														
		$result_de = json_decode( $result );												
														
		$re_url = $result_de->data->hosted_url;												
		$user_data = User::find(Auth::user()->id);												
		$user_data->payment_status = 1;												
		$user_data->save();												
		return redirect()->intended($re_url);												
	}													
														
/**														
* for get payment data after success or failed														
*/														
public function handle_webhook() {														
$payload    = file_get_contents( 'php://input' );														
$data       = json_decode( $payload, true );														
$event_data = $data['event']['data'];														
														
if ( ! isset( $event_data['metadata']['user_id'] ) ) {														
// Probably a charge not created by us.														
exit;														
}														
														
if ( 'charge:confirmed' == $data['event']['type'] ) {														
$user_id = $event_data['metadata']['user_id'];														
$user = User::find( $user_id );														
$user->payment_status = 2;														
$user->save();														
}														
														
exit;  // 200 response for acknowledgement.														
}														
														
	/**													
* for get PayPal payment data after success or failed														
*/														
public function handle_webhook_paypal() {														
														
		$response	= json_encode($_POST);											
		$data       = json_decode( $response, true );												
														
		if(isset($data['payment_status']) && $data['payment_status'] == 'Completed'){
			$txn_id	= $data['txn_id'];
			$user_id = $data['custom'];
			$user = User::find( $user_id );
			$user->payment_status = 2;
			$user->webhook_response = 'PayPal';
			$user->save();											
// $user_name		= Auth::user() -> first_name.' '.Auth::user() -> last_name;												
// $mail = "info@mycryptopoolmirror.com";														
// $mailData = array(														
// 'name' => $user_name,														
// 'email' => $mail,														
// 'token' => $remember_token														
// );														
// Mail::to($mail)->send(new Paymentmail($mailData));														
		}												
exit;  // 200 response for acknowledgement.														
}														
														
public function verifyPayment(){
        $user = User::find(Auth::user() -> id);
        if($user->payment_status == 2){
            if($user->email != "lol@gmail.com") {
                $user_name		= Ucfirst(Auth::user() -> first_name.' '.Auth::user() -> last_name);
                $mail = "info@mycryptopoolmirror.com";
                $mailData = array(
                'name' => $user_name,
                'email' => $mail,
                'token' => $remember_token
                );
                Mail::to($mail)->send(new Paymentmail($mailData));
            }
            return redirect('home');
        }else{
            return view('verify');
        }
    }														
public function saroemail(){														
														
														
	// $id = Auth::id();													
// $user = User::find($id);														
	$user_name= Ucfirst(Auth::user() -> first_name.' '.Auth::user() -> last_name);													
	$remember_token = md5(time().rand());													
	$mail = 'saravananmarimuthu994312@gmail.com';
        
            $mailData = array(
                'name' =>'Pila',
                'email' => 'saravanan.m@spiegeltechnologies.com',
                'token' => $remember_token
            );														
														
														
Mail::to($mail)->send(new Paymentmail($mailData));														
														
														
														
														
//   if (Mail::failures()) {														
//       return response()->Fail('error');														
//   }else{														
//       return response()->success('Successfully send in your mail');														
//      }														
														
}														
}														