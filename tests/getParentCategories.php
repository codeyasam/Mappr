<?php require_once("../includes/initialize.php"); ?>
<?php  
	$objArr = EstabCategory::getParentCategories();
	echo "{" . createJSONEntity("ParentCategories", $objArr) . "}";	
?>