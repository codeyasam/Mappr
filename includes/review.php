<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
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
	}
?>