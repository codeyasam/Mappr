<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class User extends DatabaseObject {

		protected static $table_name = "END_USER_TB";
		protected static $db_fields = array('id', 'email', 'username', 'password', 'first_name',
											'last_name', 'contact', 'hometown', 'display_picture', 
											'user_type', 'stripe_id');

		public $id;
		public $email;
		public $username;
		public $password;
		public $first_name;
		public $last_name;
		public $contact = "none";
		public $hometown = "none";
		public $display_picture = "DISPLAY_PICTURES/defaultavatar.png";	
		public $user_type = "USER";
		public $stripe_id;

		public function full_name() {
			if (isset($this->first_name) && isset($this->last_name)) {
				return $this->first_name . " " . $this->last_name;
			} else {
				return "";
			}
		}

		public static function authenticate($username="", $password="") {
			global $database;
	
			$username = $database->escape_value($username);
			$password = $database->escape_value($password);

			$password = md5($password);
			$sql  = "SELECT * FROM " . self::$table_name . " ";
			$sql .= "WHERE (BINARY username = '{$username}' OR BINARY email = '{$username}') ";
			$sql .= "AND BINARY password = '{$password}' ";
			$sql .= "LIMIT 1 ";

			$result_array = self::find_by_sql($sql);
			return !empty($result_array) ? array_shift($result_array) : false;
		}	

		//For both username and email 
		public static function hasExisting($entry, $columnName) {
			global $database;

			$entry = $database->escape_value($entry);
			$columnName = $database->escape_value($columnName);

			$sql  = "SELECT * FROM " . self::$table_name . " ";
			$sql .= "WHERE " . $columnName . " = '{$entry}' ";

			$result_array = self::find_by_sql($sql);
			return !empty($result_array) ? true : false;
		}
		

		public static function page_redirect($id="") {
			$user = self::find_by_id($id);
			self::designated_page($user->user_type);
		}	

		public static function designated_page($access_level) {
			if ($access_level == "USER") {
				//redirect_to("index.php");
			} else if ($access_level == "ADMIN") {
				redirect_to("Admin/index.php");
			} else if ($access_level == "OWNER") {
				redirect_to("index.php");
			}
		}	

		public static function check_username_format($str) {
			global $errors;
			$pattern = '/[\p{L}]+/u';

			$str = preg_replace($pattern, "", $str);
			echo $str;
			$result = !empty($str) ? false : true; 
			if (!$result) $errors[] = "invalid username format";
			return $result;
		}					

		public static function check_existing($str, $columnName, $msg) {
			global $errors;
			$result = static::hasExisting($str, $columnName);
			if ($result) $errors[] = $msg; 
			return $result;
		}
		
	}
?>
