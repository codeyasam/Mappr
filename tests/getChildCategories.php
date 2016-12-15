<?php require_once("../includes/initialize.php"); ?>
<?php  
	$objArr = EstabCategory::getChildFeaturedCategories();
	echo "{" . createJSONEntity("ChildFeaturedCategories", $objArr) . "}";	
?>