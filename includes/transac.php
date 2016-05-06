<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class Transact extends DatabaseObject {

		protected static $table_name = "TRANSACTION_LOG_TB";
		protected static $db_fields = array("id", "subs_plan_id", "processed_date");

		public $id;
		public $subs_plan_id;
		public $processed_date;
	}
?>