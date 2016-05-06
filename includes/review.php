<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class EstabReview extends DatabaseObject {

		protected static $table_name = "REVIEW_TB";
		protected static $db_fields = array('user_id', 'estab_id', 'rating', 'comment');

		public $user_id;
		public $estab_id;
		public $rating;
		public $comment;
	}
?>