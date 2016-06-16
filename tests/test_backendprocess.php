<?php require_once("../includes/initialize.php"); ?>
<?php  
	// if (isset($_POST['testlang'])) {
	// 	echo "poop";
	// 	print_r($_FILES['file']);		
	// }
	
	// $searchString = "Mcdo jollibee";
	// $arrayString = explode(" ", $searchString);

	// $sanitized_array = array_map(function($eachVal) { global $database; return $database->escape_value($eachVal); }, $arrayString);

	// echo "<pre>";
	// 	print_r($sanitized_array);
	// echo "</pre>";

	$sql  = "SELECT b.id as 'branch_id', b.estab_id as 'estab_id', b.address, b.lat, b.lng, ";
	$sql .= "e.category_id, e.name, e.display_picture ";
	$sql .= "FROM BRANCHES_TB b, ESTABLISHMENT_TB e, CATEGORY_TB c ";
	$sql .= "WHERE ";
	$sql .= "e.id = b.estab_id ";

	$mapprPlotter = new MapprPlotRetriever();
	$mapprPlotter->setMarkerOptions($sql);

	// $objArr = MapprPlotRetriever::find_by_sql($sql);
	// echo "<pre>";
	// 	print_r($objArr);
	// echo "</pre>";	
?>