<?php require_once("../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("login.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$all_user_activities = array_reverse(MapprActLog::find_all(array('key'=>'user_id', 'value'=>$user->id, 'isNumeric'=>true)));

	//current page number
	$page = !empty($_GET['page']) ? $_GET['page'] : 1; 
	//records per page
	$per_page = 10;
	// die($page);

	//total count of photos
	$total_count = count($all_user_activities);
	//Find all photos 
	//use pagination instead

	$pagination = new Pagination($page, $per_page, $total_count);

	$no_of_pages = $pagination->total_pages();

	if($page > $no_of_pages) redirect_to("../activitylogSummary.php");

	$offset = $pagination->offset();
	
	$user_activities = MapprActLog::getRecords($per_page, $offset, $user->id);
	// die($offset);
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php include '../includes/styles.php'; ?>
	</head>
		<header>
			<div class="center">			
				<?php include("../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="banner"></div>
		<div class="container center">
			<div class="panel panel-default">
				<div class="panel-heading"><h1 class="heading-label">Activity Log</h1></div>
				<div class="panel-body">
				</div>	

				<table class="data table table-hover">
					<tr>
						<th>Description</th>
						<th>Date and Time</th>
					</tr>
					<?php foreach($user_activities as $key => $each_activity): ?>
						<tr>
							<td><?php echo htmlentities($each_activity->description); ?></td>
							<td><?php echo htmlentities(format_date($each_activity->processed_date)); ?></td>
						</tr>
					<?php endforeach; ?>
					<?php if ($no_of_pages > 1): ?>	
						<tr>
							<td colspan="100%" class="text-center">
								<nav aria-label="Page navigation">
								  <ul class="pagination">
								    <?php if($pagination->has_previous_page()) { ?>
										<li>
										    <a href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
										    	<span aria-hidden="true">&laquo;</span>
									    	</a>
									    </li>
									<?php } ?>
									<?php for ($i=1; $i <= $no_of_pages; $i++) { ?>
								    	<li>
								    		<a class="<?php echo ($page == $i ? "selected" : ""); ?>" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
							    		</li>
								    <?php } ?>
									<?php if($pagination->has_next_page()) { ?>
									    <li>
									      <a href="?page=<?php echo $page + 1; ?>" aria-label="Next">
									        <span aria-hidden="true">&raquo;</span>
									      </a>
									    </li>
								    <?php } ?>
								  </ul>
								</nav>
							</td>
						</tr>
					<?php endif; ?>
				</table>		
			</div>
		</div>	
		<?php include '../includes/footer.php'; ?>	
	</body>
</html>