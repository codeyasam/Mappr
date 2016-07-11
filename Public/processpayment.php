<?php require_once("../includes/initialize.php"); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("index.php"); ?>
<?php
	// print_r($_POST['stripeToken']);
	// var_dump($_POST['stripeToken']);
	// var_dump($_POST);

	// echo "<pre>";
	// 	print_r($_POST);
	// echo "</pre>";
	// echo "poop";  
	//var_dump($_POST['plan_id']);

	$answer = true;
	$coupon_id = trim($_POST['coupon_id']);
	try {
		$coupon = \Stripe\Coupon::retrieve($coupon_id);  
	} catch (\Stripe\Error\InvalidRequest $e) {
		$answer = false;
	} catch (InvalidArgumentException $e) {
		$answer = false;
	}

	if ($answer === true) {
		$coupon_id = $coupon->valid === false ? null : $coupon->id;
	} else $coupon_id = null;
	//$coupon_id = $answer === false ? null : $coupon->id;
	
	$customer = "";
	if (empty($user->stripe_id)) {
		$customer = \Stripe\Customer::create(array(
		  "source" => $_POST['stripeToken'],
		  "email" => $_POST['stripeEmail'])
		);
	
		$user->stripe_id = $customer['id'];
		$user->update();
	} else {
		$customer = \Stripe\Customer::retrieve($user->stripe_id);
	}

	$subscription = \Stripe\Subscription::create(array(
	  "customer" => $customer['id'],
	  "plan" => $_POST['plan_id'],
	  "coupon" => $coupon_id
	));	

	$subs_plan = new SubsPlan();
	$subs_plan->owner_id = $user->id;
	$subs_plan->plan_id = $_POST['plan_id'];
	$subs_plan->stripe_id = $subscription['id'];
	$subs_plan->create();

	redirect_to("mysubscription.php");
	

	// echo "<pre>";
	// 	print_r($subscription);
	// echo "</pre>";

	//if (isset($_POST['submit'])) {
		//Paypal Process commented
		//echo "here";
		// if ($session->is_logged_in()) {
		// 	$paypalObj = new PaypalMappr();
		// 	$paypalObj->addItem(Plan::find_by_id($_POST['planID']));

		// 	$paypalObj->makePayment($_POST['planID'], $session->user_id);
		// }

		
	//}
?>