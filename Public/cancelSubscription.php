<?php require_once('../includes/initialize.php'); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("index.php"); ?>
<?php

	if ($_POST['submit']) {
		//Security  
		isset($_GET['id']) ? null : redirect_to("index.php");
		$userSubs = SubsPlan::find_all(array('key'=>'owner_id', 'value'=>$user->id, 'isNumeric'=>true));
		$userSubsID = array_map(function($obj) { return $obj->id; }, $userSubs);
		in_array($_GET['id'], $userSubsID) ? null : redirect_to("index.php");
		//End of security

		$subsPlanID = $database->escape_value($_GET['id']);
		$each_transac = SubsPlan::find_by_id($subsPlanID);
		isset($_GET['opt']) ? null : redirect_to("index.php");
		if ($_GET['opt'] === "CANCEL") {
			$stripeSubs = \Stripe\Subscription::retrieve($each_transac->stripe_id);
			$stripeSubs->cancel(array('at_period_end' => true));

			MapprActLog::recordActivityLog("Cancelled a subscription at period end: [SubscriptionID - " . $each_transac->id . "]", $user->id);

		} else if ($_GET['opt'] === "REACT") {
			$stripeSubs = \Stripe\Subscription::retrieve($each_transac->stripe_id); 		
	 		$stripeSubs->plan = $each_transac->plan_id; 
	 		$stripeSubs->save();

	 		MapprActLog::recordActivityLog("Reactivated recurring payments for a subscription: [SubscriptionID - " . $each_transac->id . "]", $user->id);

		} else if ($_GET['opt'] === "RENEW") {
			$subscription = \Stripe\Subscription::create(array(
			  "customer" => $user->stripe_id,
			  "plan" => $each_transac->plan_id
			));			

			$each_transac->status = "ACTIVE";
			$each_transac->stripe_id = $subscription['id'];
			$each_transac->update();

			MapprActLog::recordActivityLog("Renewed a terminated subscription: [SubscriptionID - " . $each_transac->id . "]", $user->id);

		}

		redirect_to("mysubscription.php");
	}

?>