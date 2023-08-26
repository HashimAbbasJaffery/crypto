<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    const Currency = [
            'usd' => 'US Dollar', 
            'eur' => 'Euro', 
            'gbp' => 'Pound Sterling',
            'cad' => 'Canadian Dollar',
            'aud' => 'Australian Dollar',
            'try' => 'Turkish Lira',
            'rub' => 'Russian Ruble',
            'inr' => 'Indian Rupee',
            'brl' => 'Brazilian Real',
            'nzd' => 'New Zealand Dollar',
            'pln' => 'Polish Złoty',
            'jpy' => 'Japanese Yen',
            'myr' => 'Malaysian Ringgit',
            'idr' => 'Indonesian Rupiah',
            'ngn' => 'Nigerian Naira',
            'mxn' => 'Mexican Peso',
            'php' => 'Philippine Peso',
            'chf' => 'Swiss franc',
            'thb' => 'Thai Baht',
            'sgd' => 'Singapore dollar',
            'czk' => 'Czech koruna',
            'nok' => 'Norwegian krone',
            'zar' => 'South African rand',
            'sek' => 'Swedish krona',
            'kes' => 'Kenyan shilling',
            'nad' => 'Namibian dollar',
            'dkk' => 'Danish krone',
            'hkd' => 'Hong Kong dollar',
            'huf' => 'Hungarian Forint',
            'pkr' => 'Pakistani Rupee',
            'egp' => 'Egyptian Pound',
            'clp' => 'Chilean Peso',
            'cop' => 'Colombian Peso',
            'jmd' => 'Jamaican Dollar',
            'eth' => 'Ethereum', 
            'btc' => 'Bitcoin', 
            'ltc' => 'Litecoin', 
            'xrp' => 'Ripple',
            'xlm' => 'Stellar',
            'bch' => 'Bitcoin Cash',
            'bnb' => 'Binance Coin',
            'usdt' => 'Tether',
            'trx' => 'TRON',
            'usdc' => 'USD Coin',
            'dash' => 'Dash',
            'waves' => 'Waves',
            'xmr' => 'Monero',
        ];

        public function contacts() {
            return $this->belongsToMany(User::class, "user_contact", "user_id", "contact_id");
        }
}
