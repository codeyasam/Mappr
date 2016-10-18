<?php require_once("../includes/initialize.php"); ?>
<?php  
	$output = '{';
	if (isset($_GET['searchStr'])) {
		$searchStr = $database->escape_value(trim($_GET['searchStr']));
		$estabs = Establishment::find_like_name($searchStr);
		$output .= createJSONEntity("Suggestions", $estabs);
	}

	$output .= '}';
	echo $output;
?>