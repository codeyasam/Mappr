<?php require_once("../includes/initialize.php"); ?>
<?php  
	$output = "{";
	if (isset($_GET['createBranch'])) {
		$branch = new EstabBranch();
		$branch->estab_id = $_GET['estabID'];
		$branch->address = $_GET['addr'];
		$branch->lat = $_GET['lat'];
		$branch->lng = $_GET['lng'];
		$branch->create();

		//Restriction on number of Branches

		//

		$output .= '"newBranch":true,';
		$output .= '"id":' .  $branch->id . ',';
		$output .= '"address":' . '"' . $branch->address . '",';	
		$output .= '"lat":' . $branch->lat . ',';
		$output .= '"lng":' . $branch->lng . ',';	
		branchSelected($branch->id);	
		
	} else if (isset($_GET['updateBranch'])) {
		$branch = EstabBranch::find_by_id($_GET['branchID']);
		$branch->address = $_GET['addr'];
		$branch->lat = $_GET['lat'];
		$branch->lng = $_GET['lng'];
		$branch->update();	

		$output .= '"updateBranch":true,';
		$output .= '"id":' . $_GET['branchID'] . ',';
		$output .= '"address":' . '"' . $branch->address . '",';	

		branchSelected($_GET['branchID']);		

	} else if (isset($_GET['deleteBranch'])) {
		$branchID = $database->escape_value($_GET['branchID']);
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
	} else if (isset($_GET['saveBranchAddr'])) {
		$branch = EstabBranch::find_by_id($_GET['branchID']);
		$branch->address = trim($_GET['address']);
		$branch->update();

		$output .= '"updatedAddr":' . '"' . $branch->address . '"';
	} else if (isset($_GET['addPhoto'])) {
		$newPhoto = new BranchGallery();
		$newPhoto->branch_id = $_GET['branchID'];
		$newPhoto->gallery_id = $_GET['galleryID'];
		$newPhoto->create();

		$output .= '"photoAddedID":' . $newPhoto->id . ',';
		branchSelected($_GET['branchID']);
	} else if (isset($_GET['removePhoto'])) {
		BranchGallery::delete_by_id($_GET['galleryID']);
	}

	if (isset($_GET['branchSelected'])) {
		branchSelected($_GET['branchID']);
	}


	$output .= "}";
	echo $output;
	
	function branchSelected($branchID = "") {
		global $database;
		global $output;
		
		$estabID = $database->escape_value($_GET['estabID']);
		$estabGal = EstabGallery::find_all(array("key" => "estab_id", "value" => $estabID, "isNumeric"=>true));
		$branchGal = BranchGallery::find_all(array("key" => "branch_id", "value" => $branchID, "isNumeric"=>true));
		$output .= createJSONEntity("Gallery", $estabGal) . ',';
		$output .= createJSONEntity("BranchGallery", $branchGal) . ',';
		$output .= '"BranchID":'  . $branchID; //$_GET['branchID'];

	}
?>