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
					<p>Coupon Code: <input type=text size="6" class="coupon" name="coupon_id" />
					<input class="applyCoupon" type="button" value="Apply"><span class="msg"></span></p>
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
					<input type="hidden" name="plan_id" value="<?php echo $each_plan->id; ?>"/>
				</form>
			<?php } else { ?>
				<a href="registeruser.php">REGISTER NOW</a>
			<?php } ?>
		</div>
	<?php endforeach; ?>
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
			      $('#msg').html("Valid Code!");
			      console.log("valid Code");
			    } else {
			      $(this).siblings('.msg').html("Invalid Code!");
			      coupon_id_input.siblings('.msg').html('invalid code')
			      console.log(response);
			      console.log();	
			    }
			  }
			});			
		});

	</script>
	</body>
</html>

