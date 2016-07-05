<?php
	//absolute path definition
	defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
	defined("SITE_ROOT") ? null : define("SITE_ROOT", DS . "var" . DS . "www" . DS . "html" . DS . "thesis");
	defined("LIB_PATH") ? null : define("LIB_PATH", SITE_ROOT . DS . "includes");

	require_once(LIB_PATH . DS . "db_config.php");
	require_once(LIB_PATH . DS . "functions.php");

	require_once(LIB_PATH . DS . "database.php");	
	require_once(LIB_PATH . DS . "databaseObject.php");

	require_once(LIB_PATH . DS . "subsplan.php");

	//load stripe
	require_once(LIB_PATH . DS . "vendor/autoload.php");
	\Stripe\Stripe::setApiKey("sk_test_5lqGe81cTwC39ryIuby7KNu2");	
?>
<?php  
	function stripeHasSubscription($stripe_id, $id) {
		try {
			$each_transac = SubsPlan::find_by_id($id);
			$stripeSubs = \Stripe\Subscription::retrieve($stripe_id);
		} catch (InvalidArgumentException $e) {
			$each_transac->status = "TERMINATED"; $each_transac->update();		
			return false;
		} catch (Stripe\Error\InvalidRequest $e) {
			$each_transac->status = "TERMINATED"; $each_transac->update();			
			return false;
		}
		return $stripeSubs;
	}	

	$allActivePlans = SubsPlan::find_all(array("key" => "status", "value" => "ACTIVE", "isNumeric" => false));
	array_map(function($obj) { stripeHasSubscription($obj->stripe_id, $obj->id); }, $allActivePlans);
?>