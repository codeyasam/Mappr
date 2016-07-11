<?php require_once("../includes/initialize.php"); ?>
<?php  
	$objArr = EstabCategory::find_all(array('key' => 'featured_category', 'value' => 'FEATURED', 'isNumeric' => false));
	echo "{" . createJSONEntity("Categories", $objArr) . "}";
?>