<?php require_once("../includes/initialize.php"); ?>
<?php  
	$user = $session->is_logged_in() ? User::find_by_id($session->user_id) : false;
	$filtered_plans = Plan::find_by_duration($_GET['type'], true);
	//PlanDuration::find_by_duration_name();
	$currentPlanDuration = PlanDuration::find_by_id($_GET['type']);
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php include '../includes/styles.php'; ?>
	</head>
	<body>
	<header>
		<div class="center">			
			<?php include("../includes/navigation.php"); ?>
		</div>
	</header>
	<div class="banner"></div>
	<div class="container center clearfix">
		<div class="panel panel-default drop-shadow">
			<div class="panel-heading"><h1 class="heading-label"><span class="glyphicon glyphicon-th-large"></span> <span style="text-transform: capitalize;">[ <?php echo Plan::$plan_names[htmlentities($currentPlanDuration->duration_name)]; ?> Plans ]</span></h1></div>
			<div class="panel-body">
				<h1 class="heading-label">Choose type:</h1>
			<?php foreach($filtered_plans as $key => $each_plan): ?>
				<div class="subscription-plans">
					<div class="form-group">
						<?php if ($each_plan->plan_interval == 5) { ?>
							<label><span style="font-size: 1.3em;"><?php echo htmlentities($each_plan->plan_name); ?></span> </label>
							<p><?php echo ucwords(cym_decode_unicode("every " . $each_plan->interval_count . " " . $each_plan->custom_interval)); ?></p>
						<?php } else { ?>
							<label><span style="font-size: 1.3em;"><?php echo htmlentities($each_plan->plan_name); ?></span> </label>						
						<?php } ?>

					</div>
					<div class="form-group">
						<h3>&yen; <?php echo number_format($each_plan->cost, 0, "", ","); ?></h3>
					</div>
					<div class="form-group">
						<label>No. of Business:</label> <?php echo $each_plan->estab_no; ?>
					</div>
					<div class="form-group">
						<label>No. of Branches Per Business:</label> <?php echo $each_plan->branch_no; ?>
					</div>
					<?php if ($user) { ?>
						<form action="processpayment.php" method="POST">
							<div class="form-group">
								<label>Coupon Code:</label>
								<input type=text size="6" style="width: 30%;display: inline-block;" class="coupon form-control" name="coupon_id" />
								<br>
								<br>
								<input class="applyCoupon btn btn-primary" style="display: inline-block;" type="button" value="Apply Coupon">
								<span style="font-family: Impact; letter-spacing: 1px;" class="msg text-danger"></span>
							</div>
							<div class="right">
								<script
								src="https://checkout.stripe.com/checkout.js" class="stripe-button"
								data-key="pk_test_YJhO1yO3EP02pBLccVMVNXm2"
								data-amount="<?php echo (int)number_format($each_plan->cost, 2, '.', ''); ?>"
								data-name="Coin One"
								data-description="Subscription"
								data-image="images/coin_one_logo_large.png"
								data-email="<?php echo $user->email; ?>"
								data-currency="jpy"
								data-locale="auto">
								</script>
							</div>
							<input type="hidden" name="plan_id" value="<?php echo $each_plan->id; ?>"/>
						</form>
					<?php } else { ?>
						<a href="registeruser.php">REGISTER NOW</a>
					<?php } ?>
				</div>
			<?php endforeach; ?>
		</div>
		</div>
		
	</div>
	<?php include '../includes/footer.php'; ?>
		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>	
		<script type="text/javascript">
			$('.applyCoupon').on('click', function() {
				var coupon_id_input = $(this).siblings('.coupon');
				requestData = "coupon_id="+coupon_id_input.val();
				$.ajax({
				  type: "GET",
				  url: "validate-coupon.php",
				  data: requestData,
				  success: function(response){
				    if (response != false) {
				      //$('#msg').html(response + " Discount!");
				      coupon_id_input.siblings('.msg').html(response + " Discount!");
				      console.log(response);
				    } else {
				      //$(this).siblings('.msg').html("Invalid Code!");
				      coupon_id_input.siblings('.msg').html('Invalid Code');
				      console.log(response);
				    }
				  }
				});			
			});

		</script>
	</body>
</html>

