<?php require_once("../includes/initialize.php"); ?>
<?php  
	$branch = EstabBranch::find_by_id(8);
	var_dump($branch);
?>