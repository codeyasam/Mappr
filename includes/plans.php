<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php require_once(LIB_PATH . DS . "planDuration.php"); ?>
<?php  
	class Plan extends DatabaseObject {

		protected static $table_name = "PLAN_TB";
		protected static $db_fields = array("id", "plan_name", "plan_interval", "estab_no", "branch_no", "cost", "visibility");

		public $id;
		//public $name;
		public $plan_interval;
		public $plan_name;
		public $estab_no;
		public $branch_no;
		public $cost;
		public $visibility = "VISIBLE";
		//public $days_no;

		public static function BACKUPfind_by_duration($duration_id) {
			global $database;	
			$duration_id = $database->escape_value($duration_id);

			$sql  = "SELECT * FROM " . self::$table_name . " ";
			$sql .= "WHERE duration_id = '" . $duration_id . "'";

			return self::find_by_sql($sql); 
		} 

		public static function find_by_duration($plan_interval) {
			global $database;
			$plan_interval = $database->escape_value($plan_interval);

			$sql  = "SELECT * FROM " . self::$table_name . " ";
			$sql .= "WHERE plan_interval = '" . $plan_interval . "'";

			return self::find_by_sql($sql);
		}

		//Override
		function toJSON() {
			$fValueArr = array();
			foreach ($this->getFields() as $key => $eachField) {
				if ($eachField == "plan_interval") {
					$obj = PlanDuration::find_by_id($this->$eachField);
					$fValueArr[] = '"' . $eachField . '":"' . $obj->description . '"';	
				} else {
					$fValueArr[] = '"' . $eachField . '":"' . $this->$eachField . '"';		
				}
				
			}

			return join(",",$fValueArr);
		}

	}
?>