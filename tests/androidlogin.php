<?php require_once("../includes/initialize.php"); ?>
<?php  
	$result = User::authenticate($_GET['username'], $_GET['password']);
	echo $result ? '{"result":"true", "user_id":"'. $result->id .'"}' : '{"result":"false"}';
?>