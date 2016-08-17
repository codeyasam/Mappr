<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>

<?php  
	class BranchHours extends DatabaseObject {
		
		protected static $table_name = "BUSINESS_HOURS_TB";
		protected static $db_fields = array("id", "day_no", "branch_id", "opening_hour", "closing_hour");		
		
		public $id;
		public $day_no;
		public $branch_id;
		public $opening_hour;
		public $closing_hour;
	}
?>