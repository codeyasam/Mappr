<?php require_once("../includes/initialize.php"); ?>
<?php //echo $_POST['estabID']; ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php"); ?>
<?php //	isset($_GET['id']) ? null : redirect_to("index.php"); ?>
<?php  
	// $user_subscriptions = SubsPlan::get_owner_subscriptions($user->id);
	// $subscriptionIDs = array_map(function($obj) { return $obj->id;}, $user_subscriptions);
	// in_array($_GET['sbscrbdID'], $subscriptionIDs) ? null : redirect_to("index.php");
	// SubsPlanEstab::delete_by_id($_GET['id']);
	// redirect_to("manageEstab.php?sbscrbdID=" . $_GET['sbscrbdID']);
	
	if (isset($_POST['submit'])) {
		//echo $_GET['id'] . " : " . $_GET['sbscrbdID'];
		$currentSubsPlanEstab = SubsPlanEstab::find_by_id($_GET['id']);
		$sbscrbdID = $currentSubsPlanEstab->subs_plan_id;

 		$user_subscriptions = SubsPlan::get_owner_subscriptions($user->id);
		$subscriptionIDs = array_map(function($obj) { return $obj->id;}, $user_subscriptions);
		in_array($sbscrbdID, $subscriptionIDs) ? null : redirect_to("index.php");
		SubsPlanEstab::delete_by_id($_GET['id']);
		EstabBranch::delete_all(array('key'=>'estab_id', 'value'=>$currentSubsPlanEstab->estab_id, 'isNumeric'=>true));
		EstabGallery::delete_all(array('key'=>'estab_id', 'value'=>$currentSubsPlanEstab->estab_id, 'isNumeric'=>true));
		Establishment::delete_by_id($currentSubsPlanEstab->estab_id);
		redirect_to("manageEstab.php?sbscrbdID=" . $sbscrbdID);		
	}


?>