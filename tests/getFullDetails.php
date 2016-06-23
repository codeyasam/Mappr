<?php require_once("../includes/initialize.php"); ?>
<?php  
	$branch_id = $database->escape_value($_GET['branch_id']);
	$jsonString = '"isBookmarked":"false",';
	if (isset($_GET['user_id'])) {
		$user_id = $database->escape_value($_GET['user_id']);
		$result_array = MapprBookmark::find_by_sql("SELECT * FROM BOOKMARK_TB WHERE user_id = " . $user_id . " AND branch_id = " . $branch_id);

		$bookmark = !empty($result_array) ? array_shift($result_array) : false;		
		if ($bookmark) {
			$jsonString = '"isBookmarked":"true",';
		}
	}
	$branch = EstabBranch::find_by_id($branch_id);
	$estab = Establishment::find_by_id($branch->estab_id);
	$gallery = EstabGallery::find_by_sql("SELECT g.gallery_pic FROM GALLERY_TB g, BRANCHES_GALLERY_TB b WHERE g.id = b.gallery_id AND b.branch_id = " . $branch_id);
	$reviews = BranchReview::getBranchReview($branch_id);
	if ($reviews) $jsonString .= $reviews;
	$jsonString .= '"branch":{' . $branch->toJSON() . '}, "estab":{' . $estab->toJSON() . '},';
	$jsonString .= !empty($gallery) ? createJSONEntity("Gallery", $gallery) : '"Gallery":[]';
	echo '{' . $jsonString . '}';
?>