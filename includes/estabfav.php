<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class EstabBookmark extends DatabaseObject {

		protected static $table_name = "BOOKMARK_TB";
		protected static $db_fields  = array('user_id', 'estab_id');

		public $user_id;
		public $estab_id;
	}
?>