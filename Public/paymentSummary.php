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
	<div class="container center">

		<h1>Transactions</h1>
		<div class="panel panel-warning">
			<div class="panel-heading"><h1 class="heading-label">Transactions</h1></div>
			<div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>

			<?php if (!empty($transactions)) { ?>
				<table class="data">
					<tr>
						<th>PRICE</th>
						<th>DISCOUNT</th>
						<th>AMOUNT PAID</th>
						<th>DATE: (timezone - server)</th>
					</tr>	
				<?php for ($i = 0; $i < count($transactions['data']); $i++) { ?>
					<?php $each_transac = $transactions['data'][$i]; ?>
					<?php $total_amount = $each_transac->total / 100; ?>
					<?php $subtotal = $each_transac->subtotal / 100; ?>
					<?php  
						$discount = "none";
						if (!empty($each_transac->discount)) {
							$coupon = $each_transac->discount->coupon;
							if (!empty($coupon->percent_off)) {
								$discount = $coupon->percent_off . "%";
							} else {
								$discount = $coupon->amount_off / 100 . " " . $coupon->currency;
							}
						}
			  		?>
					<tr>
						<td><?php echo htmlentities($subtotal); ?></td>
						<td><?php echo htmlentities($discount); ?></td>
						<td><?php echo htmlentities($total_amount); ?></td>
						<td><?php echo htmlentities(format_date(get_mysql_datetime($each_transac->date))); ?></td>
					</tr>
				<?php } ?>
			<?php } else { ?>
			<?php echo "you dont have any transactions yet. "; ?>	
			<a href="subscription.php">purchase a subscription here</a>
			<?php } ?>
			</table>
		</div>
	</div>
	<?php include '../includes/footer.php'; ?>
	</body>
</html>