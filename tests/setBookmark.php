<?php require_once("../includes/initialize.php"); ?>
<?php  
	if ($_POST['submit']) {
		$user_id = $database->escape_value($_POST['user_id']);
		$branch_id = $database->escape_value($_POST['branch_id']);
		$result_array = MapprBookmark::find_by_sql("SELECT * FROM BOOKMARK_TB WHERE user_id = " . $user_id . " AND branch_id = " . $branch_id);

		$bookmark = !empty($result_array) ? array_shift($result_array) : false;

		if ($bookmark) {
			MapprBookmark::delete_by_sql("DELETE FROM BOOKMARK_TB WHERE user_id = " . $user_id . " AND branch_id = " . $branch_id);
			echo '{"success":"delete"}';
		} else {
			$bookmark = new MapprBookmark();
			$bookmark->user_id = $database->escape_value($_POST['user_id']);
			$bookmark->branch_id = $database->escape_value($_POST['branch_id']);
			$bookmark->create();
			echo '{"success":"create"}';
		}
		
	} else echo '{"success":"false"}';


?>