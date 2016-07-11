<?php require_once("../includes/initialize.php"); ?>
<?php  

	if (isset($_POST['submit'])) {

		if ($_POST['hasReview'] == "false") {
			$branch_review = new BranchReview();		
			$branch_review->branch_id = isset($_POST['branch_id']) ? trim($_POST['branch_id']) : "";
			$branch_review->rating = isset($_POST['rating']) ? trim($_POST['rating']) : "";
			$branch_review->user_id = isset($_POST['user_id']) ? trim($_POST['user_id']) : "";
			$branch_review->comment = isset($_POST['comment']) ? trim($_POST['comment']) : "";
			$branch_review->submit_date = time(); //strftime("%Y-%m-%d %H:%M:%S", time());//get_mysql_datetime(time());

			
			if ($branch_review->create()) {
				echo '{"success":"true"}';
			} else {
				echo '{"success":"false"}';
			}
		} else {
			//update
			$user_id = $database->escape_value($_POST['user_id']);
			$branch_id = $database->escape_value($_POST['branch_id']);
			$result_array = BranchReview::find_by_sql("SELECT * FROM REVIEW_TB WHERE user_id = " . $user_id . " AND branch_id = " . $branch_id);
			$branch_review = !empty($result_array) ? array_shift($result_array) : false;
			
			if ($branch_review) {
				$branch_review->rating = isset($_POST['rating']) ? trim($_POST['rating']) : "";
				$branch_review->comment = isset($_POST['comment']) ? trim($_POST['comment']) : "";
				$branch_review->submit_date = time(); //strftime("%Y-%m-%d %H:%M:%S", time()); //get_mysql_datetime(time());
				
				if ($branch_review->update()) {
					echo '{"success":"true"}';
				} else {
					echo '{"success":"false"}';
				}
			}
		}

	} else echo '{"success":"false"}'; 


//	if (isset($_GET['try'])) {
		// $branch_review = new BranchReview();		
		// $branch_review->branch_id = "1";
		// $branch_review->rating = "4";
		// $branch_review->user_id = "2";
		// $branch_review->comment = "Goodone";
		// $branch_review->submit_date = get_mysql_datetime(time());		
		// $branch_review->create();

		// $user_id = 2;
		// $branch_id = 1;
		// $result_array = BranchReview::find_by_sql("SELECT * FROM REVIEW_TB WHERE user_id = " . $user_id . " AND branch_id = " . $branch_id);
		// $branch_review = !empty($result_array) ? array_shift($result_array) : false;
		// print_r($result_array);
		// if ($branch_review) {
		// 	$branch_review->rating = "5";
		// 	$branch_review->comment = "YEAH YEAH";
		// 	$branch_review->submit_date = get_mysql_datetime(time());
			
		// 	if ($branch_review->update()) {
		// 		echo '{"success":"true"}';
		// 	} else {
		// 		echo '{"success":"false"}';
		// 	}
		// }	
//	}
?>