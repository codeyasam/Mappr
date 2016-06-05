<?php require_once("../includes/initialize.php"); ?>
<?php  
	$branch_id = $database->escape_value($_GET['branch_id']);
	$branch = EstabBranch::find_by_id($branch_id);
	$estab = Establishment::find_by_id($branch->estab_id);
	$gallery = EstabGallery::find_by_sql("SELECT g.gallery_pic FROM GALLERY_TB g, BRANCHES_GALLERY_TB b WHERE g.id = b.gallery_id AND b.branch_id = " . $branch_id);
	$jsonString  = '"branch":{' . $branch->toJSON() . '}, "estab":{' . $estab->toJSON() . '},';
	$jsonString .= !empty($gallery) ? createJSONEntity("Gallery", $gallery) : '"Gallery":[]';
	echo '{' . $jsonString . '}';
?>