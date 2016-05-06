<?php require_once("../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("login.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$condition['key'] = "owner_id";
	$condition['value'] = $user->id;
	$condition['isNumeric'] = true;
	$transactions = SubsPlan::find_all($condition);
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>
	<?php include("../includes/navigation.php"); ?>
	<?php foreach($transactions as $key => $each_transac):  ?>
		<?php $plan = Plan::find_by_id($each_transac->plan_id); ?>
		<div>
			<p><?php echo $plan->toString(); ?><a href="">CHECK DETAILS</a></p>
		</div>
	<?php endforeach; ?>
	</body>
</html>