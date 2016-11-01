<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php require_once(LIB_PATH . DS . "plans.php"); ?>
<?php require_once(LIB_PATH . DS . "subsplanestab.php"); ?>
<?php  
	class SubsPlan extends DatabaseObject {
		
		protected static $table_name = "SUBSCRIBED_PLAN";	
		protected static $db_fields = array("id", "owner_id", "plan_id", "status", "stripe_id");

		public $id;
		public $owner_id;
		public $plan_id;
		public $status = "ACTIVE"; //TERMINATED
		public $stripe_id;

		//for performance purposes
		public static function get_owner_subscriptions($owner_id) {
			global $database;
			$owner_id = $database->escape_value($owner_id);
			return SubsPlan::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE owner_id=" . $owner_id);
		}

		public static function deleteNonExistentPlans($transactions, $condition) {
			global $database;
			foreach ($transactions as $key => $each_transac) {
				$plan = Plan::find_by_id($each_transac->plan_id);
				if (!$plan) {
					SubsPlan::delete_by_id($each_transac->id);
					SubsPlanEstab::delete_all(array("key" => "subs_plan_id", "value" => $database->escape_value($each_transac->id) , "isNumeric" => true));
				}
			}

			return self::find_all($condition);
		}
	}
?>