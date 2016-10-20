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

		public static function recordActivityLog($mDescription, $mUserId) {
			$actLog = new MapprActLog();
			$actLog->user_id = $mUserId;
			$actLog->description = $mDescription;
			$actLog->processed_date = get_mysql_datetime(time());
			$actLog->create();
		}
	}
?>