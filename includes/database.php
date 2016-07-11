<?php require_once(LIB_PATH . DS . "db_config.php"); ?>
<?php  
	
	class MYSQLIDatabase {
		// define connection, last_query, magic_quotes_active
		// and real_escape_string_exists;
		
		private $connection;
		public $last_query;
		private $magic_quotes_active;
		private $real_escape_string_exists;

		function __construct() {
			//open connection
			$this->open_connection();
			//set magic_quotes_active = get_magic_quotes_gpc();
			$this->magic_quotes_active = get_magic_quotes_gpc();
			//check real escape string if function exists
			$this->real_escape_string_exists = function_exists("mysqli_real_escape_string");	
		}

		public function open_connection() {
			//use mysql_connection give the 3 arguments to parameters
			$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);	
			//check if connection does not exist
			if (!$this->connection) {
				die("Database connection failed " . mysqli_connect_error($this->connection));
			} else {
				// perform mysqli_select_db() then pass 2 arguments db name and connection
				$db_select = mysqli_select_db($this->connection, DB_NAME);
				//if there is not a database selected 
				if (!$db_select) {
					die("Database connection failed: ". mysqli_connect_error($this->connection));
				}
			}
		}

		public function close_connection() {
			//if connection isset
			if (isset($this->connection)) {
				// close connection
				mysqli_close($this->connection);
				// unset the connection
				unset($this->connection);
			}
		}

		public function query($sql) {
			// set last query equal to sql
			$this->last_query = $sql;
			$result = mysqli_query($this->connection, $sql);
			$this->confirm_query($result);
			return $result;
		}

		public function confirm_query($result) {
			// if there is not result or if result is false
			if (!$result) {
				$output = "Database query failed: " . mysqli_error($this->connection) .
				"<br/> <br/>";
				$output .= "Last SQL Query: " . $this->last_query;
				die($output);
			}
		}

		public function escape_value($value) {
			// if PHP >= v4.3.0
			// if real_escape etc function exist
			if ($this->real_escape_string_exists) {
				// magic quotes are active ?
				if ($this->magic_quotes_active) {
					//undo it by using stripslahes para di doble
 					$value = stripslashes($value);
				}
				//then gamitin na ung real_escape_string
				$value = mysqli_real_escape_string($this->connection, $value);
			} else {
				//pag sa lower version at di pa nag eexist ung real_escape etc
				if (!$this->magic_quotes_active) {
					$value = addslashes($value);
				}	
			}
			return $value;
		}

		//database neutral methods.
		public function fetch_assoc($result_set) {
			return mysqli_fetch_assoc($result_set);
		}

		public function fetch_array($result_set) {
			return mysqli_fetch_array($result_set);
		}

		public function num_rows($result_set) {
			return mysqli_num_rows($result_set);
		}

		//get last inserted id
		public function insert_id() {
			return mysqli_insert_id($this->connection);
		}

		public function affected_rows() {
			return mysqli_affected_rows($this->connection);
		}
	}

	//create an instance of the database
	$database = new MYSQLIDatabase();	
?>
