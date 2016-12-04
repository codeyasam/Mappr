<?php require_once("../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? redirect_to("index.php") : null; ?>
<?php 
	if (isset($_GET['code'])) {
		$users = User::find_all(array('key'=>'verification_key', 'value'=>$_GET['code'], 'isNumeric'=>false));
		if ($users) {
			$found_user = array_shift($users);
			$found_user->verification_key = "";
			$found_user->update();
			MapprActLog::recordActivityLog("Verified Account.", $found_user->id);
			redirect_to('login.php?verfication=true');
		}	
	} 
	redirect_to('index.php');
?>