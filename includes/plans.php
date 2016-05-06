<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php require_once(LIB_PATH . DS . "planDuration.php"); ?>
<?php  
	class Plan extends DatabaseObject {

		protected static $table_name = "PLAN_TB";
		protected static $db_fields = array("id", "duration_id","estab_no", "branch_no", "cost", "visibility");

		public $id;
		//public $name;
		public $duration_id;
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

		public function toString() {
			$durationObj = PlanDuration::find_by_id($this->duration_id);
			return $durationObj->description . " with " . $this->estab_no . " Business and a total of " . $this->branch_no . " branches";			
		}

		//override
		function toJSON() {
			$fValueArr = array();
			$fValue = "";
			foreach ($this->getFields() as $key => $eachField) {
				if ($eachField == "duration_id") {
					$planDuration = PlanDuration::find_by_id($this->duration_id);
					$fValue = $planDuration->description;
				} else {
					$fValue = $this->$eachField;						
				}
				$fValueArr[] = '"' . $eachField . '":"' . $fValue . '"';				
			}

			return join(",",$fValueArr);
		}		
	}
?>