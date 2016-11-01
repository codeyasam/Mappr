<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php require_once(LIB_PATH . DS . "functions.php"); ?>
<?php  
	class BranchReview extends DatabaseObject {

		protected static $table_name = "REVIEW_TB";
		protected static $db_fields = array('id', 'user_id', 'branch_id', 'rating', 'comment', 'submit_date');

		public $id;
		public $user_id;
		public $branch_id;
		public $rating;
		public $comment;
		public $submit_date;

		public static function getBranchReview($branch_id) {
			global $database;

			$userArrObj = array();
			$reviewArrObj = array();

			$branch_id = $database->escape_value($branch_id);
			$sql = "SELECT e.id as 'user_id', e.first_name, e.last_name, e.display_picture, r.id as 'review_id', r.branch_id, r.rating, r.comment, r.submit_date FROM REVIEW_TB r, END_USER_TB e, BRANCHES_TB b WHERE b.id = " . $branch_id . " AND r.user_id = e.id AND r.branch_id = b.id";
			$result_set = $database->query($sql);
			$reviews_count = $database->num_rows($result_set);
			if ($reviews_count == 0) return false;
			
			$average_rating = 0;

			while($row = $database->fetch_array($result_set)) {
				$userArrObj[] = User::instantiate($row, $row['user_id']);
				$reviewArrObj[] = BranchReview::instantiate($row, $row['review_id']);
				$average_rating += $row['rating'];
			}

			$average_rating = (float)$average_rating / $reviews_count;

			$jsonString  = createJSONEntity("Reviews", $reviewArrObj) . ", ";
			$jsonString .= createJSONEntity("Users", $userArrObj) . ", ";
			$jsonString .= '"average_rating":' . '"' . $average_rating . '", ';
			return $jsonString; 
		}

		public static function delete_by_branch_id($branch_id) {
			global $database;
			$branch_id = $database->escape_value($branch_id);

			$sql  = "DELETE FROM " . static::$table_name . " ";
			$sql .= "WHERE branch_id = " . $branch_id;
			$database->query($sql);			
		}

	}
?>