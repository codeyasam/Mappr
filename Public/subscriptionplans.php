<?php require_once("../includes/initialize.php"); ?>
<?php  
	$user = $session->is_logged_in() ? User::find_by_id($session->user_id) : false;
	$filtered_plans = Plan::find_by_duration($_GET['type']);
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
	<div class="container center clearfix">

		<div class="panel panel-warning">
			<div class="panel-heading"><h1 class="heading-label">Choose a plan</h1></div>
			<div class="panel-body">
			<?php foreach($filtered_plans as $key => $each_plan): ?>
				<div class="subscription-plans">
					<?php if ($each_plan->plan_interval == 5) echo "PLAN NAME: " . htmlentities($each_plan->plan_name); ?>
					<h3>Php <?php echo number_format($each_plan->cost, 2, ".", ","); ?></h3>
					<p>No of Business: <?php echo $each_plan->estab_no; ?></p>
					<p>Total Branches of all Business: <?php echo $each_plan->branch_no; ?></p>
					<?php if ($user) { ?>
						<form action="processpayment.php" method="POST">
							<div class="form-group">
								<label>Coupon Code:</label>
								<input type=text size="6" style="width: 30%;display: inline-block;" class="coupon form-control" name="coupon_id" />
								<input class="applyCoupon btn btn-primary" style="display: inline-block;" type="button" value="Apply">
								<span style="font-weight: 700;" class="msg"></span>
							</div>
							<div class="right">
								<script
								src="https://checkout.stripe.com/checkout.js" class="stripe-button"
								data-key="pk_test_YJhO1yO3EP02pBLccVMVNXm2"
								data-amount="<?php echo (int)number_format($each_plan->cost, 2, '', ''); ?>"
								data-name="Demo Site"
								data-description="Widget"
								data-image="/img/documentation/checkout/marketplace.png"
								data-email="<?php echo $user->email; ?>"
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
				      coupon_id_input.siblings('.msg').html('invalid code');
				      console.log(response);
				    }
				  }
				});			
			});

		</script>
	</div>
	<?php include '../includes/footer.php'; ?>
	</body>
</html>

