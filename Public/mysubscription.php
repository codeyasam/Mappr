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
		<?php include '../includes/styles.php'; ?>
		<link rel="stylesheet" type="text/css" href="js/jquery-ui.css"/>
	</head>
	<body>
	<header>
		<div class="center">			
			<?php include("../includes/navigation.php"); ?>
		</div>
	</header>
	<div class="banner"></div>
	<div class="container center">
		<div class="panel panel-default drop-shadow">
			<div class="panel-heading"><h1 class="heading-label">
				<span class="glyphicon glyphicon-tags"></span> &nbsp;My Subscription</h1>
			</div>
			<div class="panel-body">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
			<?php if (!empty($transactions)) { ?>
				<table id="subsContainer" class="table table-hover data">
					<tr>
						<th>Subscription</th>
						<th>Interval</th>
						<th>Status</th>
						<th>Period End</th>
						<th colspan="3">Options</th>
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
							<td><a style="display: block;margin-top: 5px;" href="manageEstab.php?sbscrbdID=<?php echo urlencode($each_transac->id); ?>"><span class="glyphicon glyphicon-glass"></span> Manage Establishments</a></td>
						<?php } else { ?>
							<td>none</td>
						<?php } ?>					
						<input type="hidden" name="subsPlanID" value="<?php echo $each_transac->id; ?>"/>
						<td>
						
						<?php 
							if ($stripeSubs !== false) {
								if ($stripeSubs->cancel_at_period_end === true) {
								?><form action="cancelSubscription.php?id=<?php echo urlencode($each_transac->id); ?>&opt=REACT" method="POST">
									<input class="reactivateBtn btn btn-primary" type="submit" name="submit" value="Reactivate" data-internalid="cancelSubscription.php?id=<?php echo urlencode($each_transac->id); ?>&opt=REACT"/>
								<?php 
									//echo "REACTIVATE RECURRING";
								} else {
								?><form action="cancelSubscription.php?id=<?php echo urlencode($each_transac->id); ?>&opt=CANCEL" method="POST">
									<input class="cancelPeriodBtn btn btn-danger" type="submit" name="submit" value="Deactivate" data-internalid="cancelSubscription.php?id=<?php echo urlencode($each_transac->id); ?>&opt=CANCEL"/>
								<?php
									//echo "CANCEL AT PERIOD END";
								}
							} else {
								?><form action="cancelSubscription.php?id=<?php echo urlencode($each_transac->id); ?>&opt=RENEW" method="POST">

									<input class="renewBtn btn btn-primary" type="submit" name="submit" value="RENEW" data-internalid="cancelSubscription.php?id=<?php echo urlencode($each_transac->id); ?>&opt=RENEW"/>
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
		<!--Dialog for Renew-->
		<div id="dialog" style="display: none;" title="Confirmation Required">
			<p>Are you sure you want to renew this subscription?</p>
			<form action="" method="POST"> 
				<input id="confirmBtn" type="submit" name="submit" value="OK" />
				<input id="cancelBtn" type="button" value="CANCEL" />
			</form>
		</div>
	</div>
	</div>
	</div>
	<?php include '../includes/footer.php'; ?>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>		
	<script type="text/javascript">
		//dialog for RENEW 
		$('#dialog').dialog({
			autoOpen: false,
			modal: true
		});

		$(document).on('click', '.renewBtn', function(e) {
			e.preventDefault();
			console.log($(this).attr('data-internalid'));
			var actionRenew = $(this).attr('data-internalid');
			$('#dialog > p').text('Are you sure you want to renew this subscription?');
			$('#dialog > form').attr('action', actionRenew);
			$('#dialog').dialog('open');
		});

		$('#cancelBtn').on('click', function() {
			$('#dialog').dialog('close');
		}); 

		$('#confirmBtn').on('click', function() {
			$('#dialog').dialog('close');
		});

		//Dialog for Cancel at Period End
		$(document).on('click', '.cancelPeriodBtn', function(e) {
			e.preventDefault();
			var actionCancelPeriod = $(this).attr('data-internalid');
			$('#dialog > p').text('Are you sure you want to cancel at period? (You may reactivate this again before termination else if terminated, you can renew)');
			$('#dialog > form').attr('action', actionCancelPeriod);
			$('#dialog').dialog('open');
		});

		//Dialog for Reactivate Recurring
		$(document).on('click', '.reactivateBtn', function(e) {
			e.preventDefault();
			var actionReactivate = $(this).attr('data-internalid');
			$('#dialog > p').text('Are you sure you want to reactivate recurring payments? (This wont charge you anything, until the period end to automatically repurchase the subscription)');
			$('#dialog > form').attr('action', actionReactivate);
			$('#dialog').dialog('open');
		});
	</script>	
	</body>
</html>