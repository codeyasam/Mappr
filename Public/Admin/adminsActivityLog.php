<?php require_once('../../includes/initialize.php'); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user->user_type != "SUPERADMIN" ? redirect_to("../index.php") : null;	
	
	$selected_user = null;
	if (isset($_GET['id'])) {
		$selected_user = User::find_by_id($_GET['id']);

		if ($selected_user->user_type != "ADMIN" && $selected_user->user_type != "OWNER") redirect_to('manageAdmins.php');
		$all_user_activities =  array_reverse(MapprActLog::find_all(array('key'=>'user_id', 'value'=>$selected_user->id, 'isNumeric'=>true)));

	} else {
		redirect_to('manageAdmins.php');
	}
	
	$access_level_prompt = $selected_user->user_type == "ADMIN" ? "Admins" : "Business Owners";

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

	//if($page > $no_of_pages) redirect_to("?id=" . $_GET['id']);

	$offset = $pagination->offset();
	
	$user_activities = MapprActLog::getRecords($per_page, $offset, $selected_user->id);
	// die($offset);
?>

<?php 
	if (isset($_GET['submit'])) {
		$all_user_activities = MapprActLog::getUserRecords($selected_user->id, $_GET['fromDate'], $_GET['toDate'], $_GET['description']);
		$total_count = count($all_user_activities);
		//echo $total_count;
		$pagination = new Pagination($page, $per_page, $total_count);
		$no_of_pages = $pagination->total_pages();
		//if($page > $no_of_pages) redirect_to("../activitylogSummary.php");
		$offset = $pagination->offset();
		$user_activities = MapprActLog::getRecords($per_page, $offset, $selected_user->id, $_GET['fromDate'], $_GET['toDate'], $_GET['description']);
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
		<link rel="stylesheet" type="text/css" href="../js/jquery-ui.css"/>
		<?php include '../../includes/styles_admin.php'; ?>
	</head>
	<body>
		<header>
			<div class="center">			
				<?php include("../../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="banner"></div>
		<div class="container center">
			<div class="panel panel-default">
				<div class="panel-heading"><h1 class="heading-label"><span class="glyphicon glyphicon-list"></span> <?php echo $access_level_prompt; ?> Activity Log</h1></div>
				<div class="panel-body">
				<h3>[<?php echo strtoupper(cym_decode_unicode($selected_user->full_name())); ?>]</h3>
				</div>	
				<form action="adminsActivityLog.php" method="GET">
					From: <input style="display: inline-block; width: inherit;" class="form-control" type="text" name="fromDate" id="fromDate" /> to <input style="display: inline-block; width: inherit;" class="form-control" name="toDate" type="text" id="toDate" /> 
					<input style="display: inline-block; width: inherit;" class="form-control" id="description" type="text" name="description" placeholder="Enter Key Descriptions" />
					<input style="display: inline-block; width: inherit;" type="submit" class="btn btn-primary" name="submit" value="Search" />
					<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
				</form>
				<?php if ($user_activities) { ?>
				<table class="data table table-hover">
					<tr>
						<th>Description</th>
						<th>Date and Time</th>
					</tr>
					<?php if (!empty($user_activities)): ?>
					<?php foreach($user_activities as $key => $each_activity): ?>
						<tr>
							<td><?php echo cym_decode_unicode($each_activity->description); ?></td>
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
										<a href="?id=<?php echo $_GET['id']; ?>&page=<?php echo $page - 1; ?>&fromDate=<?php echo $_GET['fromDate'] ?>&toDate=<?php echo $_GET['toDate'] ?>&description=<?php echo $_GET['description'] ?>&submit=<?php echo "SEARCH"; ?>" aria-label="Previous">
										    	<span aria-hidden="true">&laquo;</span>
									    	</a>									    
									    <?php } else { ?>
										<a href="?id=<?php echo $_GET['id']; ?>&page=<?php echo $page - 1; ?>" aria-label="Previous">
										    	<span aria-hidden="true">&laquo;</span>
									    	</a>									    
									    <?php } ?>
									    </li>
									<?php } ?>
									<?php for ($i=1; $i <= $no_of_pages; $i++) { ?>
								    	<li>
								    	<?php if (isset($_GET['submit'])) { ?>
								    		<a class="<?php echo ($page == $i ? "selected" : ""); ?>" href="?id=<?php echo $_GET['id']; ?>&page=<?php echo $i; ?>&fromDate=<?php echo $_GET['fromDate'] ?>&toDate=<?php echo $_GET['toDate'] ?>&description=<?php echo $_GET['description'] ?>&submit=<?php echo "SEARCH"; ?>"><?php echo $i; ?></a>
								    	<?php } else { ?>
								    		<a class="<?php echo ($page == $i ? "selected" : ""); ?>" href="?id=<?php echo $_GET['id']; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
							    		<?php } ?>
							    		</li>
								    <?php } ?>
									<?php if($pagination->has_next_page()) { ?>
									    <li>
									    <?php if (isset($_GET['submit'])) { ?>
									      <a href="?id=<?php echo $_GET['id']; ?>&page=<?php echo $page + 1; ?>&fromDate=<?php echo $_GET['fromDate'] ?>&toDate=<?php echo $_GET['toDate'] ?>&description=<?php echo $_GET['description'] ?>&submit=<?php echo "SEARCH"; ?>" aria-label="Next">
									        <span aria-hidden="true">&raquo;</span>
									      </a>									    
									    <?php } else { ?>
									      <a href="?id=<?php echo $_GET['id']; ?>&page=<?php echo $page + 1; ?>" aria-label="Next">
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
					<?php endif; ?>
				</table>
				<div style="padding: 10px;">
					<?php if (isset($_GET['fromDate']) && isset($_GET['toDate']) && isset($_GET['description'])) { ?>
						<a href="activityLogReports.php?id=<?php echo $_GET['id']; ?>&fromDate=<?php echo $_GET['fromDate']; ?>&toDate=<?php echo $_GET['toDate']; ?>&description=<?php echo $_GET['description']; ?>"><span class="glyphicon glyphicon-share-alt"></span> Export Logs</a>
					<?php } else { ?>
						<a href="activityLogReports.php?id=<?php echo $_GET['id']; ?>"><span class="glyphicon glyphicon-share-alt"></span> Export Logs</a>
					<?php } ?>
				</div>					
				<?php } else { ?>
					<p>No result found</p>
				<?php } ?>						
			</div>
		</div>	
		<input id="from_date" type="hidden" value="<?php echo isset($_GET['fromDate']) ? $_GET['fromDate'] : ''; ?>" />
		<input id="to_date" type="hidden" value="<?php echo isset($_GET['toDate']) ? $_GET['toDate'] : ''; ?>" />
		<input id="mDescription" type="hidden" value="<?php echo isset($_GET['description']) ? $_GET['description'] : ''; ?>" />		
		
		<?php include '../../includes/footer.php'; ?>	
		<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
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