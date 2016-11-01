<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class EstabBranch extends DatabaseObject {

		protected static $table_name = "BRANCHES_TB";
		protected static $db_fields = array("id", "estab_id", "address",
											"lat", "lng", "description", "contact_number");

		public $id;
		public $estab_id;
		public $address;
		public $lat;
		public $lng;
		public $description = "none";
		public $contact_number = "none";
	}
?>