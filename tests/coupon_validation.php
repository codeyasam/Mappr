<?php 
	require_once("../includes/initialize.php");
	$answer = true;

	try {
		$coupon = \Stripe\Coupon::retrieve("456");
	} catch (\Stripe\Error\InvalidRequest $e) {
		$answer = false;
	}

	if ($answer === true) {
		var_dump($coupon->valid);
	}
?>