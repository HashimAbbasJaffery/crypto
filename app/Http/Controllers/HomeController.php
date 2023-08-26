<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserToken;
use App\Models\Setting;
use App\Models\IcoMeta;
use App\Models\IcoStage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $actived_stage = Setting::getValue('actived_stage');
        if ($actived_stage != '') {
            $this->stage = IcoStage::where('status', '!=', 'deleted')->where('id', $actived_stage)->first();
            if (!$this->stage) {
                $this->stage = IcoStage::where('status', '!=', 'deleted')->orderBy('id', 'DESC')->first();
            }
        } else {
            $this->stage = IcoStage::where('status', '!=', 'deleted')->first();
        }
    }
    
    /**
     * For token calcutions 
     * 
     * @start
     * 
     */
    public static function token($params = '') {
        
        if(!empty($params)) { 
            $token_purchase = Setting::getValue('token_purchase_'.$params);
            if (!blank($token_purchase)) { 
                return $token_purchase; 
            } else {
                return ''; 
            }
        } else {
            return '';
        }
    }
    
    public function calc_token($token, $output = 'total')
    {
        if (empty($token)) {
            return 0;
        }

        $return = 0;

        // Price Calculation
        $price = $this->get_current_price();
        $cost = [];
        $base = $token * $price;
        $cost['base'] = $base;

        $currencies = Setting::active_currency();
        $decimal_max = Setting::getValue('decimal_max');
        $decimal = (empty($decimal_max) ? 6 : $decimal_max);
        // dd($decimal);
        foreach ($currencies as $code => $rate) {
            $cost[$code] = round(($rate * $base), $decimal);
        }

        // Bonus Calculation
        $token_bonus = $this->calc_bonus($token, 'all', 'total');
        $token_bonus_base = $this->calc_bonus($token, 'based', 'total');
        $token_bonus_amount = $this->calc_bonus($token, 'amount', 'total');
        $token_purchase = $token;
        $total_token = round(($token_purchase + $token_bonus), $this->min_decimal());

        $calc = [
            'total' => $total_token,
            'price' => (object) $cost,
            'bonus' => $token_bonus,
            'bonus-base' => $token_bonus_base,
            'bonus-token' => $token_bonus_amount,
        ];
        if($output==='array') {
            return $calc;
        } elseif (isset($calc[$output])) {
            return $calc[$output];
        }
        return $return;
    }
    
    function def_datetime($get = '')
    {
        if (!$get) {
            return false;
        }

        $data = [
            'date' => '2000-01-01',
            'time_s' => '00:00:00',
            'time_e' => '23:59:00',
        ];
        $return = [
            'date' => $data['date'],
            'time' => $data['time_s'],
            'time_s' => $data['time_s'],
            'time_e' => $data['time_e'],
            'datetime' => $data['date'] . ' ' . $data['time_s'],
            'datetime_s' => $data['date'] . ' ' . $data['time_s'],
            'datetime_e' => $data['date'] . ' ' . $data['time_e'],
        ];
        return $return[$get];
    }
    
    function min_decimal() : int
    {
        $decimal = Setting::getValue('token_decimal_min');
        return ($decimal) ? $decimal : 2;
    }
    
    public static function max_decimal() : int
    {
        $decimal = Setting::getValue('token_decimal_max');
        return ($decimal) ? $decimal : 6;
    }
    
    function decimal_show() : int
    {
        $decimal = Setting::getValue('token_decimal_show');
        return (empty($decimal) ? 0 : $decimal);
    }
    
    public static function to_num($num, $decimal='max', $thousand='', $trim = true, $point='.', $zero_lead=false)
    {
        return static::_format(['number'=> $num, 'decimal' => $decimal, 'thousand' => $thousand, 'zero_lead' => $zero_lead, 'trim' => $trim, 'point' => $point, 'end' => true]);
    }
    
    public static function _format($attr = [])
    {
        $number = isset($attr['number']) ? $attr['number'] : 0;
        $point = isset($attr['point']) ? $attr['point'] : '.';
        $thousand = isset($attr['thousand']) ? $attr['thousand'] : '';
        $decimal = isset($attr['decimal']) ? $attr['decimal'] : 'max';
        $trim = isset($attr['trim']) ? $attr['trim'] : true;
        $end = isset($attr['end']) ? $attr['end'] : false;
        $zero_lead = isset($attr['zero_lead']) ? $attr['zero_lead'] : false;
        $site_decimal = static::max_decimal();

        if ( in_array($decimal, ['max', 'min', 'auto', 'zero']) ) {
            if($decimal=='min') $site_decimal = $this->min_decimal();
            if($decimal=='auto') $site_decimal = $this->decimal_show();
            if($decimal=='zero') $site_decimal = 0;
        } else {
            $site_decimal = (int)$decimal;
        }
        $end_rep = ($trim==true && $end==true && ($decimal=='min'||$decimal=='max'||$decimal=='auto')) ? '.00' : '';
        $ret = ($number > 0) ? number_format($number, $site_decimal, $point, $thousand) : 0;
        $ret = ($trim == true && $number > 0) ? rtrim($ret, '0') : $ret;
        $ret = (substr($ret, -1)) == '.' ? str_replace('.', $end_rep, $ret) : $ret;
        $ret = ($zero_lead===false && (substr($ret, -3)==='.00')) ? str_replace('.00', '', $ret) : $ret;
        return $ret;
    }
    
    public function get_current_price($attr = '')
    {
        $current_date = date('Y-m-d H:i:s');
        $return = 0;

        // Get Base Pricing
        $base = (object) [];
        $base->price = $this->stage->base_price;
        $base->min_purchase = $this->stage->min_purchase;
        $base->start_date = $this->stage->start_date;
        $base->end_date = $this->stage->end_date;
        $base->status = 1;

        // Stage Fallback
        $ico_date_s = $base->start_date;
        $ico_date_e = $base->end_date;
        $ico_min_token = $base->min_purchase;

        // Get Tier Pricing
        $data = $this->get_prices();
        $prices = $price_only = $minimum = [];
        if (!empty($base)) {
            $data->base = $base;
        }

        // Define Pricing
        if (!empty($data)) {
            foreach ($data as $tire => $tire_opt) {
                if ($tire_opt->status == 1 && $tire_opt->price > 0) {
                    // Override date-time if match fallback date
                    $tire_opt->start_date = ($tire_opt->start_date == $this->def_datetime('datetime_s')) ? $ico_date_s : $tire_opt->start_date;
                    $tire_opt->end_date = ($tire_opt->end_date == $this->def_datetime('datetime_e')) ? $ico_date_e : $tire_opt->end_date;
                    // Set min-purchase if matches up zero '0';
                    $tire_opt->min_purchase = ($tire_opt->min_purchase == 0) ? $ico_min_token : $tire_opt->min_purchase;

                    $prices[$tire] = $tire_opt;
                    $price_only[$tire] = $tire_opt->price;
                    $minimum[$tire] = $tire_opt->min_purchase;
                }
            }
        }
        asort($price_only);
        asort($prices);
        $lowest_price = (!empty($price_only)) ? min(array_values($price_only)) : 0;
        $min_tire = 'base';

        foreach ($price_only as $t => $p) {
            if ($p == $lowest_price) {
                $min_tire = $t;
                break;
            }
        }

        $return = $lowest_price;

        $return_price = [
            'base' => $base,
            'all' => $prices,
            'price' => $price_only,
            'min' => $minimum[$min_tire],
            'minimum' => $minimum,
        ];

        if($attr==='array') {
            return $return_price;
        } elseif (isset($return_price[$attr])) {
            return $return_price[$attr];
        }

        return $return;
    }
    
    public function get_prices()
    {
        $data = IcoMeta::get_data($this->stage->id, 'price_option');
        $result = $data;

        return $result;
    }
    
    /**
     * Calculate the bonus
     *
     * @version 1.0.0
     * @since 1.0
     * @return void
     */
    public function calc_bonus($token, $type = '', $output = 'total')
    {
        $amount = $bonus_percent = $amount_bonus_percent = 0;
        if (empty($token)) {
            return $amount;
        }

        $bonus_for_regular = $this->get_current_bonus(null);
        $bonus_for_amount = $this->get_current_bonus('amount');

        // Based Bonus
        $bonus_percent = ($bonus_for_regular) ? $bonus_for_regular : $bonus_percent;
        $bonus_regular = ($token * $bonus_percent) / 100;
        $bonus_regular = round($bonus_regular, $this->min_decimal());

        // Amount Bonus
        if (!empty($bonus_for_amount)) {
            foreach ($bonus_for_amount as $k => $bn) {
                $amount_bonus_percent = ($token >= $k) ? $bn : $amount_bonus_percent;
            }
        }
        $bonus_amount = ($token * $amount_bonus_percent) / 100;
        $bonus_amount = round($bonus_amount, $this->min_decimal());

        // Total Bonus Tokens
        $total_percent = $bonus_percent + $amount_bonus_percent;
        $total_bonus = round(($bonus_regular + $bonus_amount), $this->min_decimal());

        // $return => @default->total
        $amount = ($output == 'percent') ? $total_percent : $total_bonus;
        if ($output == 'array') {
            $amount = array('based' => array('percent' => $bonus_percent, 'token' => $bonus_regular),
                'amount' => array('percent' => $amount_bonus_percent, 'token' => $bonus_amount),
                'total' => array('percent' => $total_percent, 'token' => $total_bonus));
        }

        // $return => @based
        if ($type == 'based') {
            $amount = ($output == 'percent') ? $bonus_percent : $bonus_regular;
            $amount = ($output == 'array') ? array('percent' => $bonus_percent, 'token' => $bonus_regular) : $amount;
        }

        // $return => @amount
        if ($type == 'amount') {
            $amount = ($output == 'percent') ? $amount_bonus_percent : $bonus_amount;
            $amount = ($output == 'array') ? array('percent' => $amount_bonus_percent, 'token' => $bonus_amount) : $amount;
        }

        return $amount;
    }
    

    /**
     * Get the current active bonus
     *
     * @version 1.0.0
     * @since 1.0
     * @return void
     */
    public function get_current_bonus($attr, $id = '')
    {
        $id = ($id == NULL)? $this->stage->id : $id;
        $return = 0;
        $current_date = date('Y-m-d H:i:s');

        $data = $this->get_bonuses($id);
        $bonuses = $bonus_only = [];

        // Stage Fallback
        $ico_date_s = $this->stage->start_date;
        $ico_date_e = $this->stage->end_date;

        // Get based bonus
        $base = (object) [];
        if (!empty($data->base)) {
            $base->amount = $data->base->amount;
            $base->start_date = ($data->base->start_date == $this->def_datetime('datetime_s')) ? $ico_date_s : $data->base->start_date;
            $base->end_date = ($data->base->end_date == $this->def_datetime('datetime_e')) ? $ico_date_e : $data->base->end_date;
            $base->status = $data->base->status;
        }

        $bonus_tires = (object) [];
        $bonuses = $bonus_only = $active_tire = [];
        if (!empty($base)) {
            $bonus_tires->base = $base;
        }
        if (!empty($bonus_tires)) {
            foreach ($bonus_tires as $tire => $tire_opt) {
                if ($tire_opt->status == 1 && $tire_opt->amount >= 1 && $tire_opt->amount <= 100) {
                    // Override date-time if match fallback date
                    $tire_opt->start_date = ($tire_opt->start_date == $this->def_datetime('datetime_s')) ? $ico_date_s : $tire_opt->start_date;
                    $tire_opt->end_date = ($tire_opt->end_date == $this->def_datetime('datetime_e')) ? $ico_date_e : $tire_opt->end_date;

                    if ($current_date >= $tire_opt->start_date && $current_date <= $tire_opt->end_date) {
                        $bonuses[$tire] = $tire_opt;
                        $bonus_only[$tire] = $tire_opt->amount;
                        $active_tire[$tire] = $tire;
                    }
                }
            }
        }

        // Get Amount Bonus
        $bonus_amount = $data->bonus_amount;
        $bonuses_amount = $bonus_on_token = [];
        if (!empty($bonus_amount) && $bonus_amount->status == 1) {
            foreach ($bonus_amount as $tire => $tire_opt) {
                if ($tire != 'status' && $tire_opt->amount >= 1 && $tire_opt->token >= 1) {
                    $bonuses_amount[$tire] = $tire_opt;
                    $bonus_on_token[$tire_opt->token] = $tire_opt->amount;
                }
            }
        }

        $max_bonus = (!empty($bonus_only)) ? max(array_values($bonus_only)) : 0;
        $max_tire = '';

        foreach ($bonus_only as $t => $b) {
            if ($b == $max_bonus) {
                $max_tire = $t;
                break;
            }
        }

        $return = $max_bonus;

        if ($attr == 'active') {
            $return = (!empty($bonuses)) ? $bonuses[$max_tire] : null;
        }
        if ($attr == 'base') {
            $return = (!empty($base)) ? $base : 0;
        }
        if ($attr == 'amount') {
            ksort($bonus_on_token);
            $return = $bonus_on_token;/*(!empty($bonus_on_token)) ? $bonus_on_token : [0, 0]*/;
        }
        if ($attr == 'base-all') {
            $return = (!empty($bonuses)) ? $bonuses : 0;
        }
        if ($attr == 'amount-all') {
            $return = (!empty($bonuses_amount)) ? $bonuses_amount : [0, 0];
        }

        return $return;
    }
    

    /**
     * Get the bonus
     *
     * @version 1.0.0
     * @since 1.0
     * @return void
     */
    public function get_bonuses($id)
    {
        $data = IcoMeta::get_data($id, 'bonus_option');

        $result = $data;

        return $result;
    }
    
    function currency_calculate (Request $request) {
        $data = $request->all();
        $crypto_name = [];
        $post_val = explode("-",$data['data']);
        if($post_val[0] != 'cpm') {
            $data = json_decode(file_get_contents('https://min-api.cryptocompare.com/data/price?fsym='.$post_val[0].'&tsyms=usd')); 
            $spend = $data->USD;
        } else {
            $data1 = json_decode(file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=bnb&tsyms=usd'));
            $spend = round($data1->USD/688,2419171176704);
        }
        if($post_val[1] != 'cpm') {
            $data2 = json_decode(file_get_contents('https://min-api.cryptocompare.com/data/price?fsym='.$post_val[1].'&tsyms=usd'));
            $receive = $data2->USD;
        }
        else {
            $data3 = json_decode(file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=bnb&tsyms=usd'));
            $receive = round($data3->USD/688,2419171176704);
        }
        $diff = $spend / $receive;
        $price = array(
            'spend_price'=>$spend,
            'receive_price'=>$receive,
            'diff'=>$diff
        );
        $currencies = User::Currency;
        $i =0;
        foreach($currencies as $key => $val) {
            if(in_array($key, $post_val)) {
                $array = array('key'=>$key, 'value'=>$val);
                array_push($crypto_name,$array );
            }
            $i++;
        }
        if(in_array('cpm', $post_val)) { 
            $array = array('key'=>'cpm', 'value'=>'CPM Coin');
            array_push($crypto_name,$array );
        }
        return response()->json(['message' => 'successfull', 'price' => $price, 'cryptos' => $crypto_name],200);
    }
    /**
     * For token calcutions 
     * 
     * @end
     * 
     */
     
    
     
    /**
     * Show the application home page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$conn = mysqli_connect('localhost', 'mycrypto_finaluser', 'mycrypto_finaluser_pass', 'mycrypto_finaldash');
        // $conn = mysqli_connect('localhost', 'mirrorpool_finaluser', 'mirrorpool_finaluser_pass', 'mirrorpool_finaldash');
        // $uid = $conn->query("SELECT id FROM users WHERE `email`='" . auth()->user()->email . "'")->fetch_assoc()['id'] ?? 0;
        // $token_balacne = $conn->query("SELECT tokenBalance FROM users WHERE `email`='" . auth()->user()->email . "'")->fetch_assoc()['tokenBalance'] ?? 0;
        // $res = $conn->query("SELECT * FROM transactions WHERE user='$uid' ORDER BY created_at DESC");
        // $trnxs = [];
        // while($row = $res->fetch_assoc()){
        //     $trnxs[] = $row;   
        // } 
        $trnxs = [0 =>0];
        $token_balacne = [0 =>0];
        $id = Auth::user()->id;
        $data = DB::table('users')
            ->join('user_packages', 'user_packages.user_id', '=', 'users.id')->where('users.id', $id)->get();
        $user = User::find($id);
        // dd($user->email);
        $pm_currency = User::Currency;
        $price = json_decode(DB::connection('mysql2')->table('settings')->where('field', '=', 'token_all_price')->get('value'));
        $userBalance = DB::connection('mysql2')->table('users')->where('email', '=', $user->email)->get();
        
        // $userBalance = DB::connection('mysql2')->table('users')->where('email', '=', 'sophiasaintmartin@gmail.com')->get();
        $tokenBalance = !empty($userBalance[0]->tokenBalance) ? $userBalance[0]->tokenBalance : null;
        //  dd($userBalance);
        // dd($tokenBalane);
        // dd($userBalance[0]->tokenBalance);
        $currencies = Setting::active_currency();
        $token_prices = $this->calc_token(1, 'price');
        // dd($token_prices);
        $is_price_show =  Setting::getValue('token_price_show');
        // dd($currencies);
        // dd($is_price_show);
        
        // $encrypted_string = Crypt::encryptString("demo@mycryptopoolmirror.com");
        // dd($encrypted_string);
        
        // $decrypted_string = Crypt::decryptString($encrypted_string);
        // dd($decrypted_string);
		
		/*if($_SERVER['REMOTE_ADDR'] == '207.244.89.161'){
			//echo $user->payment_status;exit;
			if ($user->payment_status == 0 || $user->payment_status == 1) {
				return view('frontend.gateways', [
					'user_data' => $data,
					//'trnxs' => $trnxs,
					//'token_balacne' => $token_balacne
				]);
			}
		}*/
		
        if ($user->payment_status == 0) {
            return redirect()->route('register.payment');
        } else if ($user->payment_status == 1) {
            return redirect()->route('payment.verify');
        } else {
            return view('home', [
                'user_data' => $data,
                'trnxs' => $trnxs,
                'token_balacne' => $token_balacne,
                'pm_currency' => $pm_currency,
                'price' => $price,
                'is_price_show' => $is_price_show,
                'token_prices' => $token_prices,
                'tokenBalance' => $tokenBalance,
            ]);
        }
    }
}
