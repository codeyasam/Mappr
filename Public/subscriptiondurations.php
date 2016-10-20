<?php require_once("../includes/initialize.php"); ?>
<?php  
	$plan_durations = PlanDuration::find_all(array('key'=>'duration_visibility', 'value' => 'VISIBLE', 'isNumeric' => false));
	//$plan_durations = array("monthly", "yearly", "weekly");
?>


<div class="panel panel-warning drop-shadow">
	<div class="panel-heading"><h1 class="heading-label"><span class="glyphicon glyphicon-bookmark"></span> Choose a Subscription</h1></div>
	<div class="subscriptions panel-body">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	</div>
	<div class="subscriptions panel-body">
		<?php foreach($plan_durations as $key => $each_plan_duration): ?>
			<div class="clearfix subscription">
				<img style="float:left; clear: both; padding: 10px;" src="<?php echo 'images/' . htmlentities($each_plan_duration->description) . '.png'; ?>">			
				<a href="subscriptionplans.php?type=<?php echo urlencode($each_plan_duration->id); ?>"><h3 style="text-transform: capitalize;"><?php echo htmlentities($each_plan_duration->description); ?></h3></a>			
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. <a href="subscriptionplans.php?type=<?php echo urlencode($each_plan_duration->id); ?>">More details...</a>	</p>

			</div>
		<!-- 	<div>
				<h3><?php //echo $each_plan_duration ?></h3>
				<a href="subscriptionplans.php?type=<?php //echo urlencode($each_plan_duration); ?>">VIEW</a>
			</div> -->
		<?php endforeach; ?>
	</div>
</div>

