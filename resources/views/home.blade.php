@extends('layouts.app',['title'=> __('messages.Dashboard')])
@section('main-content')
@inject('provider', 'App\Http\Controllers\HomeController')
<style>
    #coin_token, #cpm_token {
        font-size: 12px;
    }
</style>
    <div class="row">
        @php
            $data = json_decode(file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=bnb&tsyms=usd'));
            $cpm_value = round($data->USD/688,2419171176704);
            // echo $cpm_value;
            $bc = 'bnb';
            $default_method = 'USD';
            $symbol = 'CPM';
            $method = strtolower($default_method);
            
            $is_method = 1;

            $sl_01 = ($is_method) ? '01 ' : '';
            $sl_02 = ($sl_01) ? '02 ' : '';
            $sl_03 = ($sl_02) ? '03 ' : '';
            // $price = DB::connection('mysql2')->table('settings')->where('field', '=', 'token_all_price')->get('value');
            // print_r(json_decode($price));
            
            // print_r(($price));
        @endphp
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-body">
                <iframe width="100%" height="260px" src="{{ route('widget') }}" name="widgets" id="widgets"
                        frameborder="0"></iframe>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-end mb-3">
                <div class="media">
                    <img src="{{ asset('images/cpm.png') }}" class="mr-2 thumb-sm align-self-center rounded-circle"
                         alt="...">
                    <div class="media-body align-self-center">
                        <!--<p class="mb-1 text-muted">{! __('Token Balance') } <br><small>(will be live soon)</small></p>-->
                        <!--<h5 class="mt-0 text-dark mb-1"><span>{! $token_balacne }</span> {{ __('CPM') }}-->
                        <!--</h5>-->
                    </div>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="crypto-report-history d-flex justify-content-between">
                        <h4>Graph will be live soon!</h4>
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link active" id="all">All</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="day">Day</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="week">Week</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="month">Month</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Order Book</a>
                            </li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="media bg-dark rounded p-1">
                                <img src="{{ asset('images/cpm.png') }}" class="mr-2 align-self-center rounded-circle" style="width:30px;height:30px"
                                     alt="...">
                                <div class="media-body align-self-center">
                                    <div class="coin-bal">
                                        <h6 class="m-0 text-white">CPM Value: <span id="cpm_value">{{ $cpm_value }}</span></h6>
                                    </div>
                                </div><!--end media body-->
                            </div><!--end col-->
                        </div><!--end col-->
                        <div class="col-md-3">
                            <p class="mb-0 p-2 bg-soft-dark rounded"><b>Last: </b>0.25436584</p>
                        </div><!--end col-->
                        <div class="col-md-3">
                            <p class="mb-0 p-2 bg-soft-success rounded"><b>24High: </b>0.25436584</p>
                        </div><!--end col-->
                        <div class="col-md-3">
                            <p class="mb-0 p-2 bg-soft-danger rounded"><b>24Low: </b>0.25436584</p>
                        </div><!--end col-->
                    </div><!-- end row -->
                    <div id="crypto_dash_main" class="apex-charts"></div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body" style="background-color: #2a2a48;">
                    <div class="row">
                        <div class="col-12">
                            <div class="wallet-bal-usd">
                                <h4 class="wallet-title m-0" style="color: #ffffff;">Currency Convertor</h4>
                            </div>
                        </div>
                    </div>
                </div><!--end card-body-->
                <div class="card-body" style="background-color: #c3c8ed;">
                    
                    <div class="row">
                        <div class="col-12">
                            <select class="browser-default custom-select" id="currency_calculate">
                                <option selected>Select Exchange Symbol</option>
                                <option value="{{ strtolower('CPM-ETH') }}">CPM-ETH</option>
                                <option value="{{ strtolower('CPM-USD') }}">CPM-USD</option>
                                <option value="{{ strtolower('CPM-BNB') }}">CPM-BNB</option>
                                <option value="{{ strtolower('CPM-BTC') }}">CPM-BTC</option>
                                <option value="{{ strtolower('ETH-USD') }}">ETH-USD</option>
                                <option value="{{ strtolower('ETH-CPM') }}">ETH-CPM</option>
                                <option value="{{ strtolower('BTC-USD') }}">BTC-USD</option>
                                <option value="{{ strtolower('BTC-CPM') }}">BTC-CPM</option>
                                <option value="{{ strtolower('BNB-USD') }}">BNB-USD</option>
                                <option value="{{ strtolower('BNB-CPM') }}">BNB-CPM</option>
                                <option value="{{ strtolower('USD-CPM') }}">USD-CPM</option>
                                <option value="{{ strtolower('BNB-ETH') }}">BNB-ETH</option>
                            </select>
                        </div><br><br><br>
                        <div class="col-6">
                            <div class="content text-left">
                                <span><b>I have: </b></span><br>
                                <span id="have">CPM Coin (CPM)</span><br>
                                <small>Amount</small><br>
                                <input class="form-control" type="text" min="1" id="h_amount" onkeyup="getTotal()">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="content text-right">
                                <span><b>I Want: </b></span><br>
                                <span id="want">Ethereum (ETH)</span><br>
                                <small>Amount</small><br>
                                <input class="form-control" type="text" id="w_amount" readonly>
                                <input class="form-control" type="hidden" id="diff" readonly>
                            </div>
                        </div>
                        <!--@if($is_method==true)-->
                        <!--   <select class="browser-default custom-select">-->
                        <!--      <option selected>Select Exchange Symbol</option>-->
                        <!--        @foreach($pm_currency as $gt => $full)-->
                        <!--            @if($provider::token($gt) == 1 || $method==$gt)-->
                        <!--              <option>{{ 'CPM - ' }} {{strtoupper($gt) }}        -->
                                        <!--@if($is_price_show==1 && isset($token_prices->$gt))-->
                                        <!--    <span class="pay-amount">{{ $provider::to_num($token_prices->$gt, 'max') }} {{ strtoupper($gt) }}</span>-->
                                        <!--@endif-->
                        <!--              </option>-->
                                     
                                    <!--<div class="payment-item pay-option">-->
                                    <!--    <input class="pay-option-check pay-method" type="radio" id="pay{{ $gt }}" name="paymethod" value="{{ $gt }}" {{ $default_method == strtoupper($gt) ? 'checked' : '' }}>-->
                                    <!--    <label class="pay-option-label{{ (($is_price_show!=1) ? ' d-block' : '' ) }}" for="pay{{ $gt }}">-->
                                    <!--        <span class="pay-title">-->
                                    <!--            <em class="pay-icon pay-icon-{{ $gt }} ikon ikon-sign-{{ ( in_array($gt, ['aud', 'cad', 'nzd', 'nad', 'kes', 'zar', 'clp', 'cop', 'jmd']) ? 'usd' : (($gt=='egp') ? 'gbp' : $gt) ) }}"></em>-->
                                    <!--            <span class="pay-cur">{{ strtoupper($gt) }}</span>-->
                                    <!--        </span>-->
                                    
                                    <!--    </label>-->
                                    <!--</div>       -->
                        <!--            @endif-->
                        <!--        @endforeach-->
                        <!--    </select>-->
                        <!--@endif-->
                    </div>
                    <!--<h2>COMING SOON!</h2>-->
                </div><!--end card-body-->
            </div><!--end card-->
            <div class="card" style="background-color: #000000; border: 4px solid gold; color: gray;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="wallet-bal-usd">
                                <h4 class="wallet-title m-0" style="color: #ffffff;">CPM Evolution Calculator</h4>
                            </div>
                        </div>
                    </div>
                </div><!--end card-body-->
                <div class="card-body pt-0">
                    <div class="row">
                        @if($is_method==true)
                        <div class="col-12">
                           <select class="browser-default custom-select" id="currency_convert">
                              <option selected>Choose currency</option>
                                @foreach($pm_currency as $gt => $full)
                                    @if($provider::token($gt) == 1 || $method==$gt  )
                                      <option value="{{$gt}},{{$full}},{{$token_prices->$gt}}">{{ 'CPM - ' }} {{strtoupper($gt) }}        
                                        @if($is_price_show==1 && isset($token_prices->$gt))
                                            <span class="pay-amount"> ( {{ $provider::to_num($token_prices->$gt, 'max') }} {{ strtoupper($gt) }} )</span>
                                        @endif
                                      </option>
                                     
                                    <!--<div class="payment-item pay-option">-->
                                    <!--    <input class="pay-option-check pay-method" type="radio" id="pay{{ $gt }}" name="paymethod" value="{{ $gt }}" {{ $default_method == strtoupper($gt) ? 'checked' : '' }}>-->
                                    <!--    <label class="pay-option-label{{ (($is_price_show!=1) ? ' d-block' : '' ) }}" for="pay{{ $gt }}">-->
                                    <!--        <span class="pay-title">-->
                                    <!--            <em class="pay-icon pay-icon-{{ $gt }} ikon ikon-sign-{{ ( in_array($gt, ['aud', 'cad', 'nzd', 'nad', 'kes', 'zar', 'clp', 'cop', 'jmd']) ? 'usd' : (($gt=='egp') ? 'gbp' : $gt) ) }}"></em>-->
                                    <!--            <span class="pay-cur">{{ strtoupper($gt) }}</span>-->
                                    <!--        </span>-->
                                    
                                    <!--    </label>-->
                                    <!--</div>       -->
                                    @endif
                                @endforeach
                            </select>
                        </div><br><br><br>
                        <div class="row">
                            <div class="col-12"><h5 class="wallet-title" style="background-color: gold; padding: 4px; text-align: center;">Your Current CPM Coin Balnace is :</h5></div><br>
                            <div class="col-6">
                                <div class="content text-left">
                                    <span id="cpm_token">CPM Coin (CPM)</span><br><b>
                                    <input class="form-control" type="text" id="cpm_val" value=" {{ $tokenBalance }}" readonly></b>
                                    <input class="form-control" type="hidden" id="cpm_val_single" value="{{$token_prices->usd }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="content text-left">
                                    <span id="coin_token">American Dollar (USD)</span><br><b>
                                    <!--<small>Amount</small><br>-->
                                    <input class="form-control" type="text" id="coin_val" value=" {{ $tokenBalance *  $token_prices->usd }}" readonly ></b>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-12"><h5 class="wallet-title" style="background-color: gold; padding: 4px; text-align: center;">Your New CPM Coin value if it increase at:</h5></div><br>
                            <div class="col-6">
                                <div class="content text-left">
                                    <span id="cpm_token">Your CPM Balance</span><br><b>
                                    <input class="form-control" type="text" id="new_cpm_val" value=" "  onkeyup="getNewBalance()"></b>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="content text-left">
                                    <span id="coin_token">CPM Increase at (USD):</span><br><b>
                                    <!--<small>Amount</small><br>-->
                                    <input class="form-control" type="text" id="new_coin_val" value=""  onkeyup="getNewCPM()" ></b>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-6">
                                <div class="content text-left">
                                    <span id="cpm_token" style="color: gold;">Progression %</span><br><b>
                                    <input class="form-control" type="text" id="progression" value=" " readonly style="color: red;"></b>
                                    <input class="form-control" type="hidden" id="progression_1" value=" " readonly style="color: red;"></b>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="content text-left">
                                    <span id="coin_token" style="color: gold;">New Balance (USD) </span><br><b>
                                    <!--<small>Amount</small><br>-->
                                    <input class="form-control" type="text" id="new_cpm_bln" value="" readonly style="color: red;"></b>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!--<h2>COMING SOON!</h2>-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div> <!-- end row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body ">
                    <h4 class="header-title mt-0 mb-3">Transaction History</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr class="data-item data-head">
                                <th class="data-col tnx-status dt-tnxno">{{ __('Tranx NO') }}</th>
                                <th class="data-col dt-token">{{ __('Tokens') }}</th>
                                <th class="data-col dt-amount">{{ __('Amount') }}</th>
                                <th class="data-col dt-base-amount">ETH {{ __('Amount') }}</th>
                                <th class="data-col dt-account">{{ __('To') }}</th>
                                <th class="data-col dt-type tnx-type">
                                    <div class="dt-type-text">{{ __('Type') }}</div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($trnxs) && 1==0)   // Testing Purpose
                            @foreach($trnxs as $trnx)
                                @php
                                    $text_danger = ( $trnx['tnx_type']=='refund' || ($trnx['tnx_type']=='transfer' && $trnx['extra']=='sent') ) ? ' text-danger' : '';
                                @endphp
                                <tr>
                                    <th>
                                        <div>{{ $trnx['tnx_id'] }}</div>
                                        {{ $trnx['tnx_time'] }}
                                    </th>
                                    <td>{{ $trnx['tokens'] }}</td>
                                    <td>
                                        @if ($trnx['tnx_type']=='referral'||$trnx['tnx_type']=='bonus')
                                            <div>~</div>
                                        @else
                                            <div class="{{ $text_danger }}">{{ $trnx['amount'] }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($trnx['tnx_type']=='referral'||$trnx['tnx_type']=='bonus')
                                            <div>~</div>
                                        @else
                                            <div class="{{ $text_danger }}">{{ $trnx['base_amount'] }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $pay_to = ($trnx['payment_method']=='system') ? '~' : ( ($trnx['payment_method']=='bank') ? explode(',', $trnx['payment_to']) : $trnx['payment_to'] );
                                            $extra = ($trnx['tnx_type'] == 'refund') ? (is_json($trnx['extra'], true) ?? $trnx['extra']) : '';
                                        @endphp
                                        @if($trnx['tnx_type'] == 'refund')
                                            <div>{{ $trnx['details'] }}</div>
                                        @else
                                            @if($trnx['refund'] != null)
                                                <div class="text-danger">{{ __('Refunded') }}
                                                    #{{ $trnx['refund'] }}</div>
                                            @else
                                                <div>{{ ($trnx['payment_method']=='bank') ? $pay_to[0] : ( ($pay_to) ? substr($pay_to,0,5).'*****'.substr($pay_to,-5) : '~' ) }}</div>
                                            @endif
                                            <span
                                                class="sub sub-date">{{ ($trnx['checked_time']) ? $trnx['checked_time'] : $trnx['created_at'] }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="badge badge-info">{{ ucfirst($trnx['tnx_type']) }}</div>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div>

@endsection
@yield('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
// $(function() { // after the page has loaded..
    // alert('Imagination');

       
// });
 </script>
@push('scripts')
    <script> 
        $('#currency_calculate').change(function() {
            var optionSelected = $(this);
            var valueSelected  = optionSelected.val(); //.toLowerCase();
            var split = valueSelected.split("-");
            var h_amount = $("#h_amount").val();
            // console.log( h_amount );
            // console.log(valueSelected);
            $.ajax({
                method: 'POST',
                url: 'currency_calculate',
                data: {"_token": "{{ csrf_token() }}", 'data':valueSelected},
                success: function( re ){
                    // console.log(re.cryptos);
                    var spend = re.cryptos.filter(function (el) {
                      return el.key === split[0].toLowerCase();
                    });
                    // console.log( spend );
                    var receive = re.cryptos.filter(function (el) {
                      return el.key === split[1].toLowerCase();
                    });
                    $("#have").text(spend[0]['value'] +"("+split[0].toUpperCase()+")");
                    $("#want").text(receive[0]['value'] +"("+split[1].toUpperCase()+")");
                    $("#diff").val(re.price['diff']);
                    if(h_amount == '' || h_amount == 1) {
                        $("#h_amount").val('1');
                        $("#w_amount").val(re.price['diff']);
                    } else {
                        var rec_amt = h_amount * re.price['diff'];
                        $("#h_amount").val(h_amount);
                        $("#w_amount").val(rec_amt);
                    }
                    
                    // console.log( re );
                },
                error: function( e ) {
                    console.log(e);
                }
            });
        });
        
        function getTotal() {
            var h_amount = $("#h_amount").val();
            var w_amount = $("#diff").val();
            var rec_amt = h_amount * w_amount;
            $("#w_amount").val(rec_amt);
        }
        
        $('#currency_convert').change(function() {
            var optionSelected = $(this);
            var valueSelected  = optionSelected.val(); //.toLowerCase();
            var split = valueSelected.split(",");
            var coin_val = $("#cpm_val").val() * split[2];
            // console.log(split);
            // console.log(coin_val);
            $("#coin_token").text(split[1] +"("+split[0].toUpperCase()+")");
            $("#coin_val").val(coin_val);
            $("#cpm_val_single").val(split[2]);
            
        });
        
        function getNewBalance() {
            var new_cpm_val = $("#new_cpm_val").val();
            var cpm_value = $("#cpm_value").text(); // $("#cpm_val_single").val();
            var increase_at_val = $("#new_coin_val").val();
            // alert(w_amount);
            // var rec_amt = new_cpm_val * cpm_value;
            var progression = $("#progression_1").val(); //((rec_amt / cpm_value) * 100).toFixed(2);
            var new_cpm_bln = (new_cpm_val * cpm_value * (progression / 100)).toFixed();
            // $("#new_coin_val").val(rec_amt);
            // $("#progression").val(progression+" %");
            $("#new_cpm_bln").val(new_cpm_bln);
        }
        
        function getNewCPM() {
            var increase_at_val = $("#new_coin_val").val();
            var cpm_value =  $("#cpm_value").text(); //$("#cpm_val_single").val(); // 0.45282;
            // var rec_amt = increase_at_val / cpm_value;
            var new_cpm_blc = $("#new_cpm_val").val();
            var progression = ((increase_at_val / cpm_value) * 100).toFixed(2);
            var new_cpm_bln = (new_cpm_blc * cpm_value * (progression / 100)).toFixed();
            
            // $("#new_cpm_val").val(rec_amt);
            $("#progression").val(progression+" %");
            $("#progression_1").val(progression);
            $("#new_cpm_bln").val(new_cpm_bln);
        }
        // setInterval(() => {
        //     document.getElementById('widgets').contentDocument.location.reload(true);
        //     fetch(`https://min-api.cryptocompare.com/data/price?fsym=bnb&tsyms=usd`).then(r => r.json()).then(r => {
        //         $('#cpm_value').text((r['USD'] / 688).toFixed(7))
        //     })
        // }, 5000)
    </script>
@endpush