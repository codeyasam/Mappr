<?php require_once("../includes/initialize.php"); ?>
<?php 
	$branch_id = $database->escape_value($_GET['branch_id']);
	$jsonString = BranchReview::getBranchReview($branch_id);
	echo "{" . $jsonString . "}"; 
?>
