<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>

<?php  
	class BranchHours extends DatabaseObject {
		
		protected static $table_name = "BUSINESS_HOURS_TB";
		protected static $db_fields = array("day_no", "branch_id", "opening_hour", "closing_hour");		
		
		public $day_no;
		public $branch_id;
		public $opening_hour;
		public $closing_hour;

		public static function find_branch_day_hours($branch_id, $day_no) {
			global $database;
			$branch_id = $database->escape_value($branch_id);
			$day_no = $database->escape_value($day_no);

			$sql  = "SELECT * FROM BUSINESS_HOURS_TB ";
			$sql .= "WHERE branch_id = " . $branch_id . " AND day_no = " . $day_no;

			$result_array = static::find_by_sql($sql);
			return !empty($result_array) ? array_shift($result_array) : false;
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