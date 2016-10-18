<?php  
	require_once('includes/initialize.php');

	$output = "{";
	
	
	if (isset($_POST['test'])) {
		$jsonHours = json_decode($_POST['jsonHours']);

		foreach ($jsonHours as $key => $jsonHour) {
			//var_dump($jsonHour->branch_id);
			$branchHour = new BranchHours();
			$branchHour->branch_id = $jsonHour->branch_id;
			$branchHour->day_no = $jsonHour->day_no;
			$branchHour->opening_hour = $jsonHour->opening_hour;
			$branchHour->closing_hour = $jsonHour->closing_hour;

			$result = BranchHours::find_branch_day_hours($branchHour->branch_id, $branchHour->day_no); 
			if ($result) {
				$branch_id = $database->escape_value($branchHour->branch_id);
				$day_no = $database->escape_value($branchHour->day_no);
				$whereClause = "WHERE branch_id = " . $branch_id . " AND day_no = " . $day_no;
				$branchHour->customUpdate($whereClause);
			} else {
				$branchHour->create();	
			} 
		}
		
		$output .= '"process": "dumaan dito"';
	}

	$output .= "}";

	echo $output;
?>