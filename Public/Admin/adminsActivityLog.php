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
	</head>
	<body>
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
	</body>
</html>