<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class EstabCategory extends DatabaseObject {

		protected static $table_name = "CATEGORY_TB";
		protected static $db_fields = array("id", "name", "parent_category_id", "featured_category", "display_picture", "description", "categ_order");


		public $id;
		public $name;
		public $featured_category = "FEATURED";
		public $display_picture = "DISPLAY_PICTURES/defaultCategIcon.png";
		public $description;
		public $parent_category_id = "";
		public $categ_order;

		// already generalized by the database object using late static binding
		// function getFields() {
		// 	return self::$db_fields;
		// }

		public function toJSON($customized=false) {
			if ($customized) {
				$fValueArr = array();
				foreach ($this->getFields() as $key => $eachField) {
					if ($eachField == "parent_category_id" && empty($this->$eachField)) {
						$fValueArr[] = '"' . $eachField . '":"Main Category"';
					} else if ($eachField == "parent_category_id") {
						$parent_category = EstabCategory::find_by_id($this->$eachField);
						$fValueArr[] = '"' . $eachField . '":"' . $parent_category->name . '"';
					} else if ($eachField == "categ_order") {
						continue;
					} else {
						$fValueArr[] = '"' . $eachField . '":"' . $this->$eachField . '"';				
					}
				}

				return join(",",$fValueArr);				
			} 
			return parent::toJSON();
		}		

		public static function getParentCategories() {
			$parent_categories = EstabCategory::find_all_associative(array("parent_category_id"=>""));
			return $parent_categories;
		}

		public static function getChildCategories() {
			//global $database;

			$sql  = "SELECT * FROM " . static::$table_name . " ";
			$sql .= "WHERE parent_category_id != ''";

			return static::find_by_sql($sql);
		}

		public static function getChildFeaturedCategories() {
			$sql  = "SELECT * FROM " . static::$table_name . " ";
			$sql .= "WHERE parent_category_id != '' ";
			$sql .= "AND featured_category = 'FEATURED'";

			return static::find_by_sql($sql);			
		}
	}
?>    