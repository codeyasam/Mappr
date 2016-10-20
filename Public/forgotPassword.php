<?php require_once('../includes/initialize.php'); ?>
<?php  
	if (isset($_POST['resetPass'])) {
		$email = $database->escape_value(trim($_POST['email']));
		$result_array = User::find_all(array('key'=>'email', 'value'=>$email, 'isNumeric'=>false));
		$found_user = array_shift($result_array);
		if ($found_user->reset_code == $_POST['reset_code']) {
			$found_user->password = md5($_POST['newPassword']);
			$found_user->update();
			echo '{"forgotPass":"true"}';
		} else {
			echo '{"forgotPass":"false"}';
		}
	}
?>