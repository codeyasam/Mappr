<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class SubsPlan extends DatabaseObject {
		
		protected static $table_name = "SUBSCRIBED_PLAN";	
		protected static $db_fields = array("id", "owner_id", "plan_id",
											"date_start", "date_end", "status");

		public $id;
		public $owner_id;
		public $plan_id;
		public $date_start;
		public $date_end;
		public $status = "ACTIVE"; //TERMINATED
		
		//for performance purposes
		public static function get_owner_subscriptions($owner_id) {
			global $database;
			$owner_id = $database->escape_value($owner_id);
			return SubsPlan::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE owner_id=" . $owner_id);
		}
	}
?>