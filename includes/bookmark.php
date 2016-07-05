<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class MapprBookmark extends DatabaseObject {

		protected static $table_name = "BOOKMARK_TB";
		protected static $db_fields = array("user_id", "branch_id");

		public $user_id;
		public $branch_id;

		public static function delete_by_branch_id($branch_id) {
			global $database;
			$branch_id = $database->escape_value($branch_id);

			$sql  = "DELETE FROM " . static::$table_name . " ";
			$sql .= "WHERE branch_id = " . $branch_id;
			$database->query($sql);
		}

	}
?>