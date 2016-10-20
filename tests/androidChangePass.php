<?php  require_once("../includes/initialize.php"); ?>
<?php  
	if ($_POST['submit']) {
		$oldPass = md5($_POST['oldPass']);
		$newPass = md5($_POST['newPass']);
		$userId  = $_POST['userId'];

		$user = User::find_by_id($userId);
		if ($user->password != $oldPass) {
			echo '{"success":"false", "msg":"wrong old password"}';
		} else {
			$user->password = $newPass;
			$user->update();
			echo '{"success":"true"}';
		}
	} else {
		echo '{"success":"false"}';
	}
?>