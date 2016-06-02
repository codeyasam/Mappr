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

			$output .= '"newBranch":true,';
			$output .= '"id":' .  $branch->id . ',';
			$output .= '"address":' . '"' . $branch->address . '",';	
			$output .= '"lat":' . $branch->lat . ',';
			$output .= '"lng":' . $branch->lng . ',';	
			branchSelected($branch->id, true);
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

	} else if (isset($_POST['deleteBranch'])) {
		$branchID = $database->escape_value($_POST['branchID']);
		$branchGallleries = BranchGallery::find_all(array("key" => "branch_id", "value" => $branchID, "isNumeric"=>true));
		array_map(function($obj) { BranchGallery::delete_by_id($obj->id); }, $branchGallleries);

		$output .= '"setBranchID":false,';
		$output .= '"deleteBranch":true';
		EstabBranch::delete_by_id($branchID);

	} else if (isset($_GET['retrieveBranches'])) {
		$estabID = $database->escape_value($_GET['estabID']);
		$branches = EstabBranch::find_all(array('key'=>'estab_id','value'=>$estabID,'isNumeric'=>true));

		$output .= createJSONEntity("Branches", $branches);
		$estabGal = EstabGallery::find_all(array("key" => "estab_id", "value" => $estabID, "isNumeric"=>true));
		$output .= ",";
		$output .= createJSONEntity("Gallery", $estabGal);		
	} else if (isset($_POST['saveBranchAddr'])) {
		$branch = EstabBranch::find_by_id($_POST['branchID']);
		$branch->address = trim($_POST['address']);
		$branch->update();

		$output .= '"updatedAddr":' . '"' . $branch->address . '"';
	} else if (isset($_POST['addPhoto'])) {
		$newPhoto = new BranchGallery();
		$newPhoto->branch_id = $_POST['branchID'];
		$newPhoto->gallery_id = $_POST['galleryID'];
		$newPhoto->create();

		$output .= '"photoAddedID":' . $newPhoto->id . ',';
		branchSelected($_POST['branchID'], true);
	} else if (isset($_POST['removePhoto'])) {
		BranchGallery::delete_by_id($_POST['galleryID']);
	}

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
		//$estabID = $database->escape_value($_GET['estabID']);
		$estabGal = EstabGallery::find_all(array("key" => "estab_id", "value" => $estabID, "isNumeric"=>true));
		$branchGal = BranchGallery::find_all(array("key" => "branch_id", "value" => $branchID, "isNumeric"=>true));
		$output .= createJSONEntity("Gallery", $estabGal) . ',';
		$output .= createJSONEntity("BranchGallery", $branchGal) . ',';
		$output .= '"BranchID":'  . $branchID; //$_GET['branchID'];

	}
?>