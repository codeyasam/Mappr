<?php require_once("../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("login.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user_activities = MapprActLog::find_all(array('key'=>'user_id', 'value'=>$user->id, 'isNumeric'=>true));
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php include '../includes/styles.php'; ?>
	</head>
	<body>
		<header>
			<div class="center">			
				<?php include("../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="container center">
			<div class="panel-heading"><h1 class="heading-label">Activity Log</h1></div>
			<div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>	

			<table class="data">
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
		<?php include '../includes/footer.php'; ?>	
	</body>
</html>