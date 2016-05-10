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
					<script
					src="https://checkout.stripe.com/checkout.js" class="stripe-button"
					data-key="pk_test_YJhO1yO3EP02pBLccVMVNXm2"
					data-amount="<?php echo (int)number_format($each_plan->cost, 2, '', '') ?>"
					data-name="Demo Site"
					data-description="Widget"
					data-image="/img/documentation/checkout/marketplace.png"
					data-email="<?php echo $user->email; ?>"
					data-locale="auto">
					</script>
					<input type="hidden" name="plan_id" value="<?php echo $each_plan->id; ?>"/>
				</form>
			<?php } else { ?>
				<a href="registeruser.php">REGISTER NOW</a>
			<?php } ?>
		</div>
	<?php endforeach; ?>
	</body>
</html>

