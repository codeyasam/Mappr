<?php require_once('../includes/initialize.php'); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php"); ?>
<?php  
	$output = "{";
	if (isset($_POST['changePass'])) {
		$oldPass = md5(trim($_POST['oldPass']));
		if ($oldPass != $user->password) {
			$output .= '"changePass":"false"';
		} else {
			$newPass = md5(trim($_POST['newPass']));
			$user->password = $newPass;
			$user->update();
			$output .= '"changePass":"true"';

			MapprActLog::recordActivityLog("Changed Password", $user->id);

		}
	}
	$output .= "}";
	echo $output;
?>