<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
    <title>My Crypto Pool Mirror</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}">
    <!-- App css -->
    <link href="../metrica/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../metrica/css/jquery-ui.min.css" rel="stylesheet">
    <link href="../metrica/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="../metrica/css/metisMenu.min.css" rel="stylesheet" type="text/css"/>
    <link href="../metrica/css/app.min.css" rel="stylesheet" type="text/css"/>
	<link href="../metrica/css/all.css" type="text/css">
    <style>
        .content {
			margin:0 auto;
			width: 90%;
        }
		body{background: #f5f5f5}.rounded{border-radius: 1rem}.nav-pills .nav-link{color: #555}.nav-pills .nav-link.active{color: white}input[type="radio"]{margin-right: 5px}.bold{font-weight:bold}
		@media screen and (max-width: 925px) {
		  .content {
			  width:100%;
		  }
		}
		.cus-button {
			padding: 10px 25px;
			background: #000046;
			background: -moz-linear-gradient(left, #000046 0%, #1cb5e0 100%);
			background: -webkit-linear-gradient(left, #000046 0%, #1cb5e0 100%);
			background: linear-gradient(to right, #000046 0%, #1cb5e0 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#000046", endColorstr="#1cb5e0",GradientType=1 );
			border-radius: 30rem;
			border: none;
			color: #fff;
			font-size: 16px;
			/*margin-left: auto;*/
			margin:0 auto;
			display: block;
			cursor: pointer;
		}
		.cus-button i {
			background: #000046;
			background: -moz-linear-gradient(left, #000046 0%, #1cb5e0 100%);
			background: -webkit-linear-gradient(left, #000046 0%, #1cb5e0 100%);
			background: linear-gradient(to right, #000046 0%, #1cb5e0 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#000046", endColorstr="#1cb5e0",GradientType=1 );
			width: 30px;
			height: 30px;
			line-height: 30px;
			text-align: center;
			border-radius: 50%;
		}
		.form-group{
			text-align:left;
		}
		.nav-pills .nav-item.show .nav-link, .nav-pills .nav-link.active{
			background: linear-gradient(to right, #000046 0%, #1cb5e0 100%);
		}
		.nav-link{
			padding: 10px 25px;
    		border-radius: 7px !important;
		}
		.nav-link.active i{
			color:#ffffff !important;
		}
		.paymentErrors{
			display:none;
			padding: 10px;
    		text-align: left;
		}
    </style>
</head>
<body>
<div class="content-wrapper position-relative w-100 vh-100">
    <div class="content text-center">
        <div class="container py-5">
        <!-- For demo purpose -->
        <!--<div class="row mb-4">
            <div class="col-lg-12 mx-auto text-center">
            	<img src="../frontend/images/logo.png" style="display: inline-block;width: 80px;">
                <h2 class="display-6" style="display: inline-block;padding-left: 10px;">CryptoPoolMirror</h2>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-lg-12 mx-auto text-center">
                <h4 class="display-6"><?php echo $user_data->first_name.' '.$user_data->first_name; ?></h4>
                <p>Pre-launch offer for CPM membership (** Price is subject to change without notice_Reserve your spot now!!)</p>
            </div>
        </div>-->
        <div class="row">
        	<div class="col-md-6 mx-auto text-left" style="margin-top: 15px;">
            	<img src="../frontend/images/logo.svg" style="display: inline-block;">
                <!--<h2 class="display-6" style="display: inline-block;padding-left: 10px;">CryptoPoolMirror</h2>-->
            </div>
            <div class="col-md-6 mx-auto" style="margin-top: 15px;">
            	<div class="card">
                	<div class="card-header text-left">
                        <h4 class="display-6"><?php echo $user_data->first_name.' '.$user_data->first_name; ?></h4>
                        <p>Pre-launch offer for CPM membership (** Price is subject to change without notice_Reserve your spot now!!)</p>
                        <h4 style="text-align:left;">Total: $<?php echo number_format((float)$memberhsip_fee, 2, '.', ''); ?></h4>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-header">
                        <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                            <!-- Credit card form tabs -->
                            <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                                <li class="nav-item"> <a data-toggle="pill" href="#credit-card" class="nav-link active "> <i class="fas fa-credit-card mr-2" style="color:#1434CB;"></i> Credit Card </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#paypal" class="nav-link "> <i class="fab fa-paypal mr-2" style="color:#253B80;"></i> Paypal </a> </li>
                                <li class="nav-item"> <a data-toggle="pill" href="#net-banking" class="nav-link "> <img src="{{asset('metrica/images/cb.png')}}" style="width:15px;margin-right: 0.5rem !important;"> Coinbase </a> </li>
                            </ul>
                        </div> <!-- End -->
                        <!-- Credit card form content -->
                        <div class="tab-content">
                            <!-- credit card info-->
                            <div id="credit-card" class="tab-pane fade show active pt-3">
                            	
                                @if(Session::has('stripe_error'))
                                    <div class="alert alert-danger">{{Session::get('stripe_error')}}
                                        <button type="button" data-dismiss="alert" class="close">&times;</button>
                                    </div>
                                @endif
                                <form method="post" id="pre_purchase_form" action="{{ route('payment.verify_stripe') }}">
                                	@csrf
                                	<p class="paymentErrors alert-danger"></p>
                                    <div class="form-group"> <label for="cardNumber">
                                            <h6>Card number</h6>
                                        </label>
                                        <div class="input-group"> <input type="text" name="card_number" id="credit_card_number" placeholder="Valid card number" class="form-control " required>
                                            <div class="input-group-append"> <span class="input-group-text text-muted"> <i class="fab fa-cc-visa mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span> </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group"> <label><span class="hidden-xs">
                                                        <h6>Expiration Date</h6>
                                                    </span></label>
                                                <div class="input-group">
                                                	
                                                    <select class="form-control" name="card_expiry_month" id="card_expiry_month">
                                                        <option value="" selected disabled>Month</option>
                                                        <option value="01">Jan</option>
                                                        <option value="02">Feb</option>
                                                        <option value="03">Mar</option>
                                                        <option value="04">Apr</option>
                                                        <option value="05">May</option>
                                                        <option value="06">June</option>
                                                        <option value="07">July</option>
                                                        <option value="08">Aug</option>
                                                        <option value="09">Sep</option>
                                                        <option value="10">Oct</option>
                                                        <option value="11">Nov</option>
                                                        <option value="12">Dec</option>
                                                    </select>
                                                    <select class="form-control" name="card_expiry_year" id="card_expiry_year">
                                                    	<?php
														$year	= date('Y');
														?>
                                                        <option value="" selected disabled>Year</option>
                                                        <?php
														for($i=0; $i<30; $i++){
															$val	= $year+$i;
														?>
															<option value="<?php echo $val; ?>"><?php echo $val; ?></option>
														<?php
														}
														?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group mb-4"> <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                                                    <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                                </label> <input type="text" name="cvc_number" id="cvc_number" required class="form-control"> </div>
                                        </div>
                                 <div class="col-sm-12" style="float: left;text-align: left;">
                                 <input type="checkbox" id="cardcheck" name="paypalcheck" >
                                
                                    <p>By submitting payment information bellow i <u style="color:red"><?php echo $user_data->first_name.' '.$user_data->last_name; ?></u> acknowledge that i am authorized to use it and that i am responsible for its use.
                                 </p>
                                    <p>By becoming a member of CPM and paying your membership fee, you acknowledge and accept that your subscription is non reserve you place in our 
                                    coming during the prelaunch. All the membership fees collected during the prelaunch period it will be used for developing the platform and making and most appropriate
                                    agreements with the right partners. This will support the project and the community. In accessing and using the CPM's website, you acknowledge that you have reviewed 
                                    this legal Notice and understand and agree to the terms and conditions set forth. If you do not agree to the terms and conditions below, do not access or utilize this
                                    website in any way.</p>
                                
                              </div>
                                    </div>
                                     
                                    <div class="card-footer"> <button id="confirmpay" type="submit" class="cus-button"> Confirm Payment <i class="fas fa-angle-right"></i></button>
                                </form>
                            </div>
                           <div class="col-sm-12" style="float: left;text-align: left;">
                            <p>Note: <span style="color:red">You must read and accept to agreement</span> by checking the box above to be directed to a secure payment gateway. Once the payment process is complete, you will be redirected to the website.</p>
                            </div>
                        </div> <!-- End -->
                        <!-- Paypal info -->
                        <div id="paypal" class="tab-pane fade pt-3">
                            <p>
                            	<form id="form_visa_card_process" action="<?php echo $paypal_url;?>" method="post" style="display: inline-block;">
                                    <input type="hidden" name="business" value="<?php echo $paypal_email;?>">
                                    <input type="hidden" name="cmd" value="_xclick">
                                    <input type="hidden" name="item_name" value="CPM membership">
                                    <input type="hidden" name="custom" value="<?php echo $user_data->user_id;?> ">
                                    <input type="hidden" name="amount" value="<?php echo $memberhsip_fee;?>">
                                    <input type="hidden" name="shipping" value="0">
                                    <input type="hidden" name="currency_code" value="USD">
                                    <input type="hidden" name="cancel_return" value="{{ route('home') }}">
                                    <input type="hidden" name="notify_url" value="{{ route('verify_paypal_webhook') }}">
                                    <input type="hidden" name="return" value="{{ route('home') }}">
                                <div class="col-sm-12" style="float: left;text-align: left;">
                                 <input type="checkbox" id="paypalcheck" name="paypalcheck" >
                                    <p>By submitting payment information bellow i <u style="color:red"><?php echo $user_data->first_name.' '.$user_data->last_name; ?></u> acknowledge that i am authorized to use it and that i am responsible for its use.
                                 </p>
                                    <p>By becoming a member of CPM and paying your membership fee, you acknowledge and accept that your subscription is non reserve you place in our 
                                    coming during the prelaunch. All the membership fees collected during the prelaunch period it will be used for developing the platform and making and most appropriate
                                    agreements with the right partners. This will support the project and the community. In accessing and using the CPM's website, you acknowledge that you have reviewed 
                                    this legal Notice and understand and agree to the terms and conditions set forth. If you do not agree to the terms and conditions below, do not access or utilize this
                                    website in any way.</p>
                                
                              </div>
                                    <button type="submit" id="paybutton" class="cus-button">Proceed to Paypal <i class="fab fa-paypal mr-2"></i></button>
                                </form>
                           <div class="col-sm-12" style="float: left;text-align: left;">
                            <p>Note: <span style="color:red">You must read and accept to agreement</span> by checking the box above to be directed to a secure payment gateway. Once the payment process is complete, you will be redirected to the website.</p>
                            </div>
                        </div> <!-- End -->
                        <!-- bank transfer info -->
                        
                        <div id="net-banking" class="tab-pane fade pt-3">
                            <div class="col-sm-12" style="float: left;text-align: left;">
                                 <input type="checkbox" id="coincheck" name="paypalcheck" >
                                
                                    <p>By submitting payment information bellow i <u style="color:red"><?php echo $user_data->first_name.' '.$user_data->last_name; ?></u> acknowledge that i am authorized to use it and that i am responsible for its use.
                                 </p>
                                    <p>By becoming a member of CPM and paying your membership fee, you acknowledge and accept that your subscription is non reserve you place in our 
                                    coming during the prelaunch. All the membership fees collected during the prelaunch period it will be used for developing the platform and making and most appropriate
                                    agreements with the right partners. This will support the project and the community. In accessing and using the CPM's website, you acknowledge that you have reviewed 
                                    this legal Notice and understand and agree to the terms and conditions set forth. If you do not agree to the terms and conditions below, do not access or utilize this
                                    website in any way.</p>
                                
                              </div>
                            <div class="form-group">
                                <p> <a href="{{ route('payment.coinbase') }}"><button type="button" id="coinpay" class="cus-button">Proceed Payment <i class="fas fa-angle-right"></i> </button></a> </p>
                            </div>
                           <div class="col-sm-12" style="float: left;text-align: left;">
                            <p>Note: <span style="color:red">You must read and accept to agreement</span> by checking the box above to be directed to a secure payment gateway. Once the payment process is complete, you will be redirected to the website.</p>
                            </div>
                        </div> <!-- End -->
                        <!-- End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery  -->
<script src="../metrica/js/jquery.min.js"></script>
<script src="../metrica/js/jquery-ui.min.js"></script>
<script src="../metrica/js/bootstrap.bundle.min.js"></script>
<script src="../metrica/js/metismenu.min.js"></script>
<script src="../metrica/js/waves.js"></script>
<script src="../metrica/js/feather.min.js"></script>
<script src="../metrica/js/jquery.slimscroll.min.js"></script>

<script src="../metrica/plugins/apexcharts/irregular-data-series.js"></script>
<script src="../metrica/pages/jquery.crypto-dashboard.init.js"></script>
<!-- App js -->
<script src="../metrica/js/app.js"></script>
@isset($scripts)
    @foreach($scripts as $script)
        <script src="{{asset('frontend/js/'.$script.'.js')}}"></script>
    @endforeach
@endisset

<script>
$(function() {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
<script>
	Stripe.setPublishableKey('<?php echo $publish_key; ?>');
	$(document).ready(function() 
	{
		$('#confirmpay').attr('disabled','disabled');
		$('#paybutton').attr('disabled','disabled');
		$('#coinpay').attr('disabled','disabled');
		
		$('#cardcheck').click(function(){
		    if($("#cardcheck").is(':checked')){
             $('#confirmpay').removeAttr('disabled');
            //  #('username').show();
		    }else{
		        $('#confirmpay').attr('disabled','disabled');
		    }
		});
		$('#paypalcheck').click(function(){
         	    if($("#paypalcheck").is(':checked')){
                     $('#paybutton').removeAttr('disabled');
                    //  $('#username').show();
         	    }else{
         	        $('#paybutton').attr('disabled','disabled');
         	       /* $('#username').hide();*/
         	    }
         	});
         		$('#coincheck').click(function(){
		    if($("#coincheck").is(':checked')){
             $('#coinpay').removeAttr('disabled');
            //  #('username').show();
		    }else{
		        $('#coinpay').attr('disabled','disabled');
		    }
		});
		$("#pre_purchase_form").submit(function(event) 
		{
			$(".paymentErrors").hide();
			<?php
			if(empty($publish_key) || empty($secret_key))
				{ ?>
					alert('Something went wrong,Please Try Later.');
					return false;
				<?php } ?>
			//var stripeToken	= $('#stripeToken').val();
			//console.log(stripeToken);
			//if(stripeToken == ''){
				$('#purchase_submit').attr("disabled", "disabled");
				// create stripe token to make payment
				console.log('clicked');
				Stripe.createToken({
					number: $('#credit_card_number').val(),
					cvc: $('#cvc_number').val(),
					exp_month: $('#card_expiry_month option:selected').val(),
					//exp_year: $('#card_expiry_year').val()
					exp_year: $('#card_expiry_year option:selected').val()
				}, handleStripeResponse);
				//console.log('false');
				return false;
			/*} else{
				console.log('true');
			}*/
		});
	});
	
	// handle the response from stripe
	function handleStripeResponse(status, response) 
	{
		console.log(JSON.stringify(response));
		//$('#purchase_submit').removeAttr("disabled");
		if (response.error) 
		{
			//$('#makePayment').attr("disabled", "disabled");
			//$('#purchase_submit').removeAttr("disabled");
			$(".paymentErrors").html(response.error.message);
			$(".paymentErrors").show();
		}
		else
		{
			var payForm		= $("#pre_purchase_form");
			//get stripe token id from response
			var stripeToken	= response['id'];
			//console.log(stripeToken);
			//set the token into the form hidden input to make payment
			//$('#stripeToken').val(stripeToken);
			//$('#pre_purchase_form').removeAttr('id');
			//payForm.submit();
			payForm.append("<input type='hidden' name='stripeToken' value='" + stripeToken + "' />");
			payForm.get(0).submit();
		}
	}
</script>
</body>
</html>

