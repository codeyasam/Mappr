<?php require_once("../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("login.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$condition['key'] = "owner_id";
	$condition['value'] = $user->id;
	$condition['isNumeric'] = true;
	//$transactions = SubsPlan::find_all($condition);
	//$user->stripe_id = "cus_9Jvf01ISXoiUSO"; //debug 
	$transactions = "";
	if (!empty($user->stripe_id)) 
		$transactions = \Stripe\Invoice::all(array("customer" => $user->stripe_id));
	// echo "<pre>";
	// 	print_r($transactions);
	// echo "</pre>";
	// var_dump($transactions["data"][0]);
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
	<div class="container center">
		<div class="panel panel-default">
			<div class="panel-heading"><h1 class="heading-label"><span class="glyphicon glyphicon-check"></span> Transactions</h1></div>
			<div class="panel-body"></div>

			<?php if (!empty($transactions)) { ?>
				<table class="table table-hover data">
					<tr>
						<th>Price</th>
						<th>Discount</th>
						<th>Amount Paid</th>
						<th>Date: (timezone - server)</th>
					</tr>	
				<?php for ($i = 0; $i < count($transactions['data']); $i++) { ?>
					<?php $each_transac = $transactions['data'][$i]; ?>
					<?php $total_amount = $each_transac->total; ?>
					<?php $subtotal = $each_transac->subtotal; ?>
					<?php  
						$discount = "none";
						if (!empty($each_transac->discount)) {
							$coupon = $each_transac->discount->coupon;
							if (!empty($coupon->percent_off)) {
								$discount = $coupon->percent_off . "%";
							} else {
								$discount = "&yen;" . $coupon->amount_off . " " . $coupon->currency;
							}
						}
			  		?>
					<tr>
						<td>&yen;<?php echo htmlentities($subtotal); ?></td>
						<td><?php echo htmlentities($discount); ?></td>
						<td>&yen;<?php echo htmlentities($total_amount); ?></td>
						<td><?php echo htmlentities(format_date(get_mysql_datetime($each_transac->date))); ?></td>
					</tr>
				<?php } ?>
			<?php } else { ?>
				<div class="panel-body">
					<?php echo "You dont have any transactions yet. "; ?>	
					<a href="subscription.php">Purchase a subscription here.</a>
				</div>
			<?php } ?>
			</table>
		</div>
	</div>
	<?php include '../includes/footer.php'; ?>
	</body>
</html>