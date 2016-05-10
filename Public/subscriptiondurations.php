<?php require_once("../includes/initialize.php"); ?>
<?php  
	$plan_durations = PlanDuration::find_all(array('key'=>'duration_visibility', 'value' => 'VISIBLE', 'isNumeric' => false));
	//$plan_durations = array("monthly", "yearly", "weekly");
?>
<?php foreach($plan_durations as $key => $each_plan_duration): ?>
	<div>
		<h3><?php echo htmlentities($each_plan_duration->description); ?></h3>
		<a href="subscriptionplans.php?type=<?php echo urlencode($each_plan_duration->id); ?>">VIEW</a>			
	</div>
<!-- 	<div>
		<h3><?php //echo $each_plan_duration ?></h3>
		<a href="subscriptionplans.php?type=<?php //echo urlencode($each_plan_duration); ?>">VIEW</a>
	</div> -->
<?php endforeach; ?>