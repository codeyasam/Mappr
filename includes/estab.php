<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class Establishment extends DatabaseObject {

		protected static $table_name = "ESTABLISHMENT_TB";
		protected static $db_fields = array("id", "owner_id", "category_id",
											"name", "display_picture", "tags",
											"description");

		public $id;
		public $owner_id;
		public $category_id;
		public $name;
		public $display_picture = "DISPLAY_PICTURES/defaultestab.png";
		public $tags;
		public $description;
	}
?>