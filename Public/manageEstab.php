<?php require_once("../includes/initialize.php"); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php"); ?>
<?php isset($_GET['sbscrbdID']) ? null : redirect_to("index.php"); ?>
<?php  
	isset($_GET['sbscrbdID']) ? null : redirect_to("index.php");
	$subsPlan = SubsPlan::find_by_id($_GET['sbscrbdID']);
	$subsPlan ? null : redirect_to("index.php");
	$plan = Plan::find_by_id($subsPlan->plan_id);

	//Restriction in URL redirect user if this isn't his subscription
	$user_subscriptions = SubsPlan::get_owner_subscriptions($user->id);
	$subscriptionIDs = array_map(function($obj) { return $obj->id;}, $user_subscriptions);
	in_array($_GET['sbscrbdID'], $subscriptionIDs) ? null : redirect_to("index.php");

	$condition['key'] = "subs_plan_id";
	$condition['value'] = $subsPlan->id;
	$condition['isNumeric'] = true;

	$all_user_establishment = [];
	$subsPlanEstab = SubsPlanEstab::find_all($condition);

	// foreach ($subsPlanEstab as $key => $eachPlanEstab) {
	// 	$all_user_establishment[] = Establishment::find_by_id($eachPlanEstab->estab_id);
	// }
	
	//$all_user_establishment = array_map(function($obj) { return Establishment::find_by_id($obj->estab_id); }, $subsPlanEstab);
	
	//BECAREFUL USING FIND ALL WITH PARAMETERS - ARGUMENTS ARE NOT ESCAPED
	//$all_user_establishment = Establishment::find_all($condition);
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>
		<?php include("../includes/navigation.php"); ?>
		
		<?php foreach($subsPlanEstab as $key => $eachSubsPlanEstab): ?>
			<?php $eachEstab = Establishment::find_by_id($eachSubsPlanEstab->estab_id); ?>
			<div>
				<p><?php echo htmlentities($eachEstab->name); ?></p>
				<p><a href="manageBranch.php?id=<?php echo urlencode($eachEstab->id); ?>&sbscrbdID=<?php echo urlencode($_GET['sbscrbdID']); ?>">Manage Branches</a>
				<a href="editEstabDetails.php?id=<?php echo urlencode($eachEstab->id); ?>&sbscrbdID=<?php echo urlencode($_GET['sbscrbdID']); ?>">
				Edit Establishment Details</a>
				</p>
				<form action="deleteEstablishment.php?id=<?php echo urlencode($eachSubsPlanEstab->id); ?>" method="POST">
					<p><input type="submit" name="submit" value="delete establishment"/></p>
				</form>
			</div>
		<?php endforeach; ?>
		
		<?php if (count($all_user_establishment) < $plan->estab_no) {  ?>
		<a href="addEstab.php?id=<?php echo urlencode($_GET['sbscrbdID']); ?>">+ ADD ESTABLISHMENT</a>
		<?php } else { ?>
		<p>YOU HAVE REACHED MAXIMUM NUMBER OF ESTABLISHMENT FOR THIS SUBSCRIPTION</p>
		<?php } ?>
	</body>
</html>