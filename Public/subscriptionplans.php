<?php require_once("../includes/initialize.php"); ?>
<?php  
	$user = $session->is_logged_in() ? User::find_by_id($session->user_id) : false;
	$filtered_plans = Plan::find_by_duration($_GET['type']);
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>
	<?php include("../includes/navigation.php"); ?>
	<?php foreach($filtered_plans as $key => $each_plan): ?>
		<div>
			<p>PRICE: <?php echo $each_plan->cost; ?></p>
			<p>No of Business: <?php echo $each_plan->estab_no; ?></p>
			<p>Total Branches of all Business: <?php echo $each_plan->branch_no; ?></p>
			<?php if ($user) { ?>
			<form action="processpayment.php" method="POST">
				<input type="submit" name="submit" value="SUBMIT"/>
				<input type="hidden" name="planID" value="<?php echo $each_plan->id; ?>" />
			</form>
			<?php } else { ?>
				<a href="registeruser.php">REGISTER NOW</a>
			<?php } ?>
		</div>
	<?php endforeach; ?>
	</body>
</html>

