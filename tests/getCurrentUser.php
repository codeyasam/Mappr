<?php require_once("../includes/initialize.php"); ?>
<?php  
	if (isset($_GET['user_id'])) {
		$user = User::find_by_id($_GET['user_id']);
		echo "{" . $user->toJSON() . "}";	
	}
	
?>