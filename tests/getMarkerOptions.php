<?php require_once("../includes/initialize.php"); ?>
<?php  
	defined('MAPPR_OPT') ? null : define('MAPPR_OPT', 'MAPPR_OPT'); 
	defined('OPT_BY_QRCODE') ? null : define('OPT_BY_QRCODE', '111');
	defined('OPT_BY_CATEGORY') ? null : define('OPT_BY_CATEGORY', '777');
	defined('OPT_BY_STRING') ? null : define('OPT_BY_STRING', '888');
	defined('BRANCH_ID') ? null : define('BRANCH_ID', 'branch_id');
	defined('CATEGORY_ID') ? null : define('CATEGORY_ID', 'category_id');
	defined('SEARCH_STRING') ? null : define('SEARCH_STRING', 'search_string');

	if (isset($_GET[MAPPR_OPT])) {
		if ($_GET[MAPPR_OPT] == OPT_BY_QRCODE) {
			$branch_id = $database->escape_value($_GET[BRANCH_ID]);
			$branch = EstabBranch::find_by_id($branch_id);
			// $objArr = EstabBranch::find_all(array('key' => 'estab_id', 'value' => $branch->estab_id, 'isNumeric' => true));
			// $estabObjArr = Establishment::find_all(array('key' => 'id', 'value' => $branch->estab_id, 'isNumeric' => true));
			$sql  = "SELECT b.id as 'branch_id', b.estab_id as 'estab_id', b.address, b.lat, b.lng, ";
			$sql .= "e.category_id, e.name, e.display_picture, e.description ";
			$sql .= "FROM BRANCHES_TB b, ESTABLISHMENT_TB e, SUBSCRIBED_PLAN sp, SUBSPLAN_ESTAB_TB se ";
			$sql .= "WHERE b.estab_id = " . $branch->estab_id . " ";
			$sql .= "AND b.estab_id = e.id ";
			$sql .= "AND sp.status = 'ACTIVE' AND sp.id = se.subs_plan_id AND b.estab_id = se.estab_id ";

		} else if ($_GET[MAPPR_OPT] == OPT_BY_CATEGORY) {
			$category_id = $database->escape_value($_GET[CATEGORY_ID]);
			
			$sql  = "SELECT b.id as 'branch_id', b.estab_id as 'estab_id', b.address, b.lat, b.lng, ";
			$sql .= "e.category_id, e.name, e.display_picture, e.description ";
			$sql .= "FROM BRANCHES_TB b, ESTABLISHMENT_TB e, CATEGORY_TB c, SUBSCRIBED_PLAN sp, SUBSPLAN_ESTAB_TB se ";
			$sql .= "WHERE c.id = e.category_id ";
			$sql .= "AND e.id = b.estab_id ";
			$sql .= "AND c.id = " . $category_id . " ";
			$sql .= "AND sp.status = 'ACTIVE' AND sp.id = se.subs_plan_id AND b.estab_id = se.estab_id ";
			// $objArr = EstabBranch::find_by_sql($sql);
			// $estabObjArr = Establishment::find_all(array('key' => 'category_id', 'value' => $category_id, 'isNumeric' => true));

		} else if ($_GET[MAPPR_OPT] == OPT_BY_STRING) {
			$search_string = $database->escape_value($_GET[SEARCH_STRING]);
			
			$sql  = "SELECT b.id as 'branch_id', b.estab_id as 'estab_id', b.address, b.lat, b.lng, ";
			$sql .= "e.category_id, e.name, e.display_picture, e.description ";
			$sql .= "FROM BRANCHES_TB b, ESTABLISHMENT_TB e, SUBSCRIBED_PLAN sp, SUBSPLAN_ESTAB_TB se ";
			$sql .= "WHERE e.name LIKE " . "'%{$search_string}%' ";
			$sql .= "AND b.estab_id = e.id ";
			$sql .= "AND sp.status = 'ACTIVE' AND sp.id = se.subs_plan_id AND b.estab_id = se.estab_id ";
		}

		$mapprPlotter = new MapprPlotRetriever();
		$mapprPlotter->setMarkerOptions($sql);

		echo $mapprPlotter->getJSONOutput();
	}
?>