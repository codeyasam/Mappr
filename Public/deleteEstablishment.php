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
	print_r($_POST);
	print_r($_GET);
	if (isset($_POST['deleteEstab'])) {
		//echo $_GET['id'] . " : " . $_GET['sbscrbdID'];

		//echo "bat di gumagana";

		$currentSubsPlanEstab = SubsPlanEstab::find_by_id($_POST['subsPlanEstabID']);
		$sbscrbdID = $currentSubsPlanEstab->subs_plan_id;

 		$user_subscriptions = SubsPlan::get_owner_subscriptions($user->id);
		$subscriptionIDs = array_map(function($obj) { return $obj->id;}, $user_subscriptions);
		in_array($sbscrbdID, $subscriptionIDs) ? null : redirect_to("index.php");
		SubsPlanEstab::delete_by_id($_GET['id']);
		$branches = EstabBranch::find_all(array('key'=>'estab_id', 'value'=>$currentSubsPlanEstab->estab_id, 'isNumeric'=>true));
		
		foreach ($branches as $key => $branch) {
			BranchReview::delete_by_branch_id($branch->id);
			MapprBookmark::delete_by_branch_id($branch->id);			
		}

		EstabBranch::delete_all(array('key'=>'estab_id', 'value'=>$currentSubsPlanEstab->estab_id, 'isNumeric'=>true));
		EstabGallery::delete_all(array('key'=>'estab_id', 'value'=>$currentSubsPlanEstab->estab_id, 'isNumeric'=>true));
		Establishment::delete_by_id($currentSubsPlanEstab->estab_id);
		redirect_to("manageEstab.php?sbscrbdID=" . $sbscrbdID);		
	}

	//echo "not treated as post";
?>