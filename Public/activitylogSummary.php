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

	if($page > $no_of_pages) redirect_to("activitylogSummary.php");

	$offset = $pagination->offset();
	
	$user_activities = MapprActLog::getRecords($per_page, $offset, $user->id);
	// die($offset);
?>

<?php 
	if (isset($_GET['submit'])) {
		$all_user_activities = array_reverse(MapprActLog::getUserRecords($user->id, $_GET['fromDate'], $_GET['toDate'], $_GET['description']));
		$total_count = count($all_user_activities);
		//echo $total_count;
		$pagination = new Pagination($page, $per_page, $total_count);
		$no_of_pages = $pagination->total_pages();
		if($page > $no_of_pages) redirect_to("activitylogSummary.php");
		$offset = $pagination->offset();
		$user_activities = MapprActLog::getRecords($per_page, $offset, $user->id, $_GET['fromDate'], $_GET['toDate'], $_GET['description']);
		//echo "<pre>";
		//	print_r($user_activities);
		//echo "</pre>";
		//die($offset);
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="js/jquery-ui.css"/>
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

				<div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>	
				
				<form action="activitylogSummary.php" method="GET">
					From: <input class="form-control" style="display: inline-block; width: inherit;" type="text" name="fromDate" id="fromDate" /> to <input style="display: inline-block; width: inherit;" class="form-control" name="toDate" type="text" id="toDate" /> 
					<input class="form-control" style="display: inline-block; width: inherit;" id="description" type="text" name="description" placeholder="enter key descriptions" />
					<input class="btn btn-primary" style="display: inline-block; width: inherit;" type="submit" name="submit" value="SEARCH" />
				</form>
				<?php if ($user_activities) { ?>

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
									    <?php if (isset($_GET['submit'])) { ?>
										<a href="?page=<?php echo $page - 1; ?>&fromDate=<?php echo $_GET['fromDate'] ?>&toDate=<?php echo $_GET['toDate'] ?>&description=<?php echo $_GET['description'] ?>&submit=<?php echo "SEARCH"; ?>" aria-label="Previous">
										    	<span aria-hidden="true">&laquo;</span>
									    	</a>									    
									    <?php } else { ?>
										<a href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
										    	<span aria-hidden="true">&laquo;</span>
									    	</a>									    
									    <?php } ?>									

									    </li>
									<?php } ?>
									<?php for ($i=1; $i <= $no_of_pages; $i++) { ?>
								    	<li>
								    	<?php if (isset($_GET['submit'])) { ?>
								    		<a class="<?php echo ($page == $i ? "selected" : ""); ?>" href="?page=<?php echo $i; ?>&fromDate=<?php echo $_GET['fromDate'] ?>&toDate=<?php echo $_GET['toDate'] ?>&description=<?php echo $_GET['description'] ?>&submit=<?php echo "SEARCH"; ?>"><?php echo $i; ?></a>
								    	<?php } else { ?>
								    		<a class="<?php echo ($page == $i ? "selected" : ""); ?>" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
							    		<?php } ?>
							    		</li>
								    <?php } ?>
									<?php if($pagination->has_next_page()) { ?>
									    <li>
									    <?php if (isset($_GET['submit'])) { ?>
									      <a href="?page=<?php echo $page + 1; ?>&fromDate=<?php echo $_GET['fromDate'] ?>&toDate=<?php echo $_GET['toDate'] ?>&description=<?php echo $_GET['description'] ?>&submit=<?php echo "SEARCH"; ?>" aria-label="Next">
									        <span aria-hidden="true">&raquo;</span>
									      </a>									    
									    <?php } else { ?>
									      <a href="?page=<?php echo $page + 1; ?>" aria-label="Next">
									        <span aria-hidden="true">&raquo;</span>
									      </a>
									    <?php } ?>

									    </li>
								    <?php } ?>
								  </ul>
								</nav>
							</td>
						</tr>
					<?php endif; ?>
				</table>
				<?php } else { ?>
					<p>No result found</p>
				<?php } ?>		
			</div>
		</div>
		<input id="from_date" type="hidden" value="<?php echo isset($_GET['fromDate']) ? $_GET['fromDate'] : ''; ?>" />
		<input id="to_date" type="hidden" value="<?php echo isset($_GET['toDate']) ? $_GET['toDate'] : ''; ?>" />
		<input id="mDescription" type="hidden" value="<?php echo isset($_GET['description']) ? $_GET['description'] : ''; ?>" />	
		
		<?php include '../includes/footer.php'; ?>	
		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript"> 
			$('#fromDate').datepicker(); $('#fromDate').datepicker("setDate", "01/01/2000");
			$( "#fromDate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
			$('#toDate').datepicker(); $('#toDate').datepicker("setDate", "Now");
			$( "#toDate" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
			
			if ($('#from_date').val() != "") $('#fromDate').datepicker("setDate", $('#from_date').val());
			if ($('#to_date').val() != "") $('#toDate').datepicker("setDate", $('#to_date').val());
			if ($('#mDescription').val() != "") $('#description').val($('#mDescription').val());
			
			console.log($('#from_date').val());
			console.log($('#mDescription').val());
		</script>
	</body>
</html>