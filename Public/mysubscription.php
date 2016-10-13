<?php require_once("../includes/initialize.php"); ?>
<?php 
	$user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php");
	$user = User::find_by_id($session->user_id);
	$condition['key'] = "owner_id";
	$condition['value'] = $user->id;
	$condition['isNumeric'] = true;
	$transactions = SubsPlan::find_all($condition);	
	$transactions = SubsPlan::deleteNonExistentPlans($transactions, $condition);
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
		<link rel="stylesheet" type="text/css" href="js/jquery-ui.css"/>		
		<?php include '../includes/styles.php'; ?>
	</head>
	<body>
	<header>
		<div class="center">			
			<?php include("../includes/navigation.php"); ?>
		</div>
	</header>
	<div class="container center">
		<h1>My Subscription</h1>
		<?php if (!empty($transactions)) { ?>
			<table id="subsContainer" class="data">
				<tr>
					<th>Subscription</th>
					<th>Interval</th>
					<th>Status</th>
					<th>Period End</th>
					<th colspan="3">options</th>
				</tr>

				<?php foreach($transactions as $key => $each_transac):  ?>
					
					<?php $plan = Plan::find_by_id($each_transac->plan_id); ?>
					<?php //$stripeSubs = \Stripe\Subscription::retrieve($each_transac->stripe_id); ?>
					<?php $stripeSubs = stripeHasSubscription($each_transac->stripe_id, $each_transac->id); ?>
					<?php //$stripeSubs->cancel(array('at_period_end' => true));?>
					<?php //$stripeSubs->plan = $plan->id; $stripeSubs->save(); ?>
					
					<tr>
						<?php $updated_transact = SubsPlan::find_by_id($each_transac->id); ?>
						<td><?php echo $plan->toString(); ?></td>
						<td>
							<?php 
								if ($plan->plan_interval == 5) {
									echo cym_decode_unicode("every " . $plan->interval_count . " " . $plan->custom_interval);
								} else {
									$planDuration = PlanDuration::find_by_id($plan->plan_interval);
									echo cym_decode_unicode($planDuration->description);
								}
							?>
							
						</td>
						<td><?php echo $updated_transact->status; ?></td>
						<?php if ($stripeSubs !== false) { ?>
							<td><?php echo format_date(get_mysql_datetime($stripeSubs->current_period_end)); ?></td>
							<td><a href="manageEstab.php?sbscrbdID=<?php echo urlencode($each_transac->id); ?>">MANAGE ESTABLISHMENT</a></td>
						<?php } else { ?>
							<td>none</td>
						<?php } ?>			
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
									<input class="renewBtn" type="submit" name="submit" value="RENEW" data-internalid="cancelSubscription.php?id=<?php echo urlencode($each_transac->id); ?>&opt=RENEW"/>
								<?php
									//echo "RENEW";
							}
						?>

						</form></td>
					</tr>
					
				<?php endforeach; ?>		
			</table>
		<?php } else { ?>
			<p>You dont have any subscriptions yet. <a href="subscription.php">Pick a subscription here.</a></p>
		<?php } ?>
		<div id="dialog" style="display: none;" title="Confirmation Required">
			<p>Are you sure you want to renew this subscription?</p>
			<form action="" method="POST"> 
				<input id="confirmBtn" type="submit" name="submit" value="OK" />
				<input id="cancelBtn" type="button" value="CANCEL" />
			</form>
		</div>
		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>		
		<script type="text/javascript">
			$('#dialog').dialog({
				autoOpen: false,
				modal: true
			});

			$(document).on('click', '.renewBtn', function(e) {
				e.preventDefault();
				console.log($(this).attr('data-internalid'));
				var actionRenew = $(this).attr('data-internalid');
				$('#dialog > form').attr('action', actionRenew);
				$('#dialog').dialog('open');
			});

			$('#cancelBtn').on('click', function() {
				$('#dialog').dialog('close');
			}); 

			$('#confirmBtn').on('click', function() {
				$('#dialog').dialog('close');
			});
		</script>		
		<footer>
			<?php include '../includes/footer.php'; ?>
		</footer>
	</div>
		
	</body>
</html>