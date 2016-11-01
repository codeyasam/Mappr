<?php  
	require_once("../includes/initialize.php");
	$plans = Plan::find_all();

	\Stripe\Stripe::setApiKey("sk_test_5lqGe81cTwC39ryIuby7KNu2");

	//Delete All Plans

	// $allPlan = \Stripe\Plan::all();
	// foreach ($allPlan['data'] as $key => $eachPlan) {
	// 	$eachPlan->delete(); 
	// }

	// echo "<pre>";
	// 	print_r($allPlan['data']);
	// echo "</pre>";

	foreach ($plans as $key => $eachPlan) {
		$duration = PlanDuration::find_by_id($eachPlan->plan_interval);
		\Stripe\Plan::create(array(
		  "amount" => (int)number_format($eachPlan->cost, 2, '', ''), //
		  "interval" => $duration->duration_name,
		  "name" => $eachPlan->plan_name,
		  "currency" => "jpy",
		  "id" => $eachPlan->id)
		);		
	}





?>