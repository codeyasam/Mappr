<?php require_once("../includes/initialize.php"); ?>
<?php  
	if (isset($_GET['getUser'])) {
		$userId = $_GET['userId'];
		$user = User::find_by_id($userId);
		echo "{" . $user->toJSON() . "}";
	}
?>