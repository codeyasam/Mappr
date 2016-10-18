<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class MapprActLog extends DatabaseObject {

		protected static $table_name = "ACTIVITY_LOG_TB";
		protected static $db_fields = array("id", "user_id", "description", "processed_date");
		
		public $id;
		public $user_id;
		public $description;
		public $processed_date;

		
	}
?>