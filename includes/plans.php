<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php require_once(LIB_PATH . DS . "planDuration.php"); ?>
<?php  
	class Plan extends DatabaseObject {

		protected static $table_name = "PLAN_TB";
		protected static $db_fields = array("id", "plan_name", "plan_interval", "estab_no", "branch_no", "cost", "visibility", "custom_interval", "interval_count");

		public static $plan_names = array(
			'day' => "daily",
			'week' => "weekly",
			'month' => "monthly",
			'year' => "yearly",
			'other' => "other plans",
		);

		public $id;
		//public $name;
		public $plan_interval;
		public $plan_name;
		public $estab_no;
		public $branch_no;
		public $cost;
		public $visibility = "VISIBLE";
		
		//For Custom Plan Duration - 3 days, 5 weeks, 4 months etc
		public $custom_interval = "";
		public $interval_count = "";
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

		public function getFields() {
			return array("id", "plan_name", "plan_interval", "estab_no", "branch_no", "cost", "visibility"); 
		}

		//Override
		public function toJSON() {
			$fValueArr = array();
			foreach ($this->getFields() as $key => $eachField) {
				if ($eachField == "plan_interval") {
					$obj = PlanDuration::find_by_id($this->$eachField);
					if ($obj->duration_name == "other") {
						//$durationObj = PlanDUration::find_by_id($this->custom_interval);
						$promptInterval = "every " . $this->interval_count . " " . $this->custom_interval;
						$fValueArr[] = '"' . $eachField . '":"' . $promptInterval . '"';
					} else {
						$fValueArr[] = '"' . $eachField . '":"' . $obj->description . '"';	
					}
				} else if ($eachField == "cost") {
					$fValueArr[] = '"' . $eachField . '":"' . (int)number_format($this->$eachField, 2, ".", ",") . '"';
				} else {
					$fValueArr[] = '"' . $eachField . '":"' . $this->$eachField . '"';		
				}
				
			}

			return join(",",$fValueArr);
		}

		public function toString() {
			return $this->estab_no . " ESTABLISHMENTS, " . $this->branch_no . " BRANCHES PER BUSINESS";
		}

	}
?>