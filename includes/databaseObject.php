<?php require_once(LIB_PATH.DS."database.php"); ?>
<?php  
	
	abstract class DatabaseObject {

		protected static $table_name;
		protected static $db_fields = array();

		//Common Database Methods //Late static binding
		public static function find_by_id($id="") {
			global $database;
			$id = $database->escape_value($id);
			$result_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id = '{$id}'");
			return !empty($result_array) ? array_shift($result_array) : false;
		}

		public static function find_by_sql($sql) {
			global $database;
			$result_set = $database->query($sql);
			$object_array = array();
			while ($row = $database->fetch_array($result_set)) {
		
				$object_array[] = static::instantiate($row);
			}
			return $object_array;
		}

		public static function find_all($condition = "") {
			return static::find_by_sql("SELECT * FROM " . static::$table_name . ($condition != "" ? " WHERE " . $condition['key'] . "=" . ($condition['isNumeric'] ? $condition['value'] : "'" . $condition['value'] . "'") : ""));
		}

		public static function delete_all($condition = "") {
			global $database;
			$database->query("DELETE FROM " . static::$table_name . ($condition != "" ? " WHERE " . $condition['key'] . "=" . ($condition['isNumeric'] ? $condition['value'] : "'" . $condition['value'] . "'") : ""));
			return $database->affected_rows() == 1 ? true : false;
		}

		public static function delete_by_id($id) {
			global $database;
			$id = $database->escape_value($id);
			static::delete_by_sql("DELETE FROM " . static::$table_name . " WHERE id = '{$id}'");
			return $database->affected_rows() == 1 ? true : false ;
		}

		public static function delete_by_sql($sql) {
			global $database;
			$database->query($sql);
		}

		public static function instantiate($record, $modifiedId = null) {
			// get the class name php 5
			$class_name = get_called_class();
			$object = new $class_name;

			foreach ($record as $attribute => $value) {
				if ($object->has_attribute($attribute)) {
					$object->$attribute = $value;
				}
			}

			if (!empty($modifiedId)) {
				$object->id = $modifiedId;
			}
			return $object;
		}

		public function has_attribute($attribute) {
			$object_vars = $this->attributes();
			return array_key_exists($attribute, $object_vars);
		}	

		public function attributes() {
			// return an array of attribute keys and their values
			$attributes = array();
			foreach (static::$db_fields as $field) {
				if (property_exists($this, $field)) {
					$attributes[$field] = $this->$field;
				}
			}
			return $attributes;
		}	

		protected function sanitized_attributes() {
			global $database;
			$clean_attributes = array();
			//sanitize the values before submitting
			foreach ($this->attributes() as $key => $value) {
				$clean_attributes[$key] =  $database->escape_value($value);
			}
			return $clean_attributes;
		}

		public function create() {
			global $database;

			$attributes = $this->sanitized_attributes();

			$sql  = "INSERT INTO " . static::$table_name . "(";
			$sql .= join(",", array_keys($attributes));
			$sql .= ") VALUES ('";
			$sql .= join("','", array_values($attributes));
			$sql .= "');";
			if ($database->query($sql)) {
				$this->id = $database->insert_id();
				return true;
			} else {
				return false;
			}
		}

		public function update($id="") {
			global $database;

			$attributes = $this->sanitized_attributes();
			$attribute_pairs = array();

			foreach ($attributes as $key => $value) {
				$attribute_pairs[] = "{$key} = '{$value}'";
			}

			$sql  = "UPDATE " . static::$table_name . " SET ";
			$sql .= join(", ", $attribute_pairs);
			if (!empty($id))
				$sql .= "WHERE id = '" . $database->escape_value($id) . "'";
			else
				$sql .= "WHERE id = '" . $database->escape_value($this->id) . "'";

			$database->query($sql);
			return ($database->affected_rows() == 1) ? true : false;
		}

		public function customUpdate($whereClause) {
			global $database;

			$attributes = $this->sanitized_attributes();
			$attribute_pairs = array();

			foreach ($attributes as $key => $value) {
				$attribute_pairs[] = "{$key} = '{$value}'";
			}

			$sql  = "UPDATE " . static::$table_name . " SET ";
			$sql .= join(", ", $attribute_pairs);			
			$sql .= $whereClause;
			$database->query($sql);	
			return ($database->affected_rows() == 1) ? true : false;
		}

		function getFields() {
			return static::$db_fields;
		}		

		function toJSON() {
			$fValueArr = array();
			foreach ($this->getFields() as $key => $eachField) {
				$fValueArr[] = '"' . $eachField . '":"' . $this->$eachField . '"';
			}

			return join(",",$fValueArr);
		}

		public static function find_all_associative($associative = array()) {
			global $database;
			//var_dump($associative);

			$sql  = "SELECT * FROM " . static::$table_name . " ";
			$sql .= "WHERE ";
			$sqlArray = array();
			foreach ($associative as $key => $value) {
				$sqlArray[] = $key . " = '" . $database->escape_value($value) . "'";
			}
			$sql .= static::getConditions($associative);
			return static::find_by_sql($sql);
		}

		public static function getConditions($associative) {
			global $database;

			$sqlArray = array();
			foreach ($associative as $key => $value) {
				$sqlArray[] = $key . " = '" . $database->escape_value($value) . "'";
			}
			return join(' AND ', $sqlArray);			
		}		

	}
?>