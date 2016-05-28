<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class EstabCategory extends DatabaseObject {

		protected static $table_name = "CATEGORY_TB";
		protected static $db_fields = array("id", "name", "featured_category", "description");


		public $id;
		public $name;
		public $featured_category = "FEATURED";
		public $description;

		// already generalized by the database object using late static binding
		// function getFields() {
		// 	return self::$db_fields;
		// }
	}
?>    