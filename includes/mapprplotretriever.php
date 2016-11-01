<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>
<?php  
	class MapprPlotRetriever {

		// protected static $db_fields = array('branch_id', 'estab_id', 'address', 
		// 								    'lat', 'lng', 'owner_id', 'category_id',
		// 								    'name', 'display_picture', 'description', 'tags');

		// public $branch_id; //branch id
		// public $estab_id;
		// public $address;
		// public $lat;
		// public $lng;
		// public $owner_id;
		// public $category_id;
		// public $name;
		// public $display_picture;
		// public $description;
		// public $tags;

		public $branchObjArr = array();
		public $estabObjArr = array();

		public function getMarkerOptionsTest($sql) {
			$objArr = MapprPlotRetriever::find_by_sql($sql);
			echo "<pre>";
				print_r($objArr);
			echo "</pre>";
		}

		public function setMarkerOptions($sql) {
			global $database;
			$result_set = $database->query($sql);
			$estab_id_array = array();
			while ($row = $database->fetch_array($result_set)) {
				$this->branchObjArr[] = EstabBranch::instantiate($row, $row['branch_id']);	
				if (!in_array($row['estab_id'], $estab_id_array)) {
					$this->estabObjArr[] = Establishment::instantiate($row, $row['estab_id']);
					$estab_id_array[] = $row['estab_id'];
				}
			}
			// echo "<pre>";
			// 	print_r($this->estabObjArr);
			// 	print_r($this->branchObjArr);
			// echo "</pre>";
		}

		public function getJSONOutput() {
			return "{" . createJSONEntity("Branches", $this->branchObjArr) . ","
		. createJSONEntity("Establishments", $this->estabObjArr) . "}";
		}
	}
?>