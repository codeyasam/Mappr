<?php 
	require_once("../includes/initialize.php");
	$answer = true;

	try {
		$coupon = \Stripe\Coupon::retrieve("asdf");
	} catch (\Stripe\Error\InvalidRequest $e) {
		$answer = false;
	}

	if ($answer === true) {
		//var_dump($coupon->valid);
		echo "<pre>";
			print_r($coupon);
		echo "<pre>";
		//echo $coupon->percent_off;	
		if ($coupon->valid && !empty($coupon->percent_off)) {
			echo $coupon->percent_off . " %";
		} else {
			echo $coupon->amount_off / 100;
		}
	}
?>