<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class MapprBookmark extends DatabaseObject {

		protected static $table_name = "BOOKMARK_TB";
		protected static $db_fields = array("user_id", "branch_id");

		public $user_id;
		public $branch_id;
	}
?>