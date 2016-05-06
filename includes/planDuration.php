<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>

<?php  
	class PlanDuration extends DatabaseObject {
		protected static $table_name = "PLAN_DURATION_TB";

		protected static $db_fields = array("id", "description", "days_no");

		public $id;
		public $description;
		public $days_no;
	}
?>