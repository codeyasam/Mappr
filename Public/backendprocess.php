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
		//$noUsedBranch = SubsPlanEstab::get_total_branch_plotted($currentSub->id);
		//$notPlotableBranch = $currentPlan->estab_no - 1;
		//$plotableBranch = $currentPlan->branch_no - ($notPlotableBranch + $noUsedBranch);
		//$plotableBranch = $currentPlan->branch_no - $noUsedBranch;
		//		
		$totalBranches = SubsPlanEstab::get_estab_total_branch($_POST['estabID']);
		if ($totalBranches < $currentPlan->branch_no && in_array($_POST['sbscrbdID'], $userPlanIDs)) {


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
			
			$estab_reference = Establishment::find_by_id($branch->estab_id);
			MapprActLog::recordActivityLog("Plotted a branch of " . $estab_reference->name . " at " . $branch->address . " [branchID - " . $branch->id . "]", $user->id);
		} else {
			$output .= '"limitReached":true';
		}

	
		
	} else if (isset($_POST['updateBranch'])) {
		$branch = EstabBranch::find_by_id($_POST['branchID']);
		$temp_address = $branch->address; 
		$temp_lat = $branch->lat;
		$temp_lng = $branch->lng;
		$branch->address = $_POST['addr'];
		$branch->lat = $_POST['lat'];
		$branch->lng = $_POST['lng'];
		$branch->update();	

		$output .= '"updateBranch":true,';
		$output .= '"id":' . $_POST['branchID'] . ',';
		$output .= '"address":' . '"' . $branch->address . '",';	

		branchSelected($_POST['branchID'], true);	
		$estab_reference = Establishment::find_by_id($branch->estab_id);
		MapprActLog::recordActivityLog("Updated a branch of " . $estab_reference->name . " [branchID - " . $branch->id . "] coordinates from position[" . $temp_lat . "," . $temp_lng . "] to position[" . $branch->lat . "," . $branch->lng . "]", $user->id);	

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
		
		$estab_reference = Establishment::find_by_id($branch->estab_id);
		MapprActLog::recordActivityLog("Deleted a branch of " . $estab_reference->name . " [branchID - " . $branch->id . "]", $user->id);			

	} else if (isset($_GET['retrieveBranches'])) {
		$estabID = $database->escape_value($_GET['estabID']);
		$branches = EstabBranch::find_all(array('key'=>'estab_id','value'=>$estabID,'isNumeric'=>true));
		$estabGal = EstabGallery::find_all(array("key" => "estab_id", "value" => $estabID, "isNumeric"=>true));

		$output .= createJSONEntity("Branches", $branches) . ",";
		$output .= createJSONEntity("Gallery", $estabGal) . ",";
		$output .= '"hasBranches":' . count($branches);		
	} else if (isset($_POST['saveBranchAddr'])) {
		$branch = EstabBranch::find_by_id($_POST['branchID']);
		$temp_address = $branch->address;
		$branch->address = trim($_POST['address']);
		$branch->update();

		$output .= '"updatedAddr":' . '"' . $branch->address . '"';
		$estab_reference = Establishment::find_by_id($branch->estab_id);
		MapprActLog::recordActivityLog("Updated branch address of " . $estab_reference->name . " [branchID - " . $branch->id . "] from " . $temp_address . " to " . $branch->address, $user->id);

	} else if (isset($_POST['saveBranchDescription'])) {
		$branch = EstabBranch::find_by_id($_POST['branchID']);
		$temp_description = $branch->description;
		$branch->description = trim($_POST['description']);
		$branch->update();

		$output .= '"updatedDescription":' . '"' . $branch->description . '"';
		$estab_reference = Establishment::find_by_id($branch->estab_id);
		MapprActLog::recordActivityLog("Updated branch description of " . $estab_reference->name . " [branchID - " . $branch->id . "] from " . $temp_description . " to " . $branch->description, $user->id);

	} else if (isset($_POST['saveBranchContact'])) {
		$branch = EstabBranch::find_by_id($_POST['branchID']);
		$temp_contact = $branch->contact_number;
		$branch->contact_number = trim($_POST['contact']);
		$branch->update();

		$output .= '"updatedContact":' . '"' . $branch->contact_number . '"';
		$estab_reference = Establishment::find_by_id($branch->estab_id);
		MapprActLog::recordActivityLog("Updated branch contact number of " . $estab_reference->name . " [branchID - " . $branch->id . "] from " . $temp_contact . " to " . $branch->contact_number, $user->id);

	} else if (isset($_POST['addPhoto'])) {
		$newPhoto = new BranchGallery();
		$newPhoto->branch_id = $_POST['branchID'];
		$newPhoto->gallery_id = $_POST['galleryID'];
		$newPhoto->create();

		$output .= '"photoAddedID":' . $newPhoto->id . ',';
		branchSelected($_POST['branchID'], true);
		$branch = EstabBranch::find_by_id($_POST['branchID']);
		$estab_reference = Establishment::find_by_id($branch->estab_id);
		MapprActLog::recordActivityLog("Added a photo to a branch gallery of " . $estab_reference->name . " [branchID - " . $branch->id . "]", $user->id);

	} else if (isset($_POST['removePhoto'])) {
		$bGal_ref = BranchGallery::find_by_id($_POST['galleryID']);
		BranchGallery::delete_by_id($_POST['galleryID']);

		$branch = EstabBranch::find_by_id($bGal_ref->branch_id);
		$estab_reference = Establishment::find_by_id($branch->estab_id);
		MapprActLog::recordActivityLog("Removed a photo from a branch gallery of " . $estab_reference->name . " [branchID - " . $branch->id . "]", $user->id);
	} else if (isset($_POST['setBusinessHours'])) {
		$jsonHours = json_decode($_POST['jsonHours']);
		$branch = null;
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
				$branch = EstabBranch::find_by_id($branch_id);
			} else {
				$branchHour->create();	
				$branch = EstabBranch::find_by_id($branchHour->branch_id);
			} 
		}
		
		$output .= '"updatedBranchHours": ' . $_POST['jsonHours'];

		$estab_reference = Establishment::find_by_id($branch->estab_id);
		MapprActLog::recordActivityLog("Configured Branch Business Hours of " . $estab_reference->name . " [branchID - " . $branch->id . "] at " . $branch->address, $user->id);
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