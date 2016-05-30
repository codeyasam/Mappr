<?php require_once("../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("login.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$condition['key'] = "owner_id";
	$condition['value'] = $user->id;
	$condition['isNumeric'] = true;
	//$transactions = SubsPlan::find_all($condition);
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
	</head>
	<body>
	<?php include("../includes/navigation.php"); ?>
	<table border="1">
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
	</table>

	</body>
</html>