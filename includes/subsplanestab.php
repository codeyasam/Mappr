<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>

<?php  
	
	class SubsPlanEstab extends DatabaseObject {

		protected static $table_name = "SUBSPLAN_ESTAB_TB";
		protected static $db_fields = array("id", "subs_plan_id", "estab_id");

		public $id;
		public $subs_plan_id;
		public $estab_id;
	}
?>