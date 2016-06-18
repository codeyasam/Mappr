<?php require_once("../includes/initialize.php"); ?>
<?php  
	$user_id = $database->escape_value($_GET['user_id']);
	$sql  = "SELECT b.id as 'branch_id', b.estab_id as 'estab_id', b.address, b.lat, b.lng, ";
	$sql .= "e.category_id, e.name, e.display_picture ";
	$sql .= "FROM BRANCHES_TB b, ESTABLISHMENT_TB e, BOOKMARK_TB f ";
	$sql .= "WHERE f.user_id = " . $user_id . " ";
	$sql .= "AND f.branch_id = b.id";

	$mapprPlotter = new MapprPlotRetriever();
	$mapprPlotter->setMarkerOptions($sql);

	echo $mapprPlotter->getJSONOutput();


	//debugging
	// echo "<pre>";
	// 	print_r($mapprPlotter->branchObjArr);
	// 	print_r($mapprPlotter->estabObjArr);
	// echo "</pre>";
	//end 
?>