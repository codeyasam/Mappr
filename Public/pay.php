<?php require_once("../includes/initialize.php"); ?>

<?php  
	PaypalMappr::reviewPayment($_GET['planID'], $_GET['userID']);
?>