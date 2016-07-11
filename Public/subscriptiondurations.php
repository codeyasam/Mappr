<?php require_once("../includes/initialize.php"); ?>
<?php  
	$plan_durations = PlanDuration::find_all(array('key'=>'duration_visibility', 'value' => 'VISIBLE', 'isNumeric' => false));
	//$plan_durations = array("monthly", "yearly", "weekly");
?>
<div class="subscriptions">
	<?php foreach($plan_durations as $key => $each_plan_duration): ?>
		<div class="clearfix">
			<img style="float:left; clear: both; padding: 10px;" src="<?php echo 'images/' . htmlentities($each_plan_duration->description) . '.png'; ?>">			
			<a href="subscriptionplans.php?type=<?php echo urlencode($each_plan_duration->id); ?>"><h3><?php echo htmlentities($each_plan_duration->description); ?></h3></a>			
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua.</p>
		</div>
	<!-- 	<div>
			<h3><?php //echo $each_plan_duration ?></h3>
			<a href="subscriptionplans.php?type=<?php //echo urlencode($each_plan_duration); ?>">VIEW</a>
		</div> -->
	<?php endforeach; ?>
</div>
