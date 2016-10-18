<?php require_once("../includes/initialize.php"); ?>
<?php 
	$user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php");
	$user = User::find_by_id($session->user_id);
	$condition['key'] = "owner_id";
	$condition['value'] = $user->id;
	$condition['isNumeric'] = true;
	$transactions = SubsPlan::find_all($condition);	
?>
<?php  //Handle 
	function stripeHasSubscription($stripe_id, $id) {
		try {
			$each_transac = SubsPlan::find_by_id($id);
			$stripeSubs = \Stripe\Subscription::retrieve($stripe_id);
		} catch (InvalidArgumentException $e) {
			$each_transac->status = "TERMINATED"; $each_transac->update();		
			return false;
		} catch (Stripe\Error\InvalidRequest $e) {
			$each_transac->status = "TERMINATED"; $each_transac->update();			
			return false;
		}
		return $stripeSubs;
	}
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
		<div class="panel panel-warning">
			<div class="panel-heading"><h1 class="heading-label">My Subscription</h1></div>
			<div class="panel-body">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
			<table id="subsContainer" class="table table-hover data">
				<tr class="">
					<th>#</th>
					<th>Subscription</th>
					<th>Status</th>
					<th colspan="3">Options</th>
				</tr><!-- 
				<tr>
					<td></td>
					<td>Active</td>
					<td><a href="#">MANAGE ESTABLISHMENT</a></td>			
					<input type="hidden" name="subsPlanID" value="<?php echo $each_transac->id; ?>"/>
					<td></td>
				</tr> -->
				<?php 			
				foreach($transactions as $key => $each_transac):  ?>
					<?php $plan = Plan::find_by_id($each_transac->plan_id); ?>
					<?php //$stripeSubs = \Stripe\Subscription::retrieve($each_transac->stripe_id); ?>
					<?php $stripeSubs = stripeHasSubscription($each_transac->stripe_id, $each_transac->id); ?>
					<?php //$stripeSubs->cancel(array('at_period_end' => true));?>
					<?php //$stripeSubs->plan = $plan->id; $stripeSubs->save(); ?>
					
					<tr>
						<?php $updated_transact = SubsPlan::find_by_id($each_transac->id); ?>
						<td><?php echo $plan->toString(); ?></td>
						<td><?php echo $updated_transact->status; ?></td>
						<td><a href="manageEstab.php?sbscrbdID=<?php echo urlencode($each_transac->id); ?>">MANAGE ESTABLISHMENT</a></td>			
						<input type="hidden" name="subsPlanID" value="<?php echo $each_transac->id; ?>"/>
						<td>
						
						<?php 
							if ($stripeSubs !== false) {
								if ($stripeSubs->cancel_at_period_end === true) {
								?><form action="cancelSubscription.php?id=<?php echo urlencode($each_transac->id); ?>&opt=REACT" method="POST">
									<input type="submit" name="submit" value="REACTIVATE RECURRING"/>
								<?php 
									//echo "REACTIVATE RECURRING";
								} else {
								?><form action="cancelSubscription.php?id=<?php echo urlencode($each_transac->id); ?>&opt=CANCEL" method="POST">
									<input type="submit" name="submit" value="CANCEL AT PERIOD END"/>
								<?php
									//echo "CANCEL AT PERIOD END";
								}
							} else {
								?><form action="cancelSubscription.php?id=<?php echo urlencode($each_transac->id); ?>&opt=RENEW" method="POST">
									<input type="submit" name="submit" value="RENEW"/>
								<?php
									//echo "RENEW";
							}
						?>

						</form></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

	</div>
	<?php include '../includes/footer.php'; ?>		
	</body>
</html>