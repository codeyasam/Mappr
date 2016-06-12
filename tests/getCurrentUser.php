<?php require_once("../includes/initialize.php"); ?>
<?php  
	if (isset($_GET['user_id'])) {
		$user = User::find_by_id($_GET['user_id']);
		$result_array = BranchReview::find_by_sql("SELECT * FROM REVIEW_TB WHERE user_id = " . $user->id);
		$branch_review = !empty($result_array) ? array_shift($result_array) : false;
		$outputString = $user->toJSON();
		if ($branch_review) {
			$outputString .= ', "hasReview":"true", ' . $branch_review->toJSON();
		} else {
			$outputString .= ', "hasReview":"false"';
		}
		echo "{" . $outputString . "}";	
	}
	
?>