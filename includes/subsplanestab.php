<?php require_once(LIB_PATH . DS . "database.php"); ?>
<?php require_once(LIB_PATH . DS . "databaseObject.php"); ?>

<?php  
	
	class SubsPlanEstab extends DatabaseObject {

		protected static $table_name = "SUBSPLAN_ESTAB_TB";
		protected static $db_fields = array("id", "subs_plan_id", "estab_id");

		public $id;
		public $subs_plan_id;
		public $estab_id;

		public static function get_total_branch_plotted($id) {
			$subsPlanEstabs = SubsPlanEstab::find_all(array('key' => 'subs_plan_id', 'value' => $id, 'isNumeric' => true));

			$total = 0;
			foreach ($subsPlanEstabs as $key => $eachObj) {
				$total += count(EstabBranch::find_all(array('key' => 'estab_id', 'value' => $eachObj->estab_id, 'isNumeric' => true)));

			}

			return $total;
 		}		
	}
?>