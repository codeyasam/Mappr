<?php require_once("../includes/initialize.php"); ?>
<?php 
	$user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php");
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

	<table>
		<tr>
			<th>Subscription</th>
			<th>Status</th>
			<th>options</th>
		</tr>
		<?php foreach($transactions as $key => $each_transac):  ?>
			<?php $plan = Plan::find_by_id($each_transac->plan_id); ?>
			
			<tr>
				<td><?php echo $plan->toString(); ?></td>
				<td><?php echo $each_transac->status; ?></td>
				<td><a href="manageEstab.php?sbscrbdID=<?php echo urlencode($each_transac->id); ?>">MANAGE ESTABLISHMENT</a></td>			
				<input type="hidden" name="subsPlanID" value="<?php echo $each_transac->id; ?>"/>
			</tr>
		<?php endforeach; ?>		
	</table>
	</body>
</html>