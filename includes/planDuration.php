<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>

<?php  
	class PlanDuration extends DatabaseObject {
		protected static $table_name = "PLAN_DURATION_TB";

		protected static $db_fields = array("id", "duration_name", "description", "duration_visibility");

		public $id;
		public $duration_name;
		public $description;
		public $duration_visibility;

		public static function find_by_duration_name($d_name) {
			global $database;
			$d_name = $database->escape_value($d_name);
			$objArr = self::find_all(array("key" => "duration_name", "value" => $d_name, "isNumeric" => false));

			return !empty($objArr) ? array_shift($objArr) : false;
		}
	}
?>