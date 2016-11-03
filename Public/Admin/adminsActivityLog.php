<?php require_once('../../includes/initialize.php'); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user->user_type != "SUPERADMIN" ? redirect_to("../index.php") : null;	

	if (isset($_GET['id'])) {
		$selected_user = User::find_by_id($_GET['id']);
		if ($selected_user->user_type != "ADMIN") redirect_to('manageAdmins.php');
		$all_user_activities =  array_reverse(MapprActLog::find_all(array('key'=>'user_id', 'value'=>$selected_user->id, 'isNumeric'=>true)));
	} else {
		redirect_to('manageAdmins.php');
	}


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

	if($page > $no_of_pages) redirect_to("?id=" . $_GET['id']);

	$offset = $pagination->offset();
	
	$user_activities = MapprActLog::getRecords($per_page, $offset, $selected_user->id);
	// die($offset);
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
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
			<div class="panel panel-warning">
				<div class="panel-heading"><h1 class="heading-label"><span class="glyphicon glyphicon-list"></span>  Admins Activity Log</h1></div>
				<div class="panel-body">
				<h3>
				[<?php echo strtoupper(htmlentities($selected_user->full_name())); ?>]</h3>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>	

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
										    <a href="?id=<?php echo $_GET['id']; ?>&page=<?php echo $page - 1; ?>" aria-label="Previous">
										    	<span aria-hidden="true">&laquo;</span>
									    	</a>
									    </li>
									<?php } ?>
									<?php for ($i=1; $i <= $no_of_pages; $i++) { ?>
								    	<li>
								    		<a class="<?php echo ($page == $i ? "selected" : ""); ?>" href="?id=<?php echo $_GET['id']; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
							    		</li>
								    <?php } ?>
									<?php if($pagination->has_next_page()) { ?>
									    <li>
									      <a href="?id=<?php echo $_GET['id']; ?>&page=<?php echo $page + 1; ?>" aria-label="Next">
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
		<?php include '../../includes/footer.php'; ?>	
	</body>
</html>