<?php require_once("../includes/initialize.php"); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php"); ?>
<?php  
	$output = "{";
	if (isset($_POST['createBranch'])) {
		//Security counter CSRF //a little redundant since attacker wont be able get to the page to do a post in the first place
		$userPlans = SubsPlan::find_all(array('key'=>'owner_id', 'value'=>$user->id, 'isNumeric'=>true));
		$userPlanIDs = array_map(function($obj) { return $obj->id; }, $userPlans);
		if (!in_array($_POST['sbscrbdID'], $userPlanIDs)) redirect_to("index.php");

		//Restriction on number of Branches
		$currentSub = SubsPlan::find_by_id($_POST['sbscrbdID']);
		$currentPlan = Plan::find_by_id($currentSub->plan_id);
		$noUsedBranch = SubsPlanEstab::get_total_branch_plotted($currentSub->id);
		$notPlotableBranch = $currentPlan->estab_no - 1;
		//$plotableBranch = $currentPlan->branch_no - ($notPlotableBranch + $noUsedBranch);
		$plotableBranch = $currentPlan->branch_no - $noUsedBranch;
		//		

		if ($plotableBranch > 0 && in_array($_POST['sbscrbdID'], $userPlanIDs)) {


			$branch = new EstabBranch();
			$branch->estab_id = $_POST['estabID'];
			$branch->address = $_POST['addr'];
			$branch->lat = $_POST['lat'];
			$branch->lng = $_POST['lng'];
			$branch->create();

			$branches = EstabBranch::find_all(array('key'=>'estab_id','value'=>$database->escape_value($_POST['estabID']),'isNumeric'=>true));
			$output .= '"hasBranches":' . count($branches) . ",";

			$output .= '"newBranch":true,';
			$output .= '"id":' .  $branch->id . ',';
			$output .= '"address":' . '"' . $branch->address . '",';	
			$output .= '"lat":' . $branch->lat . ',';
			$output .= '"lng":' . $branch->lng . ',';	
			$output .= '"description":' . '"' . $branch->description . '",';
			$output .= '"contact_number":' . '"' . $branch->contact_number . '",';
			branchSelected($branch->id, true);

			MapprActLog::recordActivityLog("Plotted a branch", $user->id);
		} else {
			$output .= '"limitReached":true';
		}

	
		
	} else if (isset($_POST['updateBranch'])) {
		$branch = EstabBranch::find_by_id($_POST['branchID']);
		$branch->address = $_POST['addr'];
		$branch->lat = $_POST['lat'];
		$branch->lng = $_POST['lng'];
		$branch->update();	

		$output .= '"updateBranch":true,';
		$output .= '"id":' . $_POST['branchID'] . ',';
		$output .= '"address":' . '"' . $branch->address . '",';	

		branchSelected($_POST['branchID'], true);	

		MapprActLog::recordActivityLog("Updated a branch", $user->id);	

	} else if (isset($_POST['deleteBranch'])) {
		$branchID = $database->escape_value($_POST['branchID']);
		$branch = EstabBranch::find_by_id($branchID);
		$branchGallleries = BranchGallery::find_all(array("key" => "branch_id", "value" => $branchID, "isNumeric"=>true));
		array_map(function($obj) { BranchGallery::delete_by_id($obj->id); }, $branchGallleries);

		$output .= '"setBranchID":false,';
		$output .= '"deleteBranch":true,';
		BranchHours::delete_all(array('key'=>'branch_id', 'value'=>$branchID, 'isNumeric'=>true));
		//BranchHours::delete_by_branch_id($branchID);
		BranchReview::delete_by_branch_id($branchID);
		MapprBookmark::delete_by_branch_id($branchID);
		EstabBranch::delete_by_id($branchID);
		$branches = EstabBranch::find_all(array('key'=>'estab_id','value'=>$branch->estab_id,'isNumeric'=>true));
		$output .= '"hasBranches":' . count($branches) . "";	

		MapprActLog::recordActivityLog("Deleted a branch", $user->id);			

	} else if (isset($_GET['retrieveBranches'])) {
		$estabID = $database->escape_value($_GET['estabID']);
		$branches = EstabBranch::find_all(array('key'=>'estab_id','value'=>$estabID,'isNumeric'=>true));
		$estabGal = EstabGallery::find_all(array("key" => "estab_id", "value" => $estabID, "isNumeric"=>true));

		$output .= createJSONEntity("Branches", $branches) . ",";
		$output .= createJSONEntity("Gallery", $estabGal) . ",";
		$output .= '"hasBranches":' . count($branches);		
	} else if (isset($_POST['saveBranchAddr'])) {
		$branch = EstabBranch::find_by_id($_POST['branchID']);
		$branch->address = trim($_POST['address']);
		$branch->update();

		$output .= '"updatedAddr":' . '"' . $branch->address . '"';

		MapprActLog::recordActivityLog("Updated branch address", $user->id);

	} else if (isset($_POST['saveBranchDescription'])) {
		$branch = EstabBranch::find_by_id($_POST['branchID']);
		$branch->description = trim($_POST['description']);
		$branch->update();

		$output .= '"updatedDescription":' . '"' . $branch->description . '"';

		MapprActLog::recordActivityLog("Updated branch description", $user->id);

	} else if (isset($_POST['saveBranchContact'])) {
		$branch = EstabBranch::find_by_id($_POST['branchID']);
		$branch->contact_number = trim($_POST['contact']);
		$branch->update();

		$output .= '"updatedContact":' . '"' . $branch->contact_number . '"';

		MapprActLog::recordActivityLog("Update branch contact number", $user->id);

	} else if (isset($_POST['addPhoto'])) {
		$newPhoto = new BranchGallery();
		$newPhoto->branch_id = $_POST['branchID'];
		$newPhoto->gallery_id = $_POST['galleryID'];
		$newPhoto->create();

		$output .= '"photoAddedID":' . $newPhoto->id . ',';
		branchSelected($_POST['branchID'], true);

		MapprActLog::recordActivityLog("Added a photo to a branch gallery", $user->id);

	} else if (isset($_POST['removePhoto'])) {
		BranchGallery::delete_by_id($_POST['galleryID']);

		MapprActLog::recordActivityLog("Removed a photo from a branch gallery", $user->id);
	} else if (isset($_POST['setBusinessHours'])) {
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
		
		$output .= '"updatedBranchHours": ' . $_POST['jsonHours'];

		MapprActLog::recordActivityLog("Configured Business Hours", $user->id);
	} 
	// else if (isset($_GET['getBranchHours'])) { 
	// 	$branch_id = $database->escape_value($_GET['branch_id']);
	// 	$branchHours = BranchHours::find_all(array('key'=>'branch_id', 'value'=>$branch_id, 'isNumeric'=>true));
	// 	$output .= createJSONEntity("BranchHours", $branchHours);
	// }

	if (isset($_GET['branchSelected'])) {
		branchSelected($_GET['branchID']);
	}


	$output .= "}";
	echo $output;
	
	function branchSelected($branchID = "", $isPOST=false) {
		global $database;
		global $output;
		
		$estabID = $isPOST === true ? $_POST['estabID'] : $_GET['estabID'];
		$estabID = $database->escape_value($estabID);
		$branches = EstabBranch::find_all(array('key'=>'estab_id','value'=> $estabID,'isNumeric'=>true));
		$branchHours = BranchHours::find_all(array('key'=>'branch_id', 'value'=>$branchID, 'isNumeric'=>true));
		$output .= '"hasBranches":' . count($branches) . ",";	
		$output .= '"hasBranchHours":' . count($branchHours) . ","; 	
		//$estabID = $database->escape_value($_GET['estabID']);
		$estabGal = EstabGallery::find_all(array("key" => "estab_id", "value" => $estabID, "isNumeric"=>true));
		$branchGal = BranchGallery::find_all(array("key" => "branch_id", "value" => $branchID, "isNumeric"=>true));
		$output .= createJSONEntity("BranchHours", $branchHours) . ',';
		$output .= createJSONEntity("Gallery", $estabGal) . ',';
		$output .= createJSONEntity("BranchGallery", $branchGal) . ',';
		$output .= '"branchSelected":"true",'; 
		$output .= '"BranchID":'  . $branchID; //$_GET['branchID'];

	}
?>