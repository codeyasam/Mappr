<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php require_once(LIB_PATH . DS . "planDuration.php"); ?>
<?php  
	class Plan extends DatabaseObject {

		protected static $table_name = "PLAN_TB";
		protected static $db_fields = array("id", "plan_interval","estab_no", "branch_no", "cost", "visibility");

		public $id;
		//public $name;
		public $plan_interval;
		public $estab_no;
		public $branch_no;
		public $cost;
		public $visibility = "VISIBLE";
		//public $days_no;

		public static function find_by_duration($duration_id) {
			global $database;	
			$duration_id = $database->escape_value($duration_id);

			$sql  = "SELECT * FROM " . self::$table_name . " ";
			$sql .= "WHERE duration_id = '" . $duration_id . "'";

			return self::find_by_sql($sql); 
		} 
	}
?>