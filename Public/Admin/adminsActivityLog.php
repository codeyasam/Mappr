<?php require_once('../../includes/initialize.php'); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user->user_type != "SUPERADMIN" ? redirect_to("../index.php") : null;	

	if (isset($_GET['id'])) {
		$selected_user = User::find_by_id($_GET['id']);
		if ($selected_user->user_type != "ADMIN") redirect_to('manageAdmins.php');
		$user_activities = MapprActLog::find_all(array('key'=>'user_id', 'value'=>$selected_user->id, 'isNumeric'=>true));
	} else {
		redirect_to('manageAdmins.php');
	}
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
				<div class="panel-heading"><h1 class="heading-label"><span class="glyphicon glyphicon-list"></span> Admins Activity Log</h1></div>
				<div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>	

				<table class="data table table-hover">
					<tr>
						<th>DESCRIPTION</th>
						<th>DATETIME</th>
					</tr>

					<?php foreach($user_activities as $key => $each_activity): ?>
						<tr>
							<td><?php echo htmlentities($each_activity->description); ?></td>
							<td><?php echo htmlentities(format_date($each_activity->processed_date)); ?></td>
						</tr>
					<?php endforeach; ?>
				</table>		
			</div>
		</div>	
		<?php include '../../includes/footer.php'; ?>	
	</body>
</html>