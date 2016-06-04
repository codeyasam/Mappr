<?php require_once("../includes/initialize.php"); ?>
<?php  
	defined('MAPPR_OPT') ? null : define('MAPPR_OPT', 'MAPPR_OPT'); 
	defined('OPT_BY_QRCODE') ? null : define('OPT_BY_QRCODE', '111');
	defined('OPT_BY_CATEGORY') ? null : define('OPT_BY_CATEGORY', '777');
	defined('BRANCH_ID') ? null : define('BRANCH_ID', 'branch_id');
	defined('CATEGORY_ID') ? null : define('CATEGORY_ID', 'category_id');
	
	if (isset($_GET[MAPPR_OPT])) {
		if ($_GET[MAPPR_OPT] == OPT_BY_QRCODE) {
			$branch_id = $database->escape_value($_GET[BRANCH_ID]);
			$branch = EstabBranch::find_by_id($branch_id);
			$objArr = EstabBranch::find_all(array('key' => 'estab_id', 'value' => $branch->estab_id, 'isNumeric' => true));
			$estabObjArr = Establishment::find_all(array('key' => 'id', 'value' => $branch->estab_id, 'isNumeric' => true));
		} else if ($_GET[MAPPR_OPT] == OPT_BY_CATEGORY) {
			$category_id = $database->escape_value($_GET[CATEGORY_ID]);
			// $estabs = Establishment::find_all(array('key' => 'category_id', 'value' => $category_id, 'isNumeric' => true));
			// $objArr = array_map(function($obj) { return EstabBranch::find_all(array('key' => 'estab_id', 'value' => $obj->id, 'isNumeric' => true)); }, $estabs);
			$sql  = "SELECT b.id, b.estab_id, b.address, b.lat, b.lng, e.id, e.category_id, c.id ";
			$sql .= "FROM BRANCHES_TB b, ESTABLISHMENT_TB e, CATEGORY_TB c ";
			$sql .= "WHERE c.id = e.category_id ";
			$sql .= "AND e.id = b.estab_id ";
			$sql .= "AND c.id = " . $category_id;
			$objArr = EstabBranch::find_by_sql($sql);
			$estabObjArr = Establishment::find_all(array('key' => 'category_id', 'value' => $category_id, 'isNumeric' => true));
		}

		echo "{" . createJSONEntity("Branches", $objArr) . ","
		. createJSONEntity("Establishments", $estabObjArr) . "}";

	}
?>