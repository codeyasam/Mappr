<?php require_once("../includes/initialize.php"); ?>
<?php  
	$plan_durations = PlanDuration::find_all(array('key'=>'duration_visibility', 'value' => 'VISIBLE', 'isNumeric' => false));
	//$plan_durations = array("monthly", "yearly", "weekly");

?>


<div class="panel panel-default drop-shadow">
	<div class="panel-heading"><h1 class="heading-label"><span class="glyphicon glyphicon-bookmark"></span> Choose a Subscription</h1></div>
	<div class="subscriptions panel-body">

	</div>
	<div class="subscriptions panel-body">
		<?php foreach($plan_durations as $key => $each_plan_duration): ?>
			<div class="clearfix subscription drop-shadow">
				<img style="float:left; clear: both; padding: 10px;" src="<?php echo 'images/' . htmlentities($each_plan_duration->duration_name) . '.png'; ?>">			
				<a href="subscriptionplans.php?type=<?php echo urlencode($each_plan_duration->id); ?>"><h3><?php echo cym_decode_unicode(Plan::$plan_names[htmlentities($each_plan_duration->duration_name)]); ?></h3></a>			
				<p><?php echo cym_decode_unicode($each_plan_duration->description); ?> <a href="subscriptionplans.php?type=<?php echo urlencode($each_plan_duration->id); ?>">More&nbsp;details...</a></p>

			</div>
		<!-- 	<div>
				<h3><?php //echo $each_plan_duration ?></h3>
				<a href="subscriptionplans.php?type=<?php //echo urlencode($each_plan_duration); ?>">VIEW</a>
			</div> -->
		<?php endforeach; ?>
	</div>
</div>

