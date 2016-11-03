<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class MapprActLog extends DatabaseObject {

		protected static $table_name = "ACTIVITY_LOG_TB";
		protected static $db_fields = array("id", "user_id", "description", "processed_date");
		
		public $id;
		public $user_id;
		public $description;
		public $processed_date;

		public static function recordActivityLog($mDescription, $mUserId) {
			$actLog = new MapprActLog();
			$actLog->user_id = $mUserId;
			$actLog->description = $mDescription;
			$actLog->processed_date = get_mysql_datetime(time());
			$actLog->create();
		}
		
		public static function getUserRecords($user_id, $from_date = false, $to_date = false, $mDescription = false) {
			global $database;
			$user_id = $database->escape_value($user_id);
			
			$from_date = $database->escape_value($from_date);
			$to_date = $database->escape_value($to_date);
			$mDescription = $database->escape_value($mDescription);

			$sql  = "SELECT * FROM " . self::$table_name . " ";
			$sql .= "WHERE user_id = " . $user_id . " ";
			if ($from_date) {
				//$sql .= "AND processed_date BETWEEN '" . $from_date. "' AND '". $to_date . "'";
				$sql .= "AND (processed_date >= '" . $from_date. "' AND processed_date <= DATE_ADD('". $to_date . "', INTERVAL 1 DAY))";			
			}
			
			if ($mDescription && !empty($mDescription)) {
				$sql .= " AND description LIKE '%" . $mDescription . "%'";
			}
			
			$temp = self::find_by_sql($sql);
			return count($temp) <= 0 ? false : $temp;					
		}

		public static function getRecords($limit, $offset, $user_id, $from_date = false, $to_date = false, $mDescription = false) {
			global $database;
			$limit = $database->escape_value($limit);
			$offset = $database->escape_value($offset);
			$user_id = $database->escape_value($user_id);
			
			$from_date = $database->escape_value($from_date);
			$to_date = $database->escape_value($to_date);
			$mDescription = $database->escape_value($mDescription);

			$sql  = "SELECT * FROM " . self::$table_name . " ";
			$sql .= "WHERE user_id = " . $user_id . " ";
			if ($from_date) {

				//DATE_ADD(OrderDate,INTERVAL 30 DAY)
				$sql .= "AND (processed_date >= '" . $from_date. "' AND processed_date <= DATE_ADD('". $to_date . "', INTERVAL 1 DAY))";
			}
			
			if ($mDescription && !empty($mDescription)) {
				$sql .= " AND description LIKE '%" . $mDescription . "%'";
			}
			
			$sql .= "ORDER BY id DESC ";
			$sql .= "LIMIT " . $offset . ", ". $limit . " ";
			
			$temp = self::find_by_sql($sql);
			return count($temp) <= 0 ? false : $temp;
		}
	}
?>