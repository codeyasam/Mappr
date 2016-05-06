<?php require_once("../includes/initialize.php"); ?>
<?php  
	$plan_durations = PlanDuration::find_all();
?>
<?php foreach($plan_durations as $key => $each_plan_duration): ?>
	<div>
		<h3><?php echo htmlentities($each_plan_duration->description); ?></h3>
		<a href="subscriptionplans.php?type=<?php echo urlencode($each_plan_duration->id); ?>">VIEW</a>			
	</div>
<?php endforeach; ?>