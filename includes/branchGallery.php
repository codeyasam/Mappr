<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class BranchGallery extends DatabaseObject {

		protected static $table_name = "BRANCHES_GALLERY_TB";
		protected static $db_fields = array('id', 'branch_id', 'gallery_id');

		public $id;
		public $branch_id;
		public $gallery_id;

		// public static function allGalleryId($arrObj) {
		// 	return array_map(function($obj) { return $obj->gallery_id }, $arrObj);
		// }				
	}
?>
