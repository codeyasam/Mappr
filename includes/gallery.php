<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class EstabGallery extends DatabaseObject {

		protected static $table_name = "GALLERY_TB";
		protected static $db_fields = array('id', 'estab_id', 'gallery_pic');

		public $id;
		public $estab_id;
		public $gallery_pic;
	}
?>